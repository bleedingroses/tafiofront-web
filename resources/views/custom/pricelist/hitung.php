<?php
//copy ke web percetakan bandung mulai dari sini
if(!empty($_POST["kirim"]))
{
$ukuran=$_POST["ukuran"];
$bahan=$_POST["bahan"];
$muka=$_POST["muka"];
$jumlah=$_POST["jumlah"];
$lipat=$_POST["lipat"];
$laminasi=$_POST["laminasi"];
}
else

{
$ukuran="";
$bahan="";
$muka="";
$jumlah="";
$lipat="";
$laminasi="";
}
?><div id=perhitungankiri>
<div id=perhitunganatas>
<a name=hasil></a>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>
<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>
  : 
      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">
<br>
<tr><td><b>mesin<td>:  

<?php 
$pilihan=array(1=>"gto 52",2=>"sorm 72",3=>"sorm S 100");
echo form_dropdownx('mesin', $pilihan, isset($mesin) ? $mesin : ''); ?> 


<Tr><td><b>ukuran <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>
  : 
      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>"> X <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">
<br>


<tr><td><b>kertas<td>:  

<?php 
$pilihan=array("ap100"=>"artpaper 100 gr","ap120"=>"artpaper 120 gr","ap150"=>"artpaper 150 gr",
"ap210"=>"artpaper  210 gr","ap260"=>"artpaper  260 gr","hvs80"=>"hvs  80 gr","hvs100"=>"hvs 100 gr");
echo form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   

<tr>
  <td><b>laminasi<td>:    
<?php 
$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV 1 muka","uv2"=>"UV bolak balik","glossy1"=>"glossy 1 muka","glossy2"=>"glossy bolak balik",
               "dof1"=>"dof 1 muka","dof2"=>"dof bolak balik");
echo form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>   
    
<tr>  <td><b>lipat<td> : 
<?php 
$pilihan=array(""=>"tanpa lipat",1=>"dilipat jadi 2",2=>"dilipat jadi 3");
echo form_dropdown('lipat', $pilihan, isset($lipat) ? $lipat : ''); ?>   


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
	
$proses="pendek";
$warna=4;

$jumlah_cetak=jumlah_cetak($jumlah,$proses);
$harga_kertas=harga_kertas($bahan,$ukuran,$jumlah_cetak);
$ongkos_cetak=ongkos_cetak($ukuran,$jumlah_cetak,$muka)*$warna;
$ongkos_print= ongkos_print($ukuran,$jumlah,$muka,$bahan,4);
$ongkos_laminasi=!empty($laminasi)?ongkos_laminasi($jumlah_cetak,$jumlah,$laminasi,$ukuran):"";
$ongkos_lipat=!empty($lipat)?ongkos_lipat($jumlah_cetak,$lipat,$bahan):"";
$ongkosx=murah_mana($ongkos_cetak,$harga_kertas,$ongkos_print);


$harga=$far['untung']*($ongkosx+$ongkos_laminasi+$ongkos_lipat);


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
</table>
";

echo"</div>";
}

?>
<div style="clear:both"></div>

