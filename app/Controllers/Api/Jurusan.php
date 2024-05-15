<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Entities\Jurusan as entity;
use App\Entities\Alternatif as AlternatifEntity;
use App\Models\AlternatifModel;
use App\Models\JurusanModel as model;
use CodeIgniter\API\ResponseTrait;

class Jurusan extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->model = new model();
        $this->modelAlternatif = new AlternatifModel();
    }

    public function add()
    {
        $data = $this->request->getPost();
        $Rules = [
            'nama' => 'required',
            'kode' => 'required|is_unique[spk_jurusan.kode]',
        ];
        if (!$this->validate($Rules)) {
            $error = $this->validator->getErrors();
            $error = implode("<br>", $error);
            return redirect()->back()->withInput()->with('error', $error);
        }
        $item = new entity($data);
        if ($this->model->save($item)) {
            return redirect()->route('data-jurusan')->with('message', 'Data berhasil ditambahkan');
        }
    }

    public function edit($id)
    {
        $data = $this->request->getPost();
        $Rules = [
            'nama' => 'required',
            'kode' => 'required|is_unique[spk_jurusan.kode,id,' . $id . ']',
        ];
        if (!$this->validate($Rules)) {
            $error = $this->validator->getErrors();
            $error = implode("<br>", $error);
            return redirect()->back()->withInput()->with('error', $error);
        }

        $item = $this->model->find($id);
        $item->fill($data);
        if ($item->hasChanged()) {
            if ($this->model->save($item)) {
                return redirect()->route('data-jurusan')->with('message', 'Data berhasil diubah');
            }
        } else {
            return redirect()->route('data-jurusan')->with('message', 'Data tidak ada perubahan');
        }
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->route('data-jurusan')->with('message', 'Data berhasil dihapus');
        }
    }

    public function form()
    {
        $id = $this->request->getVar('id');
        $item = $this->model->find($id);
        $data = [
            "url" => $id ? base_url(route_to("data-jurusan-edit", $id)) : base_url(route_to("data-jurusan-add")),
            "mode" => "modal",
            "fields" => [
                [
                    "type" => "text",
                    "name" => "nama",
                    "prefix" => "Masukkan",
                    "label" => "Nama jurusan",
                    "value" => $item->nama ?? ''
                ],
                [
                    "type" => "text",
                    "name" => "kode",
                    "prefix" => "Masukkan",
                    "label" => "Kode jurusan",
                    "value" => $item->kode ?? ''
                ],
            ],
        ];
        return $this->respond($data, 200);
    }

    public function set()
    {
        $data = $this->request->getPost();
        $list = $data['jurusan'];
        $items = [];

        foreach ($list as $i) {
            $isJurusanExists = $this->modelAlternatif->where('id_jurusan', $i)->get();
            if ($isJurusanExists->getNumRows() > 0) {
                true;
            } else {
                $items[] = [
                    "id_user" => user_id(),
                    "id_jurusan" => $i,
                ];
            }
        }

        // Insert data yang belum ada dalam database
        if (!empty($items)) {
            if ($this->modelAlternatif->insertBatch($items)) {
                return redirect()->back()->with('message', 'Data Jurusan berhasil ditambahkan');
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data Jurusan');
            }
        } else {
            return redirect()->back()->with('message', 'Semua data Jurusan sudah ada, tidak ada yang disimpan');
        }
    }
}
