<?php 
if(!empty($_POST["kirim"]))
{
$lebar=$_POST["lebar"];
$tebal=$_POST["tebal"];
$panjang=$_POST["panjang"];
$jumlah=$_POST["jumlah"];
}
else
$lebar=$tebal=$panjang=$jumlah='';
?>
<form method=post>
<p><label>jumlah (lembar) </label>
 
<input type=text class=form-control name=jumlah class="lebar-text" value="<?=$jumlah ?>">

</p>

<p><label>tebal (gr)</label>
  
      <input type=text class=form-control name=tebal class="lebar-text" value="<?=$tebal ?>"> 
</p>

<p><label>panjang (cm)</label>
 
      <input type=text class=form-control name=panjang class="lebar-text" value="<?=$panjang ?>"> 
</p>

<p><label>lebar (cm)</label>

      <input type=text class=form-control name=lebar class="lebar-text" value="<?=$lebar?>"> 

</p>
<input type=submit class="btn btn-primary" class="btn btn-primary" name=kirim value=proses id=submit>

</form>
<?php 
if(!empty($_POST["kirim"]))
{
$satuan= $lebar*$panjang/10000*$tebal;
$total=$satuan*$jumlah/1000;

echo "<h3>Hasil perhitungan</h3>
<table class=table>
<tr><td><strong>berat per lembar</strong><td>: <td align=right>$satuan gram
<tr><td><strong>berat total</strong><td>: <td align=right>$total kg
</table>
";
}
