<?php 
global $far, $spek_harga,$spek_mesin,$spek_ukuran,$spek_laminasi,$spek_berat;

$far=array("print_tipis"=>3000,
"print_tebal"=>4000,
"print_bw_tipis"=>1500,
"print_bw_tebal"=>2500,
"print_a2"=>35000,
"ongkos_lipat"=>30,
"harga_minimal"=>100000,
"harga_laminasi_print"=>2200,
"harga_laminasi_a2"=>20000,
"pond_minimal"=>50000,
"pond_perdruk"=>40,
"foil_minimal"=>100000,
"foil_perdruk"=>200,
"variable_harga"=>10,
"susun"=>15,
"hekter"=>300,
"lem_percm"=>50,
"lem_satuan"=>2000,
"lem_min"=>350000,
"jahit_perketel"=>350,
"hardcover"=>7000,
"harga_ncr"=>40000,
"nota_lem"=>8000,
"nota_porporasi"=>6000,
"nota_numerator"=>10000,
"ring"=>80,
"ring_min"=>700,

);



//cara menghitung tebal x variable ----- untuk plano 79x108

$spek_harga= array("ap100"=>1100,
              "ap120"=>1200,
              "ap150"=>1500,
              "ap210"=>2100,
              "ap230"=>2300,
              "ap260"=>2600,
              "ap310"=>3100,
              "hvs70"=>570,             
              "hvs80"=>650,
              "hvs100"=>900,
              "chromo"=>3700,
              "vinil"=>14000,
              "coronado"=>11000

              );


$spek_berat= array("ap100"=>100,
              "ap120"=>120,
              "ap150"=>150,
              "ap210"=>210,
              "ap230"=>230,
              "ap260"=>260, 
              "ap310"=>310,
              "hvs80"=>80,
              "hvs70"=>70,
              "hvs100"=>100,
              "chromo"=>180,
              "vinil"=>250,
              "coronado"=>260,
              "dudukan_kalender"=>1650,
              "hardcover"=>2500
             
              );


$spek_ukuran=array("a6"=>array("cover"=>"a5","plano"=>0.762,"dibagi"=>"32","mesin"=>"sm52","perset_jadi"=>8,"perprint_jadi"=>8,"luas"=>160,"tinggi"=>15),
              "a5"=>array("cover"=>"a4","plano"=>0.762,"dibagi"=>"16","mesin"=>"sm52","perset_jadi"=>4,"perprint_jadi"=>4,"luas"=>315,"tinggi"=>21),
             "a4"=>array("cover"=>"a3","plano"=>0.762,"dibagi"=>8,"mesin"=>"sm52","perset_jadi"=>2,"perprint_jadi"=>2,"luas"=>630,"tinggi"=>30),
             "a3"=>array("cover"=>"","plano"=>0.762,"dibagi"=>4,"mesin"=>"sm52","perset_jadi"=>1,"perprint_jadi"=>1,"luas"=>1260,"tinggi"=>42),
             "folio"=>array("cover"=>"dblfolio","plano"=>1,"dibagi"=>8,"mesin"=>"sm52","perset_jadi"=>2,"perprint_jadi"=>1,"luas"=>710,"tinggi"=>33),
             "folio2"=>array("cover"=>"folio","plano"=>1,"dibagi"=>16,"mesin"=>"sm52","perset_jadi"=>4,"perprint_jadi"=>2,"luas"=>355,"tinggi"=>21),
            "dblfolio"=>array("cover"=>"","plano"=>1,"dibagi"=>4,"mesin"=>"sm52","perset_jadi"=>1,"perprint_jadi"=>1,"luas"=>1420,"tinggi"=>43),
              "b5"=>array("cover"=>"b4","plano"=>1,"dibagi"=>16,"mesin"=>"sm52","perset_jadi"=>4,"perprint_jadi"=>2,"luas"=>425,"tinggi"=>25),
             "b4"=>array("cover"=>"","plano"=>1,"dibagi"=>8,"mesin"=>"sm52","perset_jadi"=>2,"perprint_jadi"=>1,"luas"=>850,"tinggi"=>35),
             "b3"=>array("cover"=>"","plano"=>1,"dibagi"=>4,"mesin"=>"sm52","perset_jadi"=>1,"perprint_jadi"=>1,"luas"=>1700,"tinggi"=>50),
             "kuarto"=>array("cover"=>"a3","plano"=>0.762,"dibagi"=>8,"mesin"=>"ko66","perset_jadi"=>4,"perprint_jadi"=>2,"luas"=>588,"tinggi"=>28),
             "a2"=>array("cover"=>"","plano"=>0.762,"dibagi"=>2,"mesin"=>"sm72","perset_jadi"=>1,"perprint_jadi"=>1,"luas"=>2520,"tinggi"=>60),
             "amplopkecil"=>array("cover"=>"","plano"=>1,"dibagi"=>12,"mesin"=>"sm52","perset_jadi"=>1,"perprint_jadi"=>1,"luas"=>702,"tinggi"=>25)

);

