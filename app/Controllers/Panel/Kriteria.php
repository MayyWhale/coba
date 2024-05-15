<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\KriteriaModel as model;
use App\Models\SubKriteriaModel as subModel;

class Kriteria extends BaseController
{
    public function __construct()
    {
        $this->config = config('Theme');
        $this->data['config'] = $this->config;
        $this->model = new model();
        $this->subModel = new subModel();
    }
    public function index()
    {
        $this->data['items'] = $this->model->findAll();
        $this->data['page'] = "master-kriteria";
        return view('Panel/Page/Master/Kriteria/kriteria', $this->data);
    }
    public function add()
    {
        return view('Panel/Page/Master/Kriteria/kriteria-add', $this->data);
    }
    public function edit($id)
    {
        $this->data['item'] = $this->model->find($id);
        $this->data['subKriteria'] = $this->subModel->where('id_kriteria', $id)->findAll();
        return view('Panel/Page/Master/Kriteria/kriteria-edit', $this->data);
    }
}
