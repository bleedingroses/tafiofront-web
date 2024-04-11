<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{


$ukuran=$cetak->ukuran=$_POST["ukuran"];
$cover=$cetak->cover=$_POST["cover"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$laminasi=$cetak->laminasi=$_POST["laminasi"];
$jilid=$cetak->jilid=$_POST["jilid"];
$isi=$cetak->isi=$_POST["isi"];
$warna=$cetak->warna=$_POST["warna"];



}

else

{

$cetak="";

$ukuran="";

$cover="";

$jumlah="";

$jilid="";

$laminasi="";

$isi="";

}

?><div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak notes online</div>

<a name=hasil></a>



<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

   

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">



<tr><td><b>cover<td>  




<?php 

$pilihan=array("ap260"=>"softcover","hard"=>"hardcover");

echo $cetak->form_dropdownx('cover', $pilihan,isset($cover) ? $cover : ''); ?> 




?> 



<tr>

  <td><b>laminasi<td>   

<?php 

$pilihan=array(""=>"tanpa laminasi","glossy1"=>"glossy",

               "dof1"=>"dof");

echo $cetak->form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>   

    



<Tr><td><b>isi <td><?php if(!empty($_POST["kirim"]) and !is_numeric($isi)) echo"<div class='peringatan alert alert-danger'>!! isi harus diisi</div>";?>

   

      <input type=text name=isi  class="input-kecil" value="<?=$isi?>"> lembar

<br>





<tr><td><b>cetakan isi<td>  

<?php 

$pilihan=array("1"=>"1 warna","4"=>"full color");

echo $cetak->form_dropdownx('warna', $pilihan, isset($warna) ? $warna : ''); ?> 





<tr><td><b>ukuran<td>  

<?php 

$pilihan=array("a5"=>"A5 (15x21cm)","a6"=>"A6 (15x10cm)","a4"=>"A4 (30x21cm)","b5"=>"B5 (17x25cm)");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 







<tr>  <td><b>jilid<td>  

<?php 

$pilihan=array("lem"=>"blok lem","ring"=>"ring");

echo $cetak->form_dropdownx('jilid', $pilihan, isset($jilid) ? $jilid : ''); ?>   





<tr><td>



<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>

<div id=perhitunganbawah></div></div>

<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah) and is_numeric($isi))

{
echo $cetak->nota();
}

?>

<div style="clear:both"></div>