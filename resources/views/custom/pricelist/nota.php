<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{


$ukuran=$cetak->ukuran=$_POST["ukuran"];
$rangkap=$cetak->rangkap=$_POST["rangkap"];
$numerator=$cetak->numerator=$_POST["numerator"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$warna=$cetak->warna=$_POST["warna"];

}
else
{

$ukuran="";
$rangkap="";
$numerator="";
$warna="";
$jumlah="";
}

?>

<a name=hasil></a>

<div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak nota online</div>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>


<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>"> rim
<br>
<tr><td><b>ukuran<td> 
<?php 

$pilihan=array(4=>"1/4 A4",3=>"1/3 A4",2=>"1/2 A4",1=>"A4");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 



<tr><td><b>warna<td>

<?php 

$pilihan=array(1=>"1 warna",2=>"2 warna",3=>"3 warna");

echo $cetak->form_dropdownx('warna', $pilihan, isset($warna) ? $warna : ''); ?> 



<tr><td><b>rangkap<td>  

<?php 

$pilihan=array(1=>"tanpa rangkap",2=>"2 rangkap",3=>"3 rangkap",4=>"4 rangkap");

echo $cetak->form_dropdownx('rangkap', $pilihan, isset($rangkap) ? $rangkap : ''); ?> 


<tr>
  <td>numerator
  <td>
      <input type="radio" name="numerator" value="1"  <?php if($numerator==1) echo"checked"?>>

      ya



      <input type="radio" name="numerator" value="0" <?php if(!$numerator) echo"checked"?>>

      tidak 

      <br>
      <tr>
<td colspan=2>
numerator adalah penambahan nomor pada nota, yg berurutan pada tiap lembarnya

 <br>

<tr><td>

<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">
</table>

</form>
</div>
<div id=perhitunganbawah></div></div>
<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))
echo $cetak->nota();
?>

<div style="clear:both"></div>

