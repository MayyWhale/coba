<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AlternatifModel as model;
use App\Entities\Alternatif as entity;

class Alternatif extends BaseController
{
    public function __construct()
    {
        $this->model = new model();
    }

    public function add()
    {
        $data = $this->request->getPost();
        $Rules = [
            'nama' => 'required',
            'kode' => 'required|is_unique[spk_alternatif.kode]',
        ];
        if (!$this->validate($Rules)) {
            $error = $this->validator->getErrors();
            $error = implode("<br>", $error);
            return redirect()->back()->withInput()->with('error', $error);
        }
        $item = new entity($data);
        if ($this->model->save($item)) {
            return redirect()->route('data-alternatif')->with('message', 'Data berhasil ditambahkan');
        }
    }

    public function edit($id)
    {
        $data = $this->request->getPost();
        $Rules = [
            'nama' => 'required',
            'kode' => 'required|is_unique[spk_alternatif.kode,id,' . $id . ']',
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
                return redirect()->route('data-alternatif')->with('message', 'Data berhasil diubah');
            }
        } else {
            return redirect()->route('data-alternatif')->with('message', 'Data tidak ada perubahan');
        }
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->route('data-alternatif')->with('message', 'Data berhasil dihapus');
        }
    }
}
