<?php





//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{
$ukuran=$cetak->ukuran=$_POST["ukuran"];
$bahan=$cetak->bahan=$_POST["bahan"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$laminasi=$cetak->laminasi=$_POST["laminasi"];
$foil=$cetak->foil=$_POST["foil"];
}

else

{

$ukuran="";
$bahan="";
$jumlah="";
$laminasi="";
$foil="";
}

?>

<a name=hasil></a>
<div id=perhitungankiri>
<div id=perhitunganatas>
<div id=judul_hitung>Hitung harga cetak sertifikat online</div>
<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>
<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>
<input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">
<tr><td><b>ukuran<td> 

<?php 
$pilihan=array("a5"=>"A5 (15x21cm)","a4"=>"A4 (30x21cm)","folio"=>"Folio (33x21cm)","b5"=>"B5 (17x25cm)");
echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 
<tr><td><b>bahan kertas<td>  

<?php 
$pilihan=array("ap260"=>"standar","coronado"=>"import");
echo $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   

<tr>
  <td><b>laminasi<td> 

<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV","glossy1"=>"glossy",

               "dof1"=>"dof");

echo $cetak->form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>   

<tr>
  <td><b>tulisan emas/perak<td>   
<?php 

$pilihan=array("0"=>"tidak pakai","1"=>"pakai");

echo $cetak->form_dropdownx('foil', $pilihan, isset($foil) ? $foil : ''); ?>   

<tr><td>
<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">
</table>
</form>
</div>

<div id=perhitunganbawah></div></div>
<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))
{


if($bahan=="coronado")
$cetak->pengali_print=2.5;

echo $cetak->tampilkan($cetak->cetak_lembaran());

}
?>

<div style="clear:both"></div>



