<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{

$panjang=$_POST["panjang"];
$lebar=$_POST["lebar"];
$set=$_POST["set"];


$bahan=$_POST["bahan"];

$muka=$_POST["muka"];

$jumlah=$_POST["jumlah"];

$warna=$_POST["warna"];
$laminasi=$_POST["laminasi"];

}

else


{

$panjang=$lebar=$warna="";
$set=1;
$bahan="";

$muka="";

$jumlah="";


$laminasi="";

}

?>
<div id=perhitungankiri>

<div id=perhitunganatas>

<a name=hasil></a>

<div id=judul_hitung>Hitung manual</div>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah cetak <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

   

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">


<tr><td><b>muka<td>  



<?php 

$pilihan=array(1=>"1 muka",2=>"2 muka");

echo form_dropdownx('muka', $pilihan, isset($muka) ? $muka : ''); ?> 

<tr><td><b>jumlah warna<td>  

<?php 
$pilihan=array(4=>"full color",3=>"3 warna",2=>"2 warna",1=>"1 warna");

echo form_dropdownx('warna', $pilihan, isset($warna) ? $warna : ''); ?> 


<tr><td><b>ukuran<td>  

  <input type=text name=panjang class="input-kecil" value="<?=$panjang?>"> X 

  <input type=text name=lebar class="input-kecil" value="<?=$lebar?>">




<Tr><td><b>jumlah set <td><?php if(!empty($_POST["set"]) and !is_numeric($set)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

   

      <input type=text name=set class="input form-control" value="<?=$set?>">



<tr><td><b>kertas<td>  



<?php 

$pilihan=array("ap100"=>"artpaper 100 gr","ap120"=>"artpaper 120 gr","ap150"=>"artpaper 150 gr",

"ap210"=>"artpaper  210 gr","ap260"=>"artpaper  260 gr","ap310"=>"artpaper  310 gr","hvs80"=>"hvs  80 gr","hvs100"=>"hvs 100 gr");

echo form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   



<tr>

  <td><b>laminasi<td>   

<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV 1 muka","uv2"=>"UV bolak balik","glossy1"=>"glossy 1 muka","glossy2"=>"glossy bolak balik",

               "dof1"=>"dof 1 muka","dof2"=>"dof bolak balik");

echo form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); 


?>   

    



<tr><td>



<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>


<?php 
echo"<div id= perhitunganbawah ></div></div>";




/**



*/

if(!empty($_POST["kirim"]) and is_numeric($jumlah))

