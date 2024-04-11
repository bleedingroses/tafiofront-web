<?php
//copy ke web percetakan bandung mulai dari sini

!empty($_POST["ukuran"])?$ukuran=$cetak->ukuran=$_POST["ukuran"]:$ukuran="";
!empty($_POST["bahan1"])?$bahan1=$cetak->bahan=$_POST["bahan1"]:$bahan1="";
!empty($_POST["muka"])?$muka=$cetak->muka=$_POST["muka"]:$muka="";
!empty($_POST["jumlah1"])?$jumlah1=$cetak->jumlah=$_POST["jumlah1"]:$jumlah1="";
!empty($_POST["lembar1"])?$lembar1=$cetak->lembar=$_POST["lembar1"]:$lembar1="";
!empty($_POST["laminasi1"])?$laminasi1=$cetak->laminasi=$_POST["laminasi1"]:$laminasi1="";
!empty($_POST["jilid"])?$jilid=$cetak->jilid=$_POST["jilid"]:$jilid="";
?>


<div id=perhitungankiri>
<div id=perhitunganatas>
<a name=hasil></a>



<table id="table-itungan" class=table><form method=post action=<?php echo $_SERVER['REQUEST_URI']."#hasil"; ?>>

<tr><td colspan=2><b>kalender dinding
<Tr><td><b>jumlah <td><?php if(!empty($_POST["kirim2"]) and !is_numeric($jumlah1)) echo"<div class='peringatan alert alert-danger'>!! jumlah harus diisi</div>";?>
   
      <input type=text name=jumlah1 class="input form-control" value="<?=$jumlah1?>">
<br>

<tr><td><b>ukuran<td> 

<?php 
$pilihan=array("a3"=>"sedang (a3)","a2"=>"besar(a2)");
echo $cetak->form_dropdownx('ukuran', $pilihan, isset($ukuran) ? $ukuran : ''); ?> 


<Tr><td><b>isi<td><?php if(!empty($_POST["kirim2"]) and !is_numeric($lembar1)) echo"<div class='peringatan alert alert-danger'>!! lembar harus diisi</div>";?>
   
      <input type=text name=lembar1 class="input-kecil"  value="<?=$lembar1?>"> lembar
<br>



<tr><td><b>jilid<td>  
<?php 
$pilihan=array("ring"=>"ring","seng"=>"seng");
echo $cetak->form_dropdownx('jilid', $pilihan, isset($jilid) ? $jilid : ''); ?> 

<tr><td><b>kertas<td> 

<?php 
$pilihan=array("hvs100"=>"hvs 100 gr","ap120"=>"artpaper 120 gr","ap150"=>"artpaper 150 gr",
"ap210"=>"artpaper  210 gr","ap260"=>"artpaper  260 gr","ap310"=>"artpaper  310 gr");
echo $cetak->form_dropdownx('bahan1', $pilihan, isset($bahan1) ? $bahan1 : ''); ?>   

<tr>
  <td><b>laminasi<td>    
<?php 
$pilihan=array(""=>"tanpa laminasi","uv1"=>"UV 1 muka","glossy2"=>"glossy bolak balik",
               "dof2"=>"dof bolak balik");
echo $cetak->form_dropdownx('laminasi1', $pilihan, isset($laminasi1) ? $laminasi1 : ''); ?>   
    

<tr><td>

<td align=right><input type=submit name=kirim2 value=proses class="proses btn btn-info">
</table>
</form>

</div>
<div id=perhitunganbawah></div></div>
<?php 
 if(!empty($_POST["kirim2"]) and is_numeric($jumlah1) and is_numeric($lembar1))
{
	
echo "<H3><strong>Kalender dinding </strong> </h3>".$cetak->kalender_dinding();

}


?>
<div style="clear:both"></div>

