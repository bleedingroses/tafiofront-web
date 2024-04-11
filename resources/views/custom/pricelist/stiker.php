<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{


$bentuk=$cetak->ukuran=$_POST["bentuk"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$laminasi=$cetak->laminasi=$_POST["laminasi"];
$bahan=$cetak->bahan=$_POST["bahan"];
}

else
{

$bahan="";

$jumlah="";

$bentuk="";

$laminasi="";

}

?><div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak stiker online</div>

<a name=hasil></a>



<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>
      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">
<br>
<tr><td><b>bahan<td>  

<?php 

$pilihan=array("chromo"=>"kertas","vinil"=>"vinil (plastik)");

echo $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?> 
<tr><td><b>ukuran<td> A4 
<tr>
  <td><b>laminasi<td>  

<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV","glossy1"=>"glossy",

               "dof1"=>"dof");

echo $cetak->form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>   

<tr>

  <td>bentuk khusus

  <td>

   

      <input type="radio" name="bentuk" value="1"  <?php if($bentuk) echo"checked"?>>

      ya



      <input type="radio" name="bentuk" value="0" <?php if(!$bentuk) echo"checked"?>>

      tidak (kotak)

      <br>



    

    

<tr><td>



<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>

<div id=perhitunganbawah></div></div>

<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))
echo $cetak->stiker();


?>

<div style="clear:both"></div>



