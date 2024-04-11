<?php
if(!empty($_POST["kirim"]))
{
$ukuran=$cetak->ukuran=$_POST["ukuran"];
$bahan=$cetak->bahan=$_POST["bahan"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$laminasi=$cetak->laminasi=$_POST["laminasi"];
}

else
{
$ukuran="";
$bahan="";



$jumlah="";

$laminasi="";

}

?>

<a name=hasil></a>

<div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak poster online</div>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

   

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">





<tr><td><b>ukuran<td>

<?php 

$pilihan=array("a5"=>"A5 (15x21cm)","a4"=>"A4 (30x21cm)","a3"=>"A3 (30x42 cm)","a2"=>"A2 (42x60cm)","folio"=>"Folio (33x21cm)","b5"=>"B5 (17x25cm)","b4"=>"B4 (25x34cm)");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 



<tr><td><b>kertas<td> 



<?php 
	
$pilihan=array("ap100"=>"artpaper 100 gr","ap120"=>"artpaper 120 gr","ap150"=>"artpaper 150 gr",

"ap210"=>"artpaper  210 gr","ap260"=>"artpaper  260 gr","ap310"=>"artpaper  310 gr","hvs80"=>"hvs  80 gr","hvs100"=>"hvs 100 gr");

echo $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   



<tr>

  <td><b>laminasi<td>  

<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV","glossy1"=>"glossy",

               "dof1"=>"dof");

echo $cetak->form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>   

    





<tr><td>



<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>



<div id=perhitunganbawah></div></div>
<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))
echo $cetak->tampilkan($cetak->cetak_lembaran());
?>

<div style="clear:both"></div>



