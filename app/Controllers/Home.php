<?php

namespace App\Controllers;

use App\Libraries\AHP\MainCriteria;
use App\Libraries\AHP\SubCriteria;
use App\Models\AkumulasiModel;
use App\Models\AlternatifModel;
use App\Models\JurusanModel as model;
use App\Models\KriteriaModel;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->model = new model();
        $this->modelAlternatif = new AlternatifModel();
        $this->modelKriteria = new KriteriaModel();
        $this->modelAkumulasi = new AkumulasiModel();
        $this->config = config('Theme');
        $this->data['config'] = $this->config;
    }
    public function index()
    {
        $alternatif = $this->modelAlternatif->where([
            'id_user' => user_id()
        ])->findAll();
        $this->data['page'] = 'dashboard';
        $this->data['kriteriaDone'] = user()->step_kriteria == 10;
        $this->data['jurusanDone'] = user()->step_jurusan == 10;
        $akumulasi = $this->modelAkumulasi->where([
            'id_user' => user_id()
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

        $result = [];

        if ($this->data['jurusanDone']) {
            foreach ($alternatif as $alt) {
                $value = [];
                for ($i=0; $i < $kriteria['main']->ordo; $i++) {
                    $mainPriority = $kriteria['main']->getPriority()[$i];
                    $subPriority = null;
                    $idSubPair = (int)$alt->nilai[$i];
                    foreach ($kriteria['sub'][$i]->features as $fid => $fv) {
                        if ($fv->id == $idSubPair) {
                            $subPriority = $kriteria['sub'][$i]->getPriority()->sub[$fid];
                        }
                    }
                    $value[] = (float)number_format($mainPriority * $subPriority, 3);
                }
                $result[] = [
                    'nama' => $alt->jurusan->nama,
                    'nilai' => $value,
                    'total'=> array_sum($value)
                ];

                usort($result, function ($item1, $item2) {
                    return $item2['total'] <=> $item1['total'];
                });
            }
        }

        $this->data['kriteria'] = $kriteria;
        $this->data['alternatif'] = $alternatif;
        $this->data['result'] = $result;
        return view('Panel/Page/panel', $this->data);
    }
    public function formPilihJurusan()
    {
        $items = $this->model->findAll();
        $options = [];
        foreach ($items as $jurusan) {
            $options[] = [
                "id" => $jurusan->id,
                "text" => $jurusan->nama,
            ];
        }
        $data = [
            "url" => base_url(route_to("data-jurusan-set")),
            "mode" => "modal",
            "fields" => [
                [
                    "type" => "multiselect",
                    "name" => "jurusan",
                    "prefix" => "Pilih",
                    "label" => "Pilih Jurusan",
                    "options" => $options
                ],
            ],
        ];
        return $this->respond($data, 200);
    }
}