$spek_mesin= array("sm52"=>array("min"=>80000,"druk"=>20),
              "ko66"=>array("min"=>130000,"druk"=>30),
              "sm72"=>array("min"=>160000,"druk"=>40),
               "toko"=>array("min"=>12000,"druk"=>10)
              );
           
$spek_laminasi=array("uv1"=>array("min"=>80000,"percm"=>"0.07","muka"=>1),
                     "uv2"=>array("min"=>80000,"percm"=>"0.14","muka"=>2),
                     "glossy1"=>array("min"=>120000,"percm"=>"0.16","muka"=>1),
                     "glossy2"=>array("min"=>120000,"percm"=>"0.32","muka"=>2),
                     "dof1"=>array("min"=>170000,"percm"=>"0.27","muka"=>1),
                     "dof2"=>array("min"=>170000,"percm"=>"0.54","muka"=>2),
                    "spot1"=>array("min"=>650000,"percm"=>"0.55","muka"=>1),
                     "spot2"=>array("min"=>650000,"percm"=>"1.1","muka"=>2)                                   
                     );


function harga_jual($harga)

{  

if($harga<=5000000)
$untung=1.4;
 else if ($harga<=15000000)
$untung=(140-(($harga/1000000)-5))/100;
else
 $untung=1.3;


$harga_jual=($harga*$untung)+100000;

return $harga_jual;
}

// untuk menentukan ongkos print, yg tebal sama yg tipis beda
function harga_tebal($bahan,$warna)
{ global $far,$spek_berat;
    
 $tebal=$spek_berat[$bahan];   

if($warna==4)
{
if($tebal<=150)
return $far["print_tipis"];
else
return $far["print_tebal"];
}
else
if($warna==1)
{
if($tebal<=150)
return $far["print_bw_tipis"];
else
return $far["print_bw_tebal"];
}


}


function jumlah_cetak($jumlah,$proses)
{

if($proses=="pendek")
return (($jumlah*105/100)+150);
else
return (($jumlah*110/100)+250);

}


function berat_kertas($jumlah,$ukuran,$bahan)
{
global $spek_berat,$spek_ukuran, $far;

$berat_total=$spek_berat[$bahan]*$spek_ukuran[$ukuran]["luas"]/10000/1000*$jumlah*1.1;

//if($laminasi)
//$berat_total+=$spek_laminasi[$laminasi]["muka"]*$spek_ukuran[$ukuran]["luas"]/10000*0.02;







//echo $jumlah."<br>berat:".$spek_berat['ap120']."<br>".$spek_ukuran[$ukuran]["luas"];

return $berat_total;

}






function harga_kertas($bahan,$ukuran,$jumlah)
{
global $spek_harga,$spek_ukuran;



$harga_plano=$spek_harga[$bahan];

$harga_kertas=$jumlah*$harga_plano*$spek_ukuran[$ukuran]["plano"]/$spek_ukuran[$ukuran]["dibagi"];	

return $harga_kertas;


}

/**





*/

