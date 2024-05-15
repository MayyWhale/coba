<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Libraries\AHP\MainCriteria;
use App\Libraries\AHP\SubCriteria;
use App\Models\AkumulasiModel;
use App\Models\KriteriaModel as modelMain;
use App\Models\SubKriteriaModel as modelSub;

class Hitung extends BaseController
{
    public function __construct()
    {
        $this->config = config('Theme');
        $this->data['config'] = $this->config;
        $this->modelMain = new modelMain();
        $this->modelSub = new modelSub();
        $this->modelAkumulasi = new AkumulasiModel();
    }
    public function index()
    {
        $this->data['page'] = 'perhitungan';
        $akumulasi = user()->step_kriteria < 10 ? null : $this->modelAkumulasi->where([
            "id_user" => user()->id
        ])->findAll();
        $kriteria = [];
        if ($akumulasi) {
            foreach ($akumulasi as $i => $v) {
                if ($v->type == 'main') {
                    $set = new MainCriteria($v->list_main, $v->nilai);
                    $main = $set;
                } else {
                    $set = new SubCriteria($v->list_sub, $v->nilai);
                    $sub[] = $set;
                }
            }
            $kriteria = [
                "main" => $main,
                "sub" => $sub,
            ];
        }
        $this->data['result'] = $kriteria;
        $this->data['akumulasi'] = $akumulasi;
        return view('Panel/Page/Hitung/index', $this->data);
    }
}