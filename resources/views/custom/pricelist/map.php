<?php

//selesai

if(!empty($_POST["kirim"]))

{
$ukuran=$cetak->ukuran=$_POST["ukuran"];
$bahan=$cetak->bahan=$_POST["bahan"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$laminasi=$cetak->laminasi=$_POST["laminasi"];
$muka=$cetak->muka=$_POST["muka"];
}

else



{

$ukuran="";

$bahan="";

$muka="";

$jumlah="";

$laminasi="";

}

?>

<a name=hasil></a>

<div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak map online</div>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>

   

      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">

<br>

<tr><td><b>cetak<td> 



<?php 

$pilihan=array(1=>"luar saja (dalam putih)",2=>"luar dalam");

echo $cetak->form_dropdownx('muka', $pilihan, isset($muka) ? $muka : ''); ?> 



<tr><td><b>ukuran<td>

<?php 

$pilihan=array("a3"=>"A4 (22.5x31cm)","dblfolio"=>"Folio (34x24cm)");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 



<tr><td><b>tebal<td>  



<?php 

$pilihan=array("ap260"=>"artpaper  260 gr","ap310"=>"artpaper 310gr");

echo $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   



<tr>

  <td><b>laminasi<td>   

<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV 1 muka","uv2"=>"UV bolak balik","glossy1"=>"glossy 1 muka","glossy2"=>"glossy bolak balik",

               "dof1"=>"dof 1 muka","dof2"=>"dof bolak balik");

echo $cetak->form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>   

    

    

<tr><td>



<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>

</div>



<div id=perhitunganbawah></div></div>



<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah))

{


	echo $cetak->map();


}



?>

<div style="clear:both"></div>