function ongkos_cetak($ukuran,$jumlah,$set)
{
global $spek_ukuran,$spek_mesin;

$jenis_mesin=$spek_ukuran[$ukuran]["mesin"];
$perset_jadi=$spek_ukuran[$ukuran]["perset_jadi"];
$ongkos_cetak=0;




$min_mesin=$spek_mesin[$jenis_mesin]["min"];

if($jenis_mesin=="sm52")
$min_mesin+=20000;


$total_set=$set/$perset_jadi;

if($set%$perset_jadi!=0)
{


$selisih=floor($total_set);
$set_sisa=$total_set-$selisih;    

$total_set=$selisih;


$druk_sisa=$jumlah*$set_sisa;

$ongkos_cetak+=$min_mesin;

if($druk_sisa>2000)
$ongkos_cetak+=$spek_mesin[$jenis_mesin]["druk"]*($druk_sisa-2000);

}



if($total_set>0)
{
$ongkos_cetak+=$min_mesin*$total_set;

if($jumlah>2000)
$ongkos_cetak+=$spek_mesin[$jenis_mesin]["druk"]*($jumlah-2000)*$total_set;

}


// kemungkinan kalo diprint
return $ongkos_cetak;
}

function ongkos_cetak_toko($jumlah)
{
global $spek_mesin;

$ongkos_cetak=$spek_mesin["toko"]["min"];

if ($jumlah>500)
$ongkos_cetak+=($jumlah-500)*$spek_mesin["toko"]["druk"];




return $ongkos_cetak;

}



function ongkos_print($ukuran,$jumlah,$muka,$bahan,$warna)
{  global $spek_ukuran,$far;
    
    
  $jumlah_print=$jumlah*1.1;  
    
$harga_print=harga_tebal($bahan,$warna);    
   // echo $harga_print;
   
   $perprint=$spek_ukuran[$ukuran]["perprint_jadi"];




if($ukuran!="a2" and $ukuran!="dblfolio" )
$print=$jumlah_print*$harga_print/$perprint*$muka;
else
$print=$jumlah_print*$far['print_a2']*$muka;



return
 $print;



}



function  form_dropdownx($nama, $optionx, $pilihan=NULL)
{


$hasil="<select name=$nama class=dropdown>";
     
  foreach ($optionx as $id_option => $value) {
   
    $hasil.= "<option value='$id_option'";
    
    if (!empty($pilihan))
    {
    if($pilihan==$id_option)
    $hasil.=" selected ";
    
    }
    
     $hasil.=">$value</option>";
}  
    
    
    $hasil.="</select>";  

return $hasil;

}

function pembulatan($harga)
{

if($harga<=500000)    
return floor($harga/1000)*1000;
else
return floor($harga/10000)*10000;

    
}

function ongkos_laminasi($jumlah_cetak,$jumlah,$laminasi,$ukuran)
{ global $spek_ukuran, $spek_laminasi,$far;

$jumlah_print=$jumlah*1.1;
   $laminasi_cetak=$jumlah_cetak*$spek_laminasi[$laminasi]["percm"]*$spek_ukuran[$ukuran]["luas"]; 
   
   
 
if($laminasi_cetak<$spek_laminasi[$laminasi]["min"])
$laminasi_cetak=$spek_laminasi[$laminasi]["min"];




   
if($laminasi!="spot1")
{if($ukuran!="a2" and $ukuran!="dblfolio")
$laminasi_print=$jumlah_print*$far['harga_laminasi_print']/$spek_ukuran[$ukuran]["perprint_jadi"]*$spek_laminasi[$laminasi]["muka"];
else
$laminasi_print=$jumlah_print*$far['harga_laminasi_a2']*$spek_laminasi[$laminasi]["muka"];
}
else
$laminasi_print="50000000000";


 



return $laminasi_cetak>$laminasi_print?$laminasi_print:$laminasi_cetak;

    
}
function ongkos_lipat($jumlah,$lipat,$bahan)
{
    global $far,$spek_berat;
    $tebalx=$spek_berat[$bahan];
    if($tebalx<=150)
 $hasil= $jumlah*$lipat*$far['ongkos_lipat'];   
    else
    {
        $hasil=$jumlah*$far['pond_perdruk'];
        if($hasil<$far['pond_minimal'])
        $hasil=$far['pond_minimal'];
        
        
    }
    
    
    return $hasil;
}



