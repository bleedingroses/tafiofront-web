<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{

$ukuran=$cetak->ukuran=$_POST["ukuran"];
$bahan=$cetak->bahan=$_POST["bahan"];
$warna=$cetak->warna=$_POST["warna"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];

}

else



{

$ukuran="";

$bahan="";

$warna="";

$jumlah="";

}

?><div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak LJK online</div>

<a name=hasil></a>



<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah (rim)<td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

   

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>"> 

<br>

<tr><td><b>warna<td>  



<?php 

$pilihan=array(1=>"1 warna",2=>"2 warna",3=>"3 warna",4=>"full color");

echo $cetak->form_dropdownx('warna', $pilihan, isset($warna) ? $warna : ''); ?> 



<tr><td><b>ukuran<td>

<?php 

$pilihan=array("a5"=>"A5 (15x21cm)","b5"=>"B5 (17x25cm)","a4"=>"A4 (30x21cm)","folio"=>"Folio (33x21cm)");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 



<tr><td><b>kertas<td> 



<?php 

$pilihan=array("hvs70"=>"hvs  70 gr","hvs80"=>"hvs  80 gr","hvs100"=>"hvs 100 gr");

echo $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   



<tr><td>



<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>

<div id=perhitunganbawah></div></div>

<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))

{


echo $cetak->kopsurat();


}



?>

<div style="clear:both"></div>

