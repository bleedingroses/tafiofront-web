<?php
//copy ke web percetakan bandung mulai dari sini

!empty($_POST["ukuran"])?$ukuran=$cetak->ukuran=$_POST["ukuran"]:$ukuran="";
!empty($_POST["bahan"])?$bahan=$cetak->bahan=$_POST["bahan"]:$bahan="";
!empty($_POST["muka"])?$muka=$cetak->muka=$_POST["muka"]:$muka="";
!empty($_POST["dudukan"])?$dudukan=$cetak->dudukan=$_POST["dudukan"]:$dudukan="";
!empty($_POST["jumlah"])?$jumlah=$cetak->jumlah=$_POST["jumlah"]:$jumlah="";
!empty($_POST["lembar"])?$lembar=$cetak->lembar=$_POST["lembar"]:$lembar="";
!empty($_POST["laminasi"])?$laminasi=$cetak->laminasi=$_POST["laminasi"]:$laminasi="";
?>


<div id=perhitungankiri>
<div id=perhitunganatas>
<a name=hasil></a>

<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<tr><td colspan=2><b>kalender duduk
<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim"]) and !is_numeric($jumlah)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>
   
      <input type=text name=jumlah class="input form-control" value="<?=$jumlah?>">
<br>


<Tr><td><b>isi<td><?php if(!empty($_POST["kirim"]) and !is_numeric($lembar)) echo"<div class='peringatan alert alert-danger'>!! lembar harus diisi</div>";?>
  
      <input type=text name=lembar  class="input-kecil"  value="<?=$lembar?>"> lembar
<br>



<tr><td><b>cetak<td> 
<?php 
$pilihan=array("1"=>"1 muka","2"=>"bolak balik");
echo $cetak->form_dropdownx('muka', $pilihan, isset($muka) ? $muka : ''); ?> 

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
  <td><b>dudukan<td>    
<?php 
$pilihan=array("kertas"=>"kertas biasa","karton"=>"karton tebal");
echo $cetak->form_dropdownx('dudukan', $pilihan, isset($dudukan) ? $dudukan : ''); ?>   
    


<tr><td>

<td align=right><input type=submit name=kirim value=proses class="proses btn btn-info">
</table>
</form>


</div>
<div id=perhitunganbawah></div></div>
<?php 
if(!empty($_POST["kirim"]) and is_numeric($jumlah) and is_numeric($lembar))
{

echo "<H3><strong>Kalender duduk </strong> </h3>".$cetak->kalender_duduk();

}



?>
<div style="clear:both"></div>