function ongkos_pond($jumlah)
{
    global $far;
    
    //pond
        $hasil=$jumlah*$far['pond_perdruk'];
        if($hasil<$far['pond_minimal'])
        $hasil=$far['pond_minimal'];

    
    return $hasil;
}


function ongkos_foil($jumlah)
{
    global $far;
    
    //pond
        $hasil=$jumlah*$far['foil_perdruk'];
        if($hasil<$far['foil_minimal'])
        $hasil=$far['foil_minimal'];

    return $hasil;
}




function ongkos_amplop($jumlah,$ukuran)
{
    global $far;
    
    //pond
        $hasil=$jumlah*$far['pond_perdruk'];
        if($hasil<$far['pond_minimal'])
        $hasil=$far['pond_minimal'];

        
   // lem
   if($ukuran=="amplopkecil")
  $ongkoslem=150;
  else
   $ongkoslem=250;
       
    $hasil+=$ongkoslem*$jumlah;
      

    
    return $hasil;
}



function murah_mana($ongkos_cetak,$harga_kertas,$ongkos_print)
{
    
if(($ongkos_cetak+$harga_kertas)<$ongkos_print)
$ongkosx=$ongkos_cetak+$harga_kertas;
else
$ongkosx=$ongkos_print;

return $ongkosx;

}


function ongkos_jilid($jumlah,$halaman,$ukuran,$jilid)
{ global $far,$spek_ukuran;
    

$ongkos_susun=$far["susun"]*$jumlah*$halaman;

    
 if($jilid=="hekter")
 {
    $ongkos_jilid=$far["hekter"]*$jumlah;
 }

else if($jilid=="ring")
 {

$tinggi=$spek_ukuran[$ukuran]["tinggi"];
    
    $tebal=$halaman/150;

$ring=$tebal*$tinggi*$far["ring"];

if($ring<$far["ring_min"])
$ring=$far["ring_min"];

    $ongkos_jilid=$ring*$jumlah;
    

 }


 else if($jilid=="lem")
 {
    $tinggi=$spek_ukuran[$ukuran]["tinggi"];
    
    $tebal=$halaman/150;
    $ongkos_jilid= $tebal*$tinggi*$far["lem_percm"]*$jumlah;
    
   
    if($ongkos_jilid<$far["lem_min"])
   { $ongkos_jilid=$far["lem_satuan"]*$jumlah;


if($ongkos_jilid>$far["lem_min"])
$ongkos_jilid=$far["lem_min"];

    }
 }
 else if($jilid=="jahit")
 {
    
   $ketel=$halaman/16;
    $ongkos_jilid=$ketel*$far["jahit_perketel"];
    
    
 }

    
   $ongkos=$ongkos_susun+$ongkos_jilid; 

//echo $far["ring"]."$jumlah $ongkos_jilid<br>$ongkos_susun";

return $ongkos;

}


function harga_kuping($bahan,$jumlah)
{
global $spek_harga,$spek_ukuran, $far;


$harga_plano=$spek_harga[$bahan];

$harga_kertas=$jumlah*$harga_plano*$spek_ukuran["a5"]["plano"]/($spek_ukuran["a5"]["dibagi"]*2);	

return $harga_kertas;
}


function hitung_ljk($jumlah,$ukuranx,$warnax,$tebalx)

{


$kertas=28000;
$cetak=70000;
$cetak_rim=5000;




$i=$jumlah;
$z=$warnax;
$j=$tebalx;
$k=$ukuranx;

   $jumlah_bahan= $i*1.057;
	
	if($jumlah_bahan>10)
	$harga_cetak=$cetak+(($jumlah_bahan-10)*$cetak_rim);
	else
	$harga_cetak=$cetak;
	
	$harga_bahan=$jumlah_bahan*$kertas;
	$potong=10000+(1000*$i);
	
	



$tebal=array(1=>0.8,1,1.25);
$ukuran=array(1=>0.9,1,1.1);


 

$tampilan=floor(1.25*(($harga_cetak*$z)+($harga_bahan*$ukuran[$k]*$tebal[$j])+$potong)/$i/250)*250;


return $tampilan;


	








}

?>
