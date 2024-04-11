<?php
namespace Tests;
use Tafio\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

trait TemplateTest
{
  public function testCreate(){

    $this->browse(function (Browser $browser) {
      $browser->loginAs(User::find(2));
    });

    foreach ($this->halaman as $halaman)
    {
      
    $cek=$cek2=[];
    foreach($halaman['field'] as $field)
    {  $cek[$field['nama']]=$field['isi'];
      $cek2[$field['nama']]=$field['update'];
    }
         $this->browse(function (Browser $browser) use ($halaman,$cek) {
      $browser->visit($halaman['alamat'])
      ->assertSee('actions');

if($halaman['tambah'])
{      $browser->visit($halaman['alamat'].'/create');
      $browser=$this->input($browser,$halaman['field']);
      $browser->press('simpan')
      ->assertSee('data berhasil disimpan');
    $this->assertDatabaseHas($halaman['table'],$cek );
    $id= $halaman['model']::where($cek)->first();
    $id->delete();
}
});
if($halaman['edit'])
{
    $create= $halaman['model']::create($cek);
    $id_create=$create->id;
// dd($id_create);
    $this->browse(function (Browser $browser) use($id_create,$halaman) {
      $browser->visit($halaman['nama'].'/'.$id_create.'/edit');
      $browser=$this->input($browser,null,$halaman['field']);
      $browser
      ->dump()
      ->press('simpan')
      ->assertSee('actions');
    });
    $this->assertDatabaseHas($halaman['table'], $cek2);
    $create->delete();
}
if($halaman['hapus'])
{
    $create= $halaman['model']::create($cek);
    $id_create=$create->id;

    $this->browse(function (Browser $browser) use($id,$halaman) {
      $browser->press('#'.$id_create)
      ->assertSee('data berhasil dihapus');
    });
    $this->assertDatabaseMissing($halaman['table'],$cek);
  }
}
}
public function input($browser,$field=null,$update=null)
{
  if($field)
  {
    $input=$field;
    $nama='isi';
  }else
  {$nama='update';
    $input=$update;}
    return array_reduce($input, function ($o, $p) use ($nama)
    {
      return $o->type($p['nama'],$p[$nama]);
    },$browser);
  }
}
