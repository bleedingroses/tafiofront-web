<?php

//selesai

if(!empty($_POST["kirim"]))

{

$ukuran=$cetak->ukuran=$_POST["ukuran"];

$warna=$cetak->warna=$_POST["warna"];

$jumlah=$cetak->jumlah=$_POST["jumlah"];

}

else



{

$ukuran="";

$warna="";

$jumlah="";



}

?>

<a name=hasil></a>

<div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak kop surat online</div>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah (rim) <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

  

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">

<br>

<tr><td><b>warna<td> 



<?php 

$pilihan=array(1=>"1 warna",2=>"2 warna",3=>"3 warna",4=>"full color");

echo $cetak->form_dropdownx('warna', $pilihan, isset($warna) ? $warna : ''); ?> 



<tr><td><b>ukuran<td> 

<?php 

$pilihan=array("a4"=>"A4","folio"=>"Folio (33x21cm)");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 



<tr><td>



<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>



<div id=perhitunganbawah></div></div>

<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))

{
$cetak->bahan="hvs80";
echo $cetak->kopsurat();

}



?>

<div style="clear:both"></div>

