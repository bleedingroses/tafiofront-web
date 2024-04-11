<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use App\Tafio\bisnis\src\Models\grup;
use App\Tafio\bisnis\src\Models\projectDetail;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class project_schedule extends Resource
{
    public function config()
    {
        $this->projectDetail = projectDetail::find(ambil("schedule"));
        $this->halaman = (new crud)->make('project_projectDetail')
            ->customForm('custom.jasa.formJadwal')
        // ->parentDataModel($this->project)
            ->route('edit')
            ->popUp()
            ->redirect('bisnis/jasa/project/' . ambil("project"));

        $this->jadwal = grup::ambil('produksi')->projectFlow;
    }

    public function update_proses($projectDetail)
    {

        request()->validate([
            'deadline' => 'required',
        ]);

        $sync = [];
        foreach ($this->jadwal as $item => $jadwal) {
            $xx = "data_" . $jadwal->id;
            // dd($xx);
            if (request()->input($xx)) {
                $sync[$jadwal->id] = ['deadline' => request()->input($xx)];
            }

        }
        $projectDetail->flow()->sync($sync);

        $projectDetail->update([
            'deadline' => request()->deadline,
        ]);
    }

}
