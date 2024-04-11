<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{

$panjang=$cetak->panjang_kecil=$_POST["panjang"];
$lebar=$cetak->lebar_kecil=$_POST["lebar"];
$set=$cetak->lembar=$_POST["set"];
$bahan=$cetak->bahan=$_POST["bahan"];
$muka=$cetak->muka=$_POST["muka"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$warna=$cetak->warna=$_POST["warna"];
$laminasi=$cetak->laminasi=$_POST["laminasi"];
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

echo $cetak->form_dropdownx('muka', $pilihan, isset($muka) ? $muka : ''); ?> 

<tr><td><b>jumlah warna<td>  

<?php 
$pilihan=array(4=>"full color",3=>"3 warna",2=>"2 warna",1=>"1 warna");

echo  $cetak->form_dropdownx('warna', $pilihan, isset($warna) ? $warna : ''); ?> 


<tr><td><b>ukuran<td>  

  <input type=text name=panjang class="input-kecil" value="<?=$panjang?>"> X 

  <input type=text name=lebar class="input-kecil" value="<?=$lebar?>">




<Tr><td><b>jumlah set <td><?php if(!empty($_POST["set"]) and !is_numeric($set)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

   

      <input type=text name=set class="input form-control" value="<?=$set?>">



<tr><td><b>kertas<td>  



<?php 

$pilihan=array("ap100"=>"artpaper 100 gr","ap120"=>"artpaper 120 gr","ap150"=>"artpaper 150 gr",

"ap210"=>"artpaper  210 gr","ap260"=>"artpaper  260 gr","ap310"=>"artpaper  310 gr","hvs80"=>"hvs  80 gr","hvs100"=>"hvs 100 gr");

echo  $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   



<tr>

  <td><b>laminasi<td>   

<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV 1 muka","uv2"=>"UV bolak balik","glossy1"=>"glossy 1 muka","glossy2"=>"glossy bolak balik",

               "dof1"=>"dof 1 muka","dof2"=>"dof bolak balik");

echo  $cetak->form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); 


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

echo $cetak->optimasi_harga();

}

?>