{

echo"<div id=perhitungantengah>";

$proses="pendek";


$pcetak=$panjang+0.5;
$lcetak=$lebar+0.5;


$ukuran=sesuaikan_panjang($pcetak,$lcetak);
$pcetak=$ukuran["panjang"];
$lcetak=$ukuran["lebar"];


echo "
<table width=100% >";

$jumlah_cetak=jumlah_cetak($jumlah,$proses);



$hasil=optimasi_setting($pcetak,$lcetak,$set,$muka);




//ngitung jumlah bahan

if($hasil!="kegedean")
{

$jenis=jenis_kertas($bahan);
$t=1;
$total_bahan=0;
$total_set=0;

if($hasil["komplit"])
{
if($muka==2)
	$set_bahan=$hasil["komplit"]["set"]/2;
else
	$set_bahan=$hasil["komplit"]["set"];


$panjang_bahan=$hasil["komplit"]["panjang"];
$lebar_bahan=$hasil["komplit"]["lebar"];



$hasil_bahan=optimasi_bahan($panjang_bahan,$lebar_bahan,$jenis);

$set_plano=$hasil_bahan["set"];
$ukuran_plano=$hasil_bahan["plano"];

$jumlah_bahan=ceil($jumlah_cetak*$set_bahan);
$jumlah_plano=ceil($jumlah_bahan/$set_plano);


//echo $bahan;

$harga_plano=ceil($jumlah_plano*$spek_harga[$bahan]*$spek_plano[$ukuran_plano]['pengali']);
$total_bahan=$harga_plano;
$total_set=$hasil["komplit"]["set"];


$gambar_komplit=optimasi_gambar($pcetak,$lcetak,$hasil["komplit"]["gambar"]);



echo "<td><table >
<tr><td><h3>bahan $t</h3>

<tr><td>ukuran bahan<td>: <td align=right id=kuning> $panjang_bahan cm X $lebar_bahan cm
<tr><td><strong>jumlah mata dlm 1 set</strong><td>: <td align=right id=kuning>".$hasil["komplit"]["mata"]." mata
<tr><td><strong>jumlah plat</strong><td>: <td align=right id=kuning>".$hasil["komplit"]["set"]." set
<tr><td><strong>jumlah bahan</strong><td>: <td align=right id=kuning> $jumlah_bahan potong 
<tr><td><strong>1 plano jadi</strong><td>: <td align=right id=kuning> $set_plano
<tr><td><strong>jumlah plano</strong><td>: <td align=right id=kuning> $jumlah_plano
<tr><td><strong>ukuran plano</strong><td>: <td align=right id=kuning> $ukuran_plano
<tr><td><strong>total harga bahan</strong><td>: <td align=right id=kuning>$harga_plano
<tr><td><strong>format cetak</strong><td>: <td align=right id=kuning>".$hasil["komplit"]["format"]."


</table>
";

$t++;
}


if($hasil["gak_komplit"])
{
if($muka==2)
	$set_bahan=$hasil["gak_komplit"]["set"]/2;
else
	$set_bahan=$hasil["gak_komplit"]["set"];


$panjang_bahan=$hasil["gak_komplit"]["panjang"];
$lebar_bahan=$hasil["gak_komplit"]["lebar"];



$hasil_bahan=optimasi_bahan($panjang_bahan,$lebar_bahan,$jenis);

$set_plano2=$hasil_bahan["set"];
$ukuran_plano2=$hasil_bahan["plano"];



$jumlah_bahan=ceil($jumlah_cetak*$set_bahan/$hasil["gak_komplit"]["duplikasi"]);
$jumlah_plano2=ceil($jumlah_bahan/$set_plano2);


//echo $bahan;

$harga_plano2=ceil($jumlah_plano2*$spek_harga[$bahan]*$spek_plano[$ukuran_plano2]['pengali']);

$total_bahan+=$harga_plano2;
$total_set+=$hasil["gak_komplit"]["set"];


$gambar_gak_komplit=optimasi_gambar($pcetak,$lcetak,$hasil["gak_komplit"]["gambar"]);

echo "<td><table class=table>
<tr><td><h3>bahan $t</h3>
<tr><td><strong>ukuran bahan</strong><td>: <td align=right id=kuning> $panjang_bahan cm X $lebar_bahan cm
<tr><td><strong>jumlah mata dlm 1 set</strong><td>: <td align=right id=kuning>".$hasil["gak_komplit"]["mata"]." mata
<tr><td><strong>pengulangan mata</strong><td>: <td align=right id=kuning>".$hasil["gak_komplit"]["duplikasi"]." set
<tr><td><strong>jumlah plat</strong><td>: <td align=right id=kuning>".$hasil["gak_komplit"]["set"]." set
<tr><td><strong>jumlah bahan</strong><td>: <td align=right id=kuning> $jumlah_bahan potong 
<tr><td><strong>1 plano jadi</strong><td>: <td align=right id=kuning> $set_plano2 
<tr><td><strong>jumlah plano</strong><td>: <td align=right id=kuning> $jumlah_plano2
<tr><td><strong>ukuran plano</strong><td>: <td align=right id=kuning> $ukuran_plano2
<tr><td><strong>total harga bahan</strong><td>: <td align=right id=kuning>$harga_plano2
<tr><td><strong>format cetak</strong><td>: <td align=right id=kuning>".$hasil["gak_komplit"]["format"]."
</table>
";


}

$ongkos_cetak=ongkos_cetak($hasil["mesin"],$jumlah_bahan,$total_set)*$warna;







$ongkos_laminasi=!empty($laminasi)?ongkos_laminasi($jumlah_cetak*$set,$jumlah,$laminasi,$panjang*$lebar):"";

$total_produksi=$ongkos_laminasi+$ongkos_cetak+$total_bahan;

$harga_jual=ceil(harga_jual($total_produksi));


echo"<td valign=top><table class=table><tr><td><strong>&nbsp;</strong><td><td align=right id=hitam>";

echo"<tr><td><h3>hasil</h3>";


echo"<tr><td><strong>mesin</strong><td>: <td align=right id=kuning> ". $hasil["mesin"];
echo"<tr><td><strong>total plat</strong><td>: <td align=right id=kuning>$total_set set";

echo"<tr><td><strong>ongkos cetak</strong><td>: <td align=right id=kuning>$ongkos_cetak";
echo"<tr><td><strong>total bahan</strong><td>: <td align=right id=kuning>$total_bahan";

if(!empty($laminasi))
echo"<tr><td><strong>ongkos laminasi</strong><td>: <td align=right id=kuning>$ongkos_laminasi";



echo"<tr><td><strong>harga produksi</strong><td>: <td align=right id=kuning>$total_produksi";
echo"<tr><td><strong>harga jual</strong><td>: <td align=right id=kuning>$harga_jual";


}
else
{

echo "<td>bahan kegedean";

}


echo"</table></table><br>

<table width=100%>";
if($hasil["komplit"])
echo "<td>bahan 1 $gambar_komplit";

if($hasil["gak_komplit"])
echo "<td>bahan 2 $gambar_gak_komplit";







"</div>";

}

?>


