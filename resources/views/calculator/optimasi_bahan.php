<?php

//copy ke web percetakan bandung mulai dari sini

if(!empty($_POST["kirim"]))

{

$panjang_kecil=$cetak->panjang_kecil=$_POST["panjang_kecil"];
$lebar_kecil=$cetak->lebar_kecil=$_POST["lebar_kecil"];
$bahan=$cetak->bahan=$_POST["bahan"];

}

else



{

$panjang_kecil=$lebar_kecil=$bahan="";

}

?>
<div id=perhitungankiri>

<div id=perhitunganatas>

<a name=hasil></a>

<div id=judul_hitung>Hitung manual</div>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>


<tr><td><b>ukuran potong<td>

  <input type=text name=panjang_kecil class="input-kecil" value="<?=$panjang_kecil?>"> X 

  <input type=text name=lebar_kecil class="input-kecil" value="<?=$lebar_kecil?>">



<tr><td><b>kertas<td> 



<?php 

$pilihan=array("ap"=>"artpaper","hvs"=>"hvs","duplek"=>"duplek","chromo"=>"chromo","coronado"=>"coronado"

);

echo $cetak->form_dropdownx('bahan', $pilihan, isset($bahan) ? $bahan : ''); ?>   






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

echo $cetak->optimasi_bahan_final();

}



?>

<div style="clear:both"></div>



