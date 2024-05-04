<?php

namespace App\Http\Controllers;
use App\Models\company;
use View;

class ContentController extends Controller
{

public $defaultView,$shortCompany,$company,$folder,$menu,$kirim,
$customView;


////////setup awal//////////////////////////////////////////////

public function __construct() {
    



$domain=request()->getHost();
$this->company=company::where('name',$domain)->first();

$this->shortCompany=str_replace('.', '', $domain);


$this->folder='company.'.$this->shortCompany.'.';

$this->kirim['folder']=$this->folder;
$this->kirim['company']=$this->company;




$hasil=[];
foreach($this->company->config as $xx)
{
$hasil[$xx->nama]=$xx->isi;
}
$this->kirim['config']=(object)$hasil;





}
    

public function awal() {
    
$yyy=explode('/',request()->route()->uri);

$jumlahUrl=count($yyy);
$nama=$yyy[0];

$this->menu=$this->company->menu()->where('nama',$nama)->first();


$page=$this->menu->jenis;
$customPage=$nama;

if($page=='content')
{$page='list';
if($jumlahUrl==2)
{$customPage.="Detail";
$page.="Detail";
}
}
else if ($page=='kategori')
{
if($jumlahUrl==2)
{$page.="List";
$customPage.="List";

}else if($jumlahUrl==3)
{
$page.="ListDetail";
$customPage.="ListDetail";
}
}

$this->defaultView= $this->folder.'defaultPages.'.$page;
$this->customView= $this->folder.'customPages.'.$customPage;



}




/////////////////////////////proses route/////////////////////


    public function index()
    {
$this->kirim['content']=$this->company;
return view($this->folder.'defaultPages.home',$this->kirim);
    }
    
    public function content()
     {
$this->awal();

$this->kirim['content']=$this->menu->content;
return $this->tampil();    
     }   
   
     public function kategori()
     {
$this->awal();
$this->kirim['content']=$this->menu->kategori;
return $this->tampil();    
     }   
  

    
    public function single($id=false)
    {
$this->awal();

if(!$id)
$this->kirim['content']=$this->menu->content->first();
else
$this->kirim['content']=$this->menu->content()->find($id);

return $this->tampil();
}





///////////////////// memproses view /////////////////////////

private function tampil()
{
if (View::exists($this->customView)) 
    return view($this->customView,$this->kirim);
else 
    return view($this->defaultView,$this->kirim);
}

}