<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{

$panjang_kecil=$_POST["panjang_kecil"];
$lebar_kecil=$_POST["lebar_kecil"];
$set=$_POST["set"];
$muka=$_POST["muka"];


}

else



{

$panjang_kecil=$lebar_kecil=$muka="";
$set=1;

}

?>
<div id=perhitungankiri>

<div id=perhitunganatas>

<a name=hasil></a>

<div id=judul_hitung>Hitung manual</div>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>


<tr><td><b>ukuran cetak<td> 

  <input type=text name=panjang_kecil class="input-kecil" value="<?=$panjang_kecil?>"> X 

  <input type=text name=lebar_kecil class="input-kecil" value="<?=$lebar_kecil?>">



<Tr><td><b>jumlah set <td><?php if(!empty($_POST["set"]) and !is_numeric($set)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

   

      <input type=text name=set class="input form-control" value="<?=$set?>">


<tr><td><b>muka<td> 



<?php 

$pilihan=array(1=>"1 muka",2=>"2 muka");

echo form_dropdownx('muka', $pilihan, isset($muka) ? $muka : ''); ?> 





<tr><td>




<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>


<?php 
echo"<div id= perhitunganbawah ></div></div>";



/**



*/

if(!empty($_POST["kirim"]) )

{

echo"<div id=perhitungantengah>";


$pcetak=$panjang_kecil+0.5;
$lcetak=$lebar_kecil+0.5;


$ukuran=sesuaikan_panjang($pcetak,$lcetak);
$pcetak=$ukuran["panjang"];
$lcetak=$ukuran["lebar"];





$hasil=optimasi_setting($pcetak,$lcetak,$set,$muka);




if($hasil!="kegedean")
{
$t=1;
if($hasil["komplit"])
{
if($muka==2)
	$format_komplit="bolak balik";
else
	$format_komplit="semuka";


$gambar_komplit=optimasi_gambar($pcetak,$lcetak,$hasil["komplit"]["gambar"]);


echo"$t. jumlah set: ".$hasil["komplit"]["set"]." set ".$hasil["komplit"]["format"]."<br>";
echo"total mata: ".$hasil["komplit"]["mata"]."<br>";

echo"panjang bahan: ".$hasil["komplit"]["panjang"]."<br>";
echo"lebar bahan: ".$hasil["komplit"]["lebar"]."<br>";

echo" $gambar_komplit<br>";
$t++;
}

if($hasil["gak_komplit"])
{
$gambar_gak_komplit=optimasi_gambar($pcetak,$lcetak,$hasil["gak_komplit"]["gambar"]);



echo"$t. jumlah set: ".$hasil["gak_komplit"]["set"]." set "."<br>";
echo"pengulangan set: ".$hasil["gak_komplit"]["duplikasi"]." <br>";
echo"total mata: ".$hasil["gak_komplit"]["mata"]." X ".$hasil["gak_komplit"]["duplikasi"]." <br>";
echo"format cetak: ".$hasil["gak_komplit"]["format"]."<br>";

echo"panjang bahan: ".$hasil["gak_komplit"]["panjang"]."<br>";
echo"lebar bahan: ".$hasil["gak_komplit"]["lebar"]."<br>";

echo" $gambar_gak_komplit<br>";
}
}
else
echo "bahan cetak kegedean";


//echo "jumlah set:".$mesin["set"]."<br>".
	// "plano:".$mesin["plano"]."<br>".
//echo  $mesin["gambar"]."<br>";




echo"</div>";

}



?>

<div style="clear:both"></div>



