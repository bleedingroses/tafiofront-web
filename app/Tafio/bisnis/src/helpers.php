<?php
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Carbon;

function script_ar($list_ar, $id_ar)
{
    $hasil = "<script>
              new Vue({
                el: '#app',
                data: {
                  ar: '" . $id_ar . "'
                },
                computed: {";

    foreach ($list_ar as $id) {
        $hasil .= $id . ": function () {
        if(this.ar=='" . $id . "' || this.ar=='semua')
        return true
        else
            return false
          },";
    }

    $hasil .= "kosong: function () {
      if(this.ar=='semua') return true
        else
            return false
          },
        }
      })
      </script>";
    return $hasil;
}

function icon_pembayaran($pembayaran, $total)
{
    if ($pembayaran == 0) {$icon = 'fa-ban';
        $label = 'text-danger';} else if ($pembayaran < $total) {$icon = 'fa-spinner';
        $label = 'text-warning';} else {
        $icon = 'fa-thumbs-o-up';
        $label = 'text-primary';
    }
    return " <i class='fa " . $icon . " " . $label . "'></i>";
}

function newJadwal($deadline)
{
    if (!empty($deadline)) {
        $date1 = date_create(now());
        $date2 = date_create($deadline);
        $diff = date_diff($date1, $date2);
        $days = $diff->days;

        $hasil = $days;
        if ($days == 0) {
            $class = "warning";
        } else if ($days > 0) {
            if ($diff->invert == 1) {
                $hasil = "-" . $hasil;
                $class = "danger";
            } else {
                $class = "success";
            }

        }
        return " <small> <span class='label label-" . $class . "' style='font-size:90%'>" . $hasil . "</span></small>";
    } else {
        return "";
    }
}

function icon_ar($ar)
{
    $icon = '';
    if ($ar) {
        $icon = "<span style='background-color:" . $ar->warna . "' class='label label-rounded'>" . ($ar->kode) . "</span>";
    }

    return $icon;
}

function hitungTahun($awal){
     $now = Carbon::now();
        $b_day = Carbon::parse($awal);
        $tahun = $b_day->diffInYears($now);
        $bulan = $b_day->diffInMonths($now);
        $selisih=$bulan -($tahun*12);
        return ['tahun'=>$tahun,'bulan'=>$selisih] ;
}

function grouping($obj)
{
    $hasil = array();
    $tampilan = '';

    $project_id = 0;
    $tampilan = '';
    foreach ($obj as $detail) {

        /////// tambah baris baru

        if ($project_id != $detail->project_id) {
            if ($project_id != 0) {
                $tampilan .= '<div class=pull-right></div></a>';
            }

            $warna = '';
            $nominal = '';
            $project = $detail->project;

            $total = $project->total;
            if ($total < 1000000) {
                $warna = 'black';
                if ($total == 0) {
                    $nominal = 0;
                } else {
                    $nominal = floor($total / 1000) . 'rb';
                }

            } else {

                if ($total <= 5000000) {
                    $warna = 'green';
                } else if ($total <= 10000000) {
                    $warna = '#FAA814';
                } else {
                    $warna = '#D93007';
                }

                $nominal = round($total, -5) / 1000000 . 'jt';
            }

            $konsumen = $project->kontak;

            $model_ar = $konsumen->ar->kode ?? 'kosong';
            $tampilan .= "<a class='popup-tafio'  href='" . url('bisnis/jasa/project/' . $detail->project_id ) . "' v-show=" . $model_ar . " >
        <p style='font-weight:600' class='text-default pull-left mr-1'>";

            if (!empty($konsumen->ar) and session('totalAr') > 1) {
                $tampilan .= " <span class='label label-rounded' style='background-color: " . $konsumen->ar->warna . "'> " . $konsumen->ar->kode . "  </span>";
            }

            $tampilan .= " <span class='label label-rounded mr-1' style='background-color: " . $warna . "'> " . $nominal . "  </span> ";

            $tampilan .= $konsumen->namaRingkas . '</p>';

        }

////////////////ngisi order detail

        $proses = '';
        if (!empty($detail->process)) {
            $proses = "<span class='label label-info  label-rounded' style='background-color: " . '#' . $detail->process->warna . ";'>" . $detail->process->nama . "</span>";
        }

        $nama_produk = $detail->produk->namaLengkap;

        $jadwalx = '';

        $jadwal = $detail->flow()->find($detail->project_flow_id);

        if ($jadwal) {
            $deadline = $jadwal->pivot->deadline;
            // $tampilan.= newJadwal($deadline);
            $jadwalx = newJadwal($deadline);
            // " <span class='label label-info ' style='background-color:red'>".$deadline."</span>";
        }

        $tampilan .= "<span style='color:#636363'> " . $nama_produk . " " . $proses . $jadwalx . "</span> ";

        $project_id = $detail->project_id;
    }

    if ($project_id != 0) {
        $tampilan .= '
 <div class=pull-right></div>
    </a>';
    }

    return $tampilan;
}
