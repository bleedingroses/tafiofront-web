<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{
$ukuran=$cetak->ukuran=$_POST["ukuran"];
$bahan=$cetak->bahan=$_POST["bahan"];
$muka=$cetak->muka=$_POST["muka"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$lipat=$cetak->lipat=$_POST["lipat"];
$laminasi=$cetak->laminasi=$_POST["laminasi"];

}
else

$ukuran=$bahan=$muka=$jumlah=$lipat=$laminasi="";


?><div id=perhitungankiri>

<div id=perhitunganatas>

<a name=hasil></a>

<div id=judul_hitung>Hitung harga cetak brosur online</div>

<table id="table-itungan" class=table class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

 

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">

<br>

<tr><td><b>muka<td> 



<?php 

$pilihan=array(1=>"1 muka",2=>"2 muka");

echo $cetak->form_dropdownx('muka', $pilihan, isset($muka) ? $muka : ''); ?> 



<tr><td><b>ukuran<td>  
<?php 

$pilihan=array("a5"=>"A5","a4"=>"A4","a3"=>"A3","folio"=>"Folio (33x21cm)","b5"=>"B5 (17x25cm)","b4"=>"B4 (25x34cm)");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 



<tr><td><b>kertas<td>



<?php 

$pilihan=array("ap100"=>"artpaper 100 gr","ap120"=>"artpaper 120 gr","ap150"=>"artpaper 150 gr",

"ap210"=>"artpaper  210 gr","ap260"=>"artpaper  260 gr","ap310"=>"artpaper  310 gr","hvs80"=>"hvs  80 gr","hvs100"=>"hvs 100 gr");

echo $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   



<tr>

  <td><b>laminasi<td> 

<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV 1 muka","uv2"=>"UV bolak balik","glossy1"=>"glossy 1 muka","glossy2"=>"glossy bolak balik",

               "dof1"=>"dof 1 muka","dof2"=>"dof bolak balik");

echo $cetak->form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>   

    

<tr>  <td><b>lipat<td>  

<?php 

$pilihan=array(""=>"tanpa lipat",1=>"dilipat jadi 2",2=>"dilipat jadi 3");

echo $cetak->form_dropdownx('lipat', $pilihan, isset($lipat) ? $lipat : ''); ?>   


<tr><td>
<td align=right><input type=submit name=kirim value=proses class='proses btn btn-info'>

</table>

</form>

</div>

<div id=perhitunganbawah></div></div>

<?php

if(!empty($_POST["kirim"]) and is_numeric($jumlah))
echo $cetak->tampilkan($cetak->cetak_lembaran());


?>

<div style="clear:both"></div>



