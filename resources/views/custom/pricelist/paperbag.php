<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{
$ukuran=$cetak->ukuran=$_POST["ukuran"];
$bahan=$cetak->bahan=$_POST["bahan"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$laminasi=$cetak->laminasi=$_POST["laminasi"];
$desain=$cetak->desain=$_POST["desain"];

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

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">

<tr><td><b>ukuran<td>
<?php 

$pilihan=array("kecil"=>"kecil (15x20x8 cm)","sedang"=>"sedang (24x10x34 cm)","besar"=>"besar (48x36x13cm)");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 


<tr><td><b>kertas<td>  

<?php 

$pilihan=array("ap210"=>"artpaper  210 gr","ap260"=>"artpaper  260 gr","ap310"=>"artpaper  310 gr");

echo $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   

<tr>

  <td><b>laminasi<td>   

<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV","glossy1"=>"glossy",

               "dof1"=>"dof");

echo $cetak->form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>   

    


<tr>

  <td><b>desain<td>    

<?php 

$pilihan=array(1=>"depan belakang sama",2=>"depan belakang beda");

echo $cetak->form_dropdownx('desain', $pilihan, isset($desain) ? $desain : ''); ?>   

    




<tr><td>



<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>

<div id=perhitunganbawah></div></div>

<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))

{


	echo $cetak->paperbag();

}



?>

<div style="clear:both"></div>



