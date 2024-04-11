<?php

if(!empty($_POST["kirim"]))

{

$ukuran=$cetak->ukuran=$_POST["ukuran"];
$cover=$cetak->cover=$_POST["cover"];
$isi=$cetak->isi=$_POST["isi"];
$jumlah=$cetak->jumlah=$_POST["jumlah"];
$laminasi=$cetak->laminasi=$_POST["laminasi"];
$fc=$cetak->fc=$_POST["fc"];
$bw=$cetak->bw=$_POST["bw"];
$jilid=$cetak->jilid=$_POST["jilid"];

}

//copy ke web percetakan bandung mulai dari sini

else

{

$ukuran="";

$cover="";

$isi="";

$jumlah="";

$laminasi="";

$fc="";

$bw="";



}



?>



<a name=hasil></a>



<div id=perhitungankiri>

<div id=perhitunganatas>

<div id=judul_hitung>Hitung harga cetak majalah online</div>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<Tr><td>jumlah 

<td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?> <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">

<tr><td>ukuran

<td> 



<?php 

$pilihan=array("a5"=>"A5 (15x21cm)","a6"=>"A6 (15x10 cm)","folio2"=>"setengah folio (16,5x21cm)","b5"=>"B5 (17x25cm)","a4"=>"A4 (30x21cm)");

echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 





<tr>

  <td> kertas cover 

  <td>

  

<?php 

$pilihan=array("ap150"=>"artpaper 150 gr","ap210"=>"artpaper 210 gr","ap260"=>"artpaper 260 gr","ap310"=>"artpaper 310 gr");

echo $cetak->form_dropdownx('cover', $pilihan, isset($cover) ? $cover : ''); ?> 

 

  <tr>

  <td>laminasi <br>cover 

  <td>

  



<?php 

$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV ","glossy1"=>"glossy",

               "dof1"=>"dof","spot1"=>"doff + spot uv");

echo $cetak->form_dropdownx('laminasi', $pilihan, isset($laminasi) ? $laminasi : ''); ?>       

    

    

<tr>

  <td>kertas isi<td> 





<?php 

$pilihan=array("hvs80"=>"hvs 80gr","hvs100"=>"hvs 100gr","ap100"=>"artpaper 100 gr","ap120"=>"artpaper 120 gr","ap150"=>"artpaper 150 gr");

echo $cetak->form_dropdownx('isi', $pilihan, isset($isi) ? $isi : ''); ?>   







<tr>

  <td colspan="2">jumlah hal isi (harus kelipatan 4)

<tr>

  <td>warna <td> 

  <?php 
 if(!empty($_POST["kirim"])) 

  {

  if(($fc and $fc%4<>0) )

  {

  echo"<div class='peringatan alert alert-danger'>!! harus kelipatan 4</div>";

  }

  else if (empty($fc)and empty ($bw))

  echo"<div class='peringatan alert alert-danger'>halaman harus diisi</div>";  

  

  }  

  ?>



<input type=text name=fc class="input-kecil" value="<?=$fc?>"> halaman

<tr>

  <td>hitam putih <td> 

    <?php 
  if($bw and $bw%4<>0)

  {

  echo"<div class='peringatan alert alert-danger'>!! harus kelipatan 4</div>";

  }

  ?>

    

    <input type=text name=bw class="input-kecil" value="<?=$bw?>"> halaman



	

	<tr><td>

<td align=right>

<input type=submit name=kirim value=proses class="proses btn btn-info">

</table>

</form>



</div>



<div id=perhitunganbawah></div></div>



<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah)  and (is_numeric($bw) or is_numeric($fc)) and $bw%4==0 and $fc%4==0)

{

echo $cetak->buku();

}



?>

<div style="clear:both"></div>



