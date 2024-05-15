<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\KriteriaModel as model;
use App\Entities\Kriteria as entity;
use App\Entities\SubKriteria as subEntity;
use App\Models\SubKriteriaModel as subModel;
use CodeIgniter\API\ResponseTrait;
use stdClass;

class Kriteria extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->model = new model();
        $this->subModel = new subModel();
    }

    public function add()
    {
        $data = $this->request->getPost();

        $Rules = [
            'nama' => 'required',
            'kode' => 'required|is_unique[spk_kriteria.kode]',
        ];
        if (!$this->validate($Rules)) {
            $error = $this->validator->getErrors();
            $error = implode("<br>", $error);
            return redirect()->back()->withInput()->with('error', $error);
        }

        $sub = [];

        // Cek apakah ada sub kriteria
        if (isset($data['sub-label'])) {
            for ($i=0; $i < count($data['sub-label']); $i++) {
                $sub[] = [
                    'label' => $data['sub-label'][$i],
                    'keterangan' => $data['sub-keterangan'][$i],
                ];
            }
            unset($data['sub-label']);
            unset($data['sub-keterangan']);
        }


        $item = new entity($data);
        if ($this->model->save($item)) {
            // Simpan sub kriteria jika ada
            if ($sub) {
                $itemSub = [];
                foreach ($sub as $k => $v) {
                    $sub[$k]['id_kriteria'] = $this->model->getInsertID();
                    $itemSub[] = new subEntity($sub[$k]);
                }
                if ($this->subModel->insertBatch($itemSub)) {
                    return redirect()->route('data-kriteria')->with('message', 'Data berhasil ditambah');
                }
                return redirect()->route('data-kriteria')->with('error', 'Gagal Menambah Sub Kriteria');
            }

            return redirect()->route('data-kriteria')->with('message', 'Data berhasil diubah');
        }
    }

    public function edit($id)
    {
        $data = $this->request->getPost();
        $Rules = [
            'nama' => 'required',
            'kode' => 'required|is_unique[spk_kriteria.kode,id,' . $id . ']',
        ];
        if (!$this->validate($Rules)) {
            $error = $this->validator->getErrors();
            $error = implode("<br>", $error);
            return redirect()->back()->withInput()->with('error', $error);
        }

        unset($data['sub-id'],$data['sub-label'],$data['sub-keterangan']);

        $item = $this->model->find($id);
        $item->fill($data);

        if ($item->hasChanged()) {
            if (!$this->model->save($item)) {
                return redirect()->route('data-kriteria')->with('error', 'Data Gagal diubah');
            }
            return redirect()->route('data-kriteria')->with('message', 'Data kriteria berhasil diubah');
        }
        return redirect()->route('data-kriteria')->with('message', 'Tidak ada data yang diubah');
    }

    public function delete($id)
    {
        $subKriteria = $this->subModel->where('id_kriteria', $id)->findAll();

        if ($subKriteria) {
            if ($this->subModel->where('id_kriteria', $id)->delete()) {
                if ($this->model->delete($id)) {
                    return redirect()->route('data-kriteria')->with('message', 'Data berhasil dihapus');
                }
            }
        } else {
            if ($this->model->delete($id)) {
                return redirect()->route('data-kriteria')->with('message', 'Data berhasil dihapus');
            }
        }
    }

    public function saveSub($id)
    {
        $data = $this->request->getVar();

        // Normalize the Data
        $sender = [];
        $sender['id'] = $data->{'sub-id'} ?? null;
        $sender['id_kriteria'] = $id;
        $sender['label'] = $data->{'sub-label'};
        $sender['keterangan'] = $data->{'sub-keterangan'};

        if ($sender['id']) {
            $item = $this->subModel->find($sender['id']);
            $item->fill($sender);
        } else {
            $item = new subEntity($sender);
        }

        if (!$item->hasChanged()) {
            return $this->respond([
                'error' => "Tidak ada data yang berubah",
            ], 200);
        } else {
            $res = $sender['id'] ? 'diubah' : 'disimpan';
            if ($this->subModel->save($item)) {
                return $this->respond([
                    'message' => "Data sub kriteria berlabel $item->label berhasil $res",
                    'fields' => [
                        [
                            "type" => "hidden",
                            "name" => "sub-id[]",
                            "value" => $id,
                        ],
                        [
                            "type" => "text",
                            "name" => "sub-label[]",
                            "prefix" => "Masukkan",
                            "label" => "Label Sub Kriteria",
                            "value" => $sender['label'],
                        ],
                        [
                            "type" => "text",
                            "name" => "sub-keterangan[]",
                            "prefix" => "Masukkan",
                            "label" => "Keterangan Sub Kriteria",
                            "value" => $sender['keterangan'],
                        ],
                    ],
                ], 200);
            }
        }
        return $this->respond([
            'error' => "Data sub kriteria berlabel $item->label gagal $res",
        ], 200);
    }

    public function deleteSub($id)
    {
        $data = $this->request->getVar();
        $item = $this->subModel->where([
            'deleted_at' => null,
            ])->find($data->keyword);

        if ($item) {
            if ($this->subModel->delete($item->id)) {
                return $this->respond([
                    'message' => "Data sub kriteria berlabel $item->label berhasil dihapus",
                ], 200);
            }
            return $this->respond([
                'error' => "Data sub kriteria berlabel $item->label gagal dihapus",
            ], 200);
        }
        return $this->respond([
            'info' => "Tidak ada data yang dihapus",
        ], 200);
    }

    public function form()
    {
        $id = $this->request->getVar('id');
        $item = $this->model->find($id);

        $sub = $this->subModel->where([
            'id_kriteria' => $id,
            'deleted_at' => null,
        ])->findAll();

        $subVal = [];
        if ($sub) {
            foreach ($sub as $v) {
                $subVal[] = [
                    [
                        "type" => "hidden",
                        "name" => "sub-id[]",
                        "value" => $v->id,
                    ],
                    [
                        "type" => "text",
                        "name" => "sub-label[]",
                        "prefix" => "Masukkan",
                        "label" => "Label Sub Kriteria",
                        "required" => false,
                        "value" => $v->label,
                    ],
                    [
                        "type" => "text",
                        "name" => "sub-keterangan[]",
                        "prefix" => "Masukkan",
                        "label" => "Keterangan Sub Kriteria",
                        "required" => false,
                        "value" => $v->keterangan,
                    ],
                ];
            }
        }

        $data = [
            "url" => $id ? base_url(route_to("data-kriteria-edit", $id)) : base_url(route_to("data-kriteria-add")),
            "mode" => "modal",
            "fields" => [
                [
                    "type" => "text",
                    "name" => "nama",
                    "prefix" => "Masukkan",
                    "label" => "Nama Kriteria",
                    "required" => true,
                    "value" => $item->nama ?? ''
                ],
                [
                    "type" => "text",
                    "name" => "kode",
                    "prefix" => "Masukkan",
                    "label" => "Kode Kriteria",
                    "required" => true,
                    "value" => $item->kode ?? ''
                ],
                [
                    "type" => "multiple-field",
                    "name" => "sub",
                    "prefix" => "Masukkan",
                    "label" => "Sub Kriteria",
                    "saveUrl" => $id ? base_url(route_to("data-sub-kriteria-save", $id)) : null,
                    "deleteUrl" => $id ? base_url(route_to("data-sub-kriteria-delete", $id)) : null,
                    "nameKey" => 'sub-id[]',
                    "value" => $subVal,
                    "inputs" => [
                        [
                            "type" => "text",
                            "name" => "sub-label[]",
                            "prefix" => "Masukkan",
                            "label" => "Label Sub Kriteria",
                            "required" => $id ? false : true,
                        ],
                        [
                            "type" => "text",
                            "name" => "sub-keterangan[]",
                            "prefix" => "Masukkan",
                            "label" => "Keterangan Sub Kriteria",
                            "required" => $id ? false : true,
                        ],
                    ]
                ],
            ],
        ];

        return $this->respond($data, 200);
    }
}