<?php

if(!empty($_POST["kirim"]))

{

$ukuran=$cetak->ukuran=$_POST["ukuran"];
$bahan=$cetak->bahan=$_POST["bahan"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$warna=$cetak->warna=$_POST["warna"];

}

else
{

$ukuran="";
$bahan="";
$jumlah="";
$warna="";

}

?>

<a name=hasil></a>

<div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak amplop online</div>

<table id="table-itungan" class=table class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

  

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">

<br>



<tr><td><b>ukuran<td>

<?php 

$pilihan=array("amplopkecil"=>"kecil 23x11 cm","a2"=>"besar 24x35 cm");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 



<tr><td><b>kertas<td>



<?php 

$pilihan=array("hvs100"=>"hvs 100 gr","ap150"=>"artpaper 150 gr");

echo $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   


<tr>  <td><b>warna<td> 

<?php 

$pilihan=array(1=>"1 warna",2=>"2 warna",3=>"3 warna",4=>"full color");

echo $cetak->form_dropdownx('warna', $pilihan, isset($warna) ? $warna : ''); ?>   





<tr><td>



<td align=right><input type=submit name=kirim value=proses class='proses btn btn-info'>

</table></form>


</div>



<div id=perhitunganbawah></div></div>



<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))


echo $cetak->amplop(); 




?>

<div style="clear:both"></div>

