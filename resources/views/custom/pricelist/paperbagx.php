<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{

$ukuran=$_POST["ukuran"];

$bahan=$_POST["bahan"];



$jumlah=$_POST["jumlah"];


$desain=$_POST["desain"];
$laminasi=$_POST["laminasi"];

}

else



{

$ukuran="";

$bahan="";



$jumlah="";



$laminasi="";

}

?><div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak paper bag online</div>

<a name=hasil></a>



<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

  : 

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">

<br>

<tr><td><b>ukuran<td>:  



<?php 

$pilihan=array("kecil"=>"kecil (15x20x8 cm)","sedang"=>"sedang (24x10x34 cm)","besar"=>"besar (48x36x13cm)");

echo form_dropdown('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 





<tr><td><b>kertas<td>:  



<?php 

$pilihan=array("ap210"=>"artpaper  210 gr","ap260"=>"artpaper  260 gr");

echo form_dropdown('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   



<tr>

  <td><b>laminasi<td>:    

<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV","glossy1"=>"glossy",

               "dof1"=>"dof");

echo form_dropdown('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>   

    


<tr>

  <td><b>desain<td>:    

<?php 

$pilihan=array(1=>"depan belakang sama",2=>"depan belakang beda");

echo form_dropdown('desain', $pilihan, isset($desain) ? $desain : ''); ?>   

    




<tr><td>



<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>

<div id=perhitunganbawah></div></div>

<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))

{

echo"<div id=perhitungantengah>";

	

$proses="panjang";

$warna=4;

$muka=1;





if($ukuran=="kecil")

{

$ukuranx="a3";

$jumlahx=$jumlah;
$jumlah_berat=$jumlah*1.2;


$ongkos_lipat=700*$jumlah;


$desainx=1;
}

else if($ukuran=="sedang")

{

$ukuranx="b3";

$jumlahx=$jumlah*2;
$jumlah_berat=$jumlah*1.9;

$ongkos_lipat=900*$jumlah;


$desainx=$desain;

}

else

{

$ukuranx="a2";

$jumlahx=$jumlah*2;
$jumlah_berat=$jumlah*2.5;

$ongkos_lipat=1300*$jumlah;


$desainx=$desain;

}






$berat=berat_kertas($jumlah_berat,$ukuranx,$bahan);





//tambah berat tali
$berat+=$jumlah*0.01;

$berat=ceil($berat);




$jumlah_cetak=jumlah_cetak($jumlahx,$proses);

$harga_kertas=harga_kertas($bahan,$ukuranx,$jumlah_cetak);

$ongkos_cetak=ongkos_cetak($ukuranx,$jumlah_cetak,$muka)*$warna*$desainx;



$ongkos_laminasi=!empty($laminasi)?ongkos_laminasi($jumlah_cetak,$jumlahx,$laminasi,$ukuranx):"";





$harga=harga_jual($ongkos_cetak+$harga_kertas+$ongkos_laminasi+$ongkos_lipat);





if($harga<$far['harga_minimal'])

$harga=$far['harga_minimal'];





$harga=pembulatan($harga);



$eksemplar=ceil($harga/$jumlah);

$eksemplar=number_format($eksemplar, 0, ',', '.');

$jumlah=number_format($jumlah, 0, ',', '.');

$harga=number_format($harga, 0, ',', '.');



//echo " harga kertas: $harga_kertas<br>

//ongkos cetak: $ongkos_cetak<br>

//ongkos print: $ongkos_print<br>

//jumlah cetak: $jumlah_print<br>

//laminasi: $ongkos_laminasi<br>

echo "

<table class=table>

<tr><td><strong>Harga Per buah</strong><td>: <td align=right id=hasil>Rp. $eksemplar

<tr><td><strong>Jumlah Pesan</strong><td>: <td align=right id=hasil>$jumlah

<tr><td><strong>Harga Total</strong><td>:  <td align=right id=hasil>Rp. $harga
<tr><td><strong>Berat Total</strong><td>:  <td align=right id=hasil>$berat kg
</table>

";



echo"</div>";

}



?>

<div style="clear:both"></div>



