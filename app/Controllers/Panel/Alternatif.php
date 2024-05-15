<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\AlternatifModel as model;

class Alternatif extends BaseController
{
    public function __construct()
    {
        $this->config = config('Theme');
        $this->data['config'] = $this->config;
        $this->model = new model();
    }
    public function index()
    {
        $this->data['items'] = $this->model->findAll();
        return view('Panel/Page/Master/Alternatif/alternatif', $this->data);
    }
    public function add()
    {
        return view('Panel/Page/Master/Alternatif/alternatif-add', $this->data);
    }
    public function edit($id)
    {       
        $this->data['item'] = $this->model->find($id);
        return view('Panel/Page/Master/Alternatif/alternatif-edit', $this->data);
    }
}
