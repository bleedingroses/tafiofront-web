<?php 
global $far, $spek_harga,$spek_mesin,$spek_ukuran,$spek_laminasi,$spek_berat,$spek_plano,$spek_bahan;

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
"harga_ncr"=>42000,
"nota_lem"=>10000,
"nota_porporasi"=>8000,
"nota_numerator"=>5000,
"ring"=>80,
"ring_min"=>700,

);



//cara menghitung tebal x variable ----- untuk plano 79x108

$spek_harga= array("ap100"=>1350,
              "ap120"=>1600,
              "ap150"=>2000,
              "ap210"=>2850,
              "ap230"=>3100,
              "ap260"=>3500,
              "ap310"=>4200,
              "hvs70"=>770,             
              "hvs80"=>880,
              "hvs100"=>1100,
              "chromo"=>3700,
              "vinil"=>14000,
              "coronado"=>12000
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


$spek_plano=array("108x79"=>array("panjang"=>108,"lebar"=>79,"pengali"=>1),
                   "100x65"=>array("panjang"=>100,"lebar"=>65,"pengali"=>0.762),
                   "90x65"=>array("panjang"=>90,"lebar"=>65,"pengali"=>0.686),
                   "92x61"=>array("panjang"=>92,"lebar"=>61,"pengali"=>0.658),
                   "86x61"=>array("panjang"=>86,"lebar"=>61,"pengali"=>0.615),
                   "120x90"=>array("panjang"=>120,"lebar"=>90,"pengali"=>1),
                   "108x70"=>array("panjang"=>108,"lebar"=>70,"pengali"=>1)
                   );

$spek_bahan=array("ap"=>array("108x79","100x65","90x65","92x61"),
                  "hvs"=>array("86x61","100x65","92x61","90x65","108x79"),
                  "chromo"=>array("108x70"),
                  "duplek"=>array("108x79","120x90"),
                  "coronado"=>array("108x79")
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
             "amplopkecil"=>array("cover"=>"","plano"=>1,"dibagi"=>12,"mesin"=>"sm52","perset_jadi"=>1,"perprint_jadi"=>1,"luas"=>702,"tinggi"=>25),
             "sm52"=>array("mesin"=>"sm52","perset_jadi"=>1),   
             "sm72"=>array("mesin"=>"sm72","perset_jadi"=>1),
             "sors"=>array("mesin"=>"sors","perset_jadi"=>1),

);

$spek_mesin= array("sm52"=>array("min"=>80000,"druk"=>20,"panjang"=>51,"lebar"=>35.5,"min_panjang"=>17,"min_lebar"=>13.5),
              "ko66"=>array("min"=>130000,"druk"=>30),
              "sm72"=>array("min"=>160000,"druk"=>40,"panjang"=>71,"lebar"=>50.5,"min_panjang"=>39,"min_lebar"=>26.5),
              "sors"=>array("min"=>320000,"druk"=>80,"panjang"=>101,"lebar"=>70.5,"min_panjang"=>52,"min_lebar"=>29.5),
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


function jenis_kertas($kertas)
{

if(strpos($kertas,"ap")!==false)
  {$jenis="ap";
}
else if(strpos($kertas,"hvs")!==false)
  $jenis="hvs";
else if(strpos($kertas,"chromo")!==false)
  $jenis="chromo";

return $jenis;

}


function optimasi_bahan($panjang,$lebar,$bahan)
{

 global $spek_bahan,$spek_plano;



$set_max=1000000000;
foreach ($spek_bahan[$bahan] as $plano) {


$panjang_plano=$spek_plano[$plano]["panjang"];
$lebar_plano=$spek_plano[$plano]["lebar"];


$hasil=optimasi($panjang_plano,$lebar_plano,$panjang,$lebar);



$itungan=floor($panjang_plano*$lebar_plano/$hasil['set']);



if($itungan<$set_max)
{

$set_max=$itungan;
$plano_max=$plano;
$gambar_max=$hasil['gambar'];
$jumlah_set=$hasil['set'];
}


}

return array("set"=>$jumlah_set,"gambar"=>$gambar_max,"plano"=>$plano_max);


}

/**


*/

function optimasi($panjang_media,$lebar_media,$panjang_jadi,$lebar_jadi,$format=null)


{
$hasilx=$yg_tidur=$yg_berdiri=$jumlah_tidur=$jumlah_berdiri=$yg_posisi=0;



if($format=="bbb")
  $lebar_media-=1.5;



$panjangx=$panjang_media;
$lebarx=$lebar_media;
$posisi="tidur";







for($j=1;$j<=2;$j++)
{


$kolom_tidur=floor($panjangx/$panjang_jadi);
$baris_tidur=floor($lebarx/$lebar_jadi);
$baris_berdiri=floor($lebarx/$panjang_jadi);




$xx=1;

if($format=="bbb" and $posisi=="tidur")
{$baris_tidur-=$baris_tidur%2;
$baris_berdiri-=$baris_berdiri%2;
}

else if($format=="bbs" and $posisi=="berdiri")
{$baris_tidur-=$baris_tidur%2;
$baris_berdiri-=$baris_berdiri%2;
}


else if($format=="bbs" and $posisi=="tidur")
$xx=2;

else if($format=="bbb" and $posisi=="berdiri")
$xx=2;






for($i=0;$i<=$kolom_tidur;$i=$i+$xx)
{

$sisa=floor(($panjangx-($panjang_jadi*$i))/$lebar_jadi);




if($format=="bbs" and $posisi=="tidur")
$sisa-=$sisa%2;
else if($format=="bbb" and $posisi=="berdiri")
$sisa-=$sisa%2;


$total_tidur=$i*$baris_tidur;
$total_berdiri=$sisa*$baris_berdiri;





$hasil=$total_tidur+$total_berdiri;


if($hasil>$hasilx)
{

$hasilx=$hasil;
$yg_posisi=$posisi;
$yg_tidur=$i;

$yg_berdiri=$sisa;

$jumlah_tidur=$baris_tidur;
$jumlah_berdiri=$baris_berdiri;


}

}

$lebarx=$panjang_media;
$panjangx=$lebar_media;
$posisi="berdiri";

}



$panjang_potong=($panjang_jadi*$yg_tidur)+($lebar_jadi*$yg_berdiri);

$lebar_potong=($panjang_jadi*$jumlah_berdiri)>($lebar_jadi*$jumlah_tidur)?$panjang_jadi*$jumlah_berdiri:$lebar_jadi*$jumlah_tidur;





$ukuran=sesuaikan_panjang($panjang_potong,$lebar_potong);
$panjang_potong=$ukuran["panjang"];
$lebar_potong=$ukuran["lebar"];



$gambar= array("kolom_tidur"=>$yg_tidur,"baris_tidur"=>$jumlah_tidur,"kolom_berdiri"=>$yg_berdiri,"baris_berdiri"=>$jumlah_berdiri);

$hasil=array("set"=>$hasilx,"gambar"=>$gambar,"panjang"=>$panjang_potong,"lebar"=>$lebar_potong);

return $hasil;

}


/**



*/

function optimasi_gak_komplit($panjang_mesin,$lebar_mesin,$pcetak,$lcetak,$set_sisa,$format=null)

{  

global $spek_mesin,$spek_bahan;



if($format=="bbb")

  $lebar_mesin-=1.5;


if($set_sisa>2)
{


$terkecil=9000000000;

$posisi="tidur";


$panjang_media=$panjang_mesin;
$lebar_media=$lebar_mesin;


for($j=1;$j<=2;$j++)
{


$kolom_tidur_max=floor($panjang_media/$pcetak);

//iterasi kolom tidur
for($i=1;$i<=$kolom_tidur_max;$i++)

 {

$kolom_berdiri=0;

//iterasi kolom berdiri
while(true)
{

if(($i*$pcetak)+($kolom_berdiri*$lcetak)>$panjang_media)
break;

$yg_tidur=$set_sisa-($kolom_berdiri);

if($yg_tidur<1)
break;

$baris_tidur=ceil($yg_tidur/$i);

if($kolom_berdiri>0 and $baris_tidur*$lcetak<$pcetak)
  break;





// mencari jumlah baris berdiri paling optimal
$baris_berdiri=0;
while(true)
{




$yg_tidur=$set_sisa-($baris_berdiri*$kolom_berdiri);



if($yg_tidur<1)
break;




$baris_tidur=ceil($yg_tidur/$i);





if($baris_berdiri*$pcetak>$lebar_media)
  break;


if($baris_tidur*$lcetak>$lebar_media)
{

$baris_berdiri++;
continue; }


//if($posisi=="tidur" and $i==1)
//echo "xx<br>";


if(($format=="bbs" and $posisi=="tidur")or($format=="bbb" and $posisi=="berdiri"))
{

if($i%2==1 or $kolom_berdiri%2==1)
 { 
  $baris_berdiri++;
  continue;
}
}



if(($format=="bbb" and $posisi=="tidur")or($format=="bbs" and $posisi=="berdiri"))
{

if($baris_tidur%2==1 or $baris_berdiri%2==1)
 { 

//echo "xxxx".$baris_tidur."<br>";


  $baris_berdiri++;
  continue;
}
}

//echo $baris_tidur."$posisi $format<br>";


$tinggi1=$baris_tidur*$lcetak;
$tinggi2=$baris_berdiri*$pcetak;
$tinggi=$tinggi1>$tinggi2?$tinggi1:$tinggi2;
$ukuranx=($tinggi*(($i*$pcetak)+($kolom_berdiri*$lcetak)));


if($ukuranx<$terkecil)
{

$baris_tidur_final=$baris_tidur;
$kolom_tidur_final=$i;
$baris_berdiri_final=$baris_berdiri;
$kolom_berdiri_final=$kolom_berdiri;
$terkecil=$ukuranx;

$posisi_final=$posisi;

//echo "kolom_berdiri_final:$kolom_berdiri_final baris_berdiri_final:$baris_berdiri_final kolom_tidur_final:$kolom_tidur_final, baris_tidur_final:$baris_tidur_final ,terkecil$terkecil<br>";

}


if($kolom_berdiri==0)
  break;

$baris_berdiri++;

}


$kolom_berdiri++;

}} 

$panjang_media=$lebar_mesin;
$lebar_media=$panjang_mesin;
$posisi="berdiri";
}

}
else

{

//$lebar_bahan=$lcetak*$set_sisa;
//$panjang_bahan=$pcetak;

$kolom_tidur_final=1;
$baris_tidur_final=$set_sisa;

$kolom_berdiri_final=0;
$baris_berdiri_final=0;

if($set_sisa==2)
$posisi_final="berdiri";
else
$posisi_final="tidur";

}
$lebar_bahan=($baris_tidur_final*$lcetak);
$panjang_bahan=$kolom_tidur_final*$pcetak+($kolom_berdiri_final*$lcetak);



$ukuran=sesuaikan_panjang($panjang_bahan,$lebar_bahan);
$panjang_bahan=$ukuran["panjang"];
$lebar_bahan=$ukuran["lebar"];

$gambar= array("kolom_tidur"=>$kolom_tidur_final,"baris_tidur"=>$baris_tidur_final,"kolom_berdiri"=>$kolom_berdiri_final,"baris_berdiri"=>$baris_berdiri_final);

return array("panjang"=>$panjang_bahan,"lebar"=>$lebar_bahan,"gambar"=>$gambar);

}



/**


*/

function optimasi_setting($pcetak,$lcetak,$set,$muka)
{ global $spek_mesin;



$mesin=optimasi_mesin($pcetak,$lcetak);




if($mesin!="kegedean"){



if($muka==2)
{
$set*=2;
$format_komplit="bolak balik";
}

else
$format_komplit="semuka";


$lebar_mesin=$spek_mesin[$mesin]["lebar"];
$panjang_mesin=$spek_mesin[$mesin]["panjang"];

$area_cetak=optimasi($panjang_mesin,$lebar_mesin,$pcetak,$lcetak);
$jumlah_mata=$area_cetak["set"];
$duplikasi=1;




$set_komplit_final=$total_plat=ceil($set/$jumlah_mata);




$set_komplit=floor($set/$jumlah_mata);
$mata_sisa=$set_sisa=$set%$jumlah_mata;


$panjang_komplit=$area_cetak["panjang"];
$lebar_komplit=$area_cetak["lebar"];
$gambar_komplit=$area_cetak["gambar"];





if($muka==2)
{

if($total_plat%2==0)
 
{

if($set_sisa)

{


$set_komplit_final-=2;
$set_gak_komplit_final=2;

$mata_sisa=$set_sisa_bb=($set_sisa+$jumlah_mata)/2;




$duplikasi=floor($jumlah_mata/$set_sisa_bb);

$set_sisax=$set_sisa_bb*$duplikasi;  


if($set_sisax==$jumlah_mata)
{

$panjang_gak_komplit=$panjang_komplit;
$lebar_gak_komplit=$lebar_komplit;
$gambar_gak_komplit=$gambar_komplit;



}
else
{


//echo $set_sisa_bb;
$sisa=optimasi_gak_komplit($panjang_mesin,$lebar_mesin,$pcetak,$lcetak,$set_sisax);

$panjang_gak_komplit=$sisa["panjang"];
$lebar_gak_komplit=$sisa["lebar"];
$gambar_gak_komplit=$sisa["gambar"];


}

$format="bolak balik";

}

} 
else
{


$area_cetak_bbs=optimasi($panjang_mesin,$lebar_mesin,$pcetak,$lcetak,"bbs");
$area_cetak_bbb=optimasi($panjang_mesin,$lebar_mesin,$pcetak,$lcetak,"bbb");


if($set_sisa>0)
  $set_terakhir=$set_sisa;
else 
  $mata_sisa=$set_terakhir=$jumlah_mata;


$set_komplit_final--;
$set_gak_komplit_final=1;


if($set_terakhir==$area_cetak_bbs["set"])
{



$panjang_gak_komplit=$area_cetak_bbs["panjang"];
$lebar_gak_komplit=$area_cetak_bbs["lebar"];
$gambar_gak_komplit=$area_cetak_bbs["gambar"];
$format="bbs";


} 
else if($set_terakhir==$area_cetak_bbb["set"])
{


$panjang_gak_komplit=$area_cetak_bbb["panjang"];
$lebar_gak_komplit=$area_cetak_bbb["lebar"];
$gambar_gak_komplit=$area_cetak_bbb["gambar"];
$format="bbb";



}
else if($set_terakhir<$area_cetak_bbs["set"])
{



$duplikasi=floor($area_cetak_bbs["set"]/$set_terakhir);

$set_sisax=$set_terakhir*$duplikasi;  


if($set_sisax==$area_cetak_bbs["set"])
{

$panjang_gak_komplit=$area_cetak_bbs["panjang"];
$lebar_gak_komplit=$area_cetak_bbs["lebar"];
$gambar_gak_komplit=$area_cetak_bbs["gambar"];

}
else
{

$bbs_gak_komplit=optimasi_gak_komplit($panjang_mesin,$lebar_mesin,$pcetak,$lcetak,$set_sisax,"bbs");


$panjang_gak_komplit=$bbs_gak_komplit["panjang"];
$lebar_gak_komplit=$bbs_gak_komplit["lebar"];
$gambar_gak_komplit=$bbs_gak_komplit["gambar"];


}
$format="bbs";

}
else if($set_terakhir<$area_cetak_bbb["set"])
{


$duplikasi=floor($area_cetak_bbs["set"]/$set_terakhir);

$set_sisax=$set_terakhir*$duplikasi;  


if($set_sisax==$area_cetak_bbb["set"])
{

$panjang_gak_komplit=$area_cetak_bbb["panjang"];
$lebar_gak_komplit=$area_cetak_bbb["lebar"];
$gambar_gak_komplit=$area_cetak_bbb["gambar"];

}
else
{





$bbs_gak_komplit=optimasi_gak_komplit($panjang_mesin,$lebar_mesin,$pcetak,$lcetak,$set_sisax,"bbb");

$panjang_gak_komplit=$panjang["panjang"];
$lebar_gak_komplit=$bbs_gak_komplit["lebar"];
$gambar_gak_komplit=$bbs_gak_komplit["gambar"];
}


$format="bbb";



}
else 
{


$set_gak_komplit_final=2; 


$mata_sisa=$set_gak_komplit=($set_terakhir+$jumlah_mata)/2;



$duplikasi=floor($jumlah_mata/$mata_sisa);

$set_sisax=$mata_sisa*$duplikasi;  

if($set_sisax==$jumlah_mata)
{

$panjang_gak_komplit=$panjang_komplit;
$lebar_gak_komplit=$lebar_komplit;
$gambar_gak_komplit=$gambar_komplit;

}
else
{


$bb_gak_komplit=optimasi_gak_komplit($panjang_mesin,$lebar_mesin,$pcetak,$lcetak,$set_sisax);


$panjang_gak_komplit=$bb_gak_komplit["panjang"];
$lebar_gak_komplit=$bb_gak_komplit["lebar"];
$format="bolak balik";
$gambar_gak_komplit=$bb_gak_komplit["gambar"];
}



} 
}

}

else
{


if($set_sisa)
{


$set_komplit_final--;
$set_gak_komplit_final=1;



$duplikasi=floor($jumlah_mata/$set_sisa);

$set_sisax=$set_sisa*$duplikasi;  


if($set_sisax==$jumlah_mata)
{

$panjang_gak_komplit=$panjang_komplit;
$lebar_gak_komplit=$lebar_komplit;
$format="semuka";
$gambar_gak_komplit=$gambar_komplit;



}
else
{

$bb_gak_komplit=optimasi_gak_komplit($panjang_mesin,$lebar_mesin,$pcetak,$lcetak,$set_sisax);
$panjang_gak_komplit=$bb_gak_komplit["panjang"];
$lebar_gak_komplit=$bb_gak_komplit["lebar"];
$format="semuka";
$gambar_gak_komplit=$bb_gak_komplit["gambar"];

}

}
}


if($set_komplit_final)
$komplit= array("panjang"=>$panjang_komplit+1,"lebar"=>$lebar_komplit+1.5,"set"=>$set_komplit_final,
  "format"=>$format_komplit,"gambar"=>$gambar_komplit,"mata"=>$jumlah_mata);
else
$komplit=null;  

if(!empty($set_gak_komplit_final))
$gak_komplit= array("panjang"=>$panjang_gak_komplit+1,"lebar"=>$lebar_gak_komplit+1.5,"set"=>$set_gak_komplit_final,
  "format"=>$format,"gambar"=>$gambar_gak_komplit,"duplikasi"=>$duplikasi,"mata"=>$mata_sisa);
else
$gak_komplit=null; 

return array("komplit"=>$komplit,"gak_komplit"=>$gak_komplit,"mesin"=>$mesin);

}
else
return "kegedean";
}




function optimasi_gambar($pcetak,$lcetak,$gambarx)
{


$ukuran_max=500;


$kolom_tidur_final=$gambarx["kolom_tidur"];
$baris_tidur_final=$gambarx["baris_tidur"];
$kolom_berdiri_final=$gambarx["kolom_berdiri"];
$baris_berdiri_final=$gambarx["baris_berdiri"];


$lebar_bahan=($baris_tidur_final*$lcetak);
$panjang_bahan=$kolom_tidur_final*$pcetak+($kolom_berdiri_final*$lcetak);




if($lebar_bahan<$panjang_bahan)
{
$lebar_gambar=floor($lebar_bahan/$panjang_bahan*$ukuran_max);
$panjang_gambar=$ukuran_max;

$panjang_gambarx= floor($pcetak/$panjang_bahan*$ukuran_max);
$lebar_gambarx= floor($lcetak/$panjang_bahan*$ukuran_max);

}
else
{
$panjang_gambar=floor($panjang_bahan/$lebar_bahan*$ukuran_max);
$lebar_gambar=$ukuran_max;

$panjang_gambarx= floor($pcetak/$lebar_bahan*$ukuran_max);
$lebar_gambarx= floor($lcetak/$lebar_bahan*$ukuran_max);
}








$gambar="<table border=2 bordercolor=yellow width=$panjang_gambar height=$lebar_gambar>
<tr><td><table border=0>";


if($kolom_tidur_final>0)
{
for($i=1;$i<=$kolom_tidur_final;$i++)
{

$lebar_kolom=$panjang_gambarx;
if($i==$kolom_tidur_final)
$lebar_kolom="";



$gambar.="<td valign=top width=$lebar_kolom>";

for($j=1;$j<=$baris_tidur_final;$j++)
{

$gambar.="<table border=2 bordercolor=red width=$panjang_gambarx height=$lebar_gambarx><td></table>";

}
}}

if($kolom_berdiri_final>0)
{
for($i=1;$i<=$kolom_berdiri_final;$i++)
{
$lebar_kolom=$lebar_gambarx;
if($i==$kolom_berdiri_final)
$lebar_kolom="";
$gambar.="<td valign=top width=$lebar_kolom>";

for($j=1;$j<=$baris_berdiri_final;$j++)
{

$gambar.="<table border=1 bordercolor=red width=$lebar_gambarx height=$panjang_gambarx><td></table>";

}
}}



 $gambar.="</table></table>";

return $gambar;

}  

function sesuaikan_panjang($panjang,$lebar)
{  


if ($panjang<$lebar)

{
$x=$lebar;
$lebar=$panjang;
$panjang=$x;
}

return array("panjang"=>$panjang,"lebar"=>$lebar);

}
 

function optimasi_mesin($pcetak,$lcetak)
{  

global $spek_mesin,$spek_bahan;

// pilih mesin
if($pcetak<=$spek_mesin["sm52"]["panjang"] and $lcetak<=$spek_mesin["sm52"]["lebar"])
$mesin="sm52"; 
else if($pcetak<=$spek_mesin["sm72"]["panjang"] and $lcetak<=$spek_mesin["sm72"]["lebar"])
$mesin="sm72"; 
else if($pcetak<=$spek_mesin["sors"]["panjang"] and $lcetak<=$spek_mesin["sors"]["lebar"])
$mesin="sors"; 
else
$mesin="kegedean"; 


 return $mesin;
}

 
function hitung_plano($jenis_kertas,$pkertas,$lkertas)
{
  global $spek_mesin,$spek_bahan,$spek_plano;

$hasil_tmp=1000000000000;

foreach ($spek_bahan[$jenis_kertas] as $plano) {
  
$panjangx=$spek_plano[$plano]["panjang"];
$lebarx=$spek_plano[$plano]["lebar"];


$horisontal1=floor($panjangx/$pkertas);
$vertikal1=floor($lebarx/$lkertas);
$hasil1=$horisontal1*$vertikal1;

$horisontal2=floor($panjangx/$lkertas);
$vertikal2=floor($lebarx/$pkertas);
$hasil2=$horisontal2*$vertikal2;


if($hasil1>$hasil2)
 $hasilz=$hasil1;

else
 $hasilz=$hasil2;



$hasilx=$panjangx*$lebarx/$hasilz;

if($hasilx<$hasil_tmp)
{
$final["plano"]=$plano;
$final["jadi"]=$hasilz;
$hasil_tmp=$hasilx; 

}
}
return $final;
}

function harga_jual($harga)

{  

if($harga<=5000000)
$untung=1.35;
 else if ($harga<=15000000)
$untung=(135-(($harga/1000000)-5))/100;
else
 $untung=1.25;


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


$hasil="<select name=$nama class='dropdown form-control'>";
     
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
 

if (is_numeric($ukuran))
  $luas=$ukuran;
  else
$luas=$spek_ukuran[$ukuran]["luas"];

   $laminasi_cetak=$jumlah_cetak*$spek_laminasi[$laminasi]["percm"]*$luas; 
   
   
 
if($laminasi_cetak<$spek_laminasi[$laminasi]["min"])
$laminasi_cetak=$spek_laminasi[$laminasi]["min"];




$laminasi_print="50000000000";
if (!is_numeric($ukuran))
  { 
if($laminasi!="spot1")
{if($ukuran!="a2" and $ukuran!="dblfolio")
$laminasi_print=$jumlah_print*$far['harga_laminasi_print']/$spek_ukuran[$ukuran]["perprint_jadi"]*$spek_laminasi[$laminasi]["muka"];
else
$laminasi_print=$jumlah_print*$far['harga_laminasi_a2']*$spek_laminasi[$laminasi]["muka"];
}

}


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
