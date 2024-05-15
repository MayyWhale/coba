<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;
use App\Models\JurusanModel as model;
use CodeIgniter\API\ResponseTrait;

class Jurusan extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->config = config('Theme');
        $this->data['config'] = $this->config;
        $this->model = new model();
    }
    public function index()
    {
        $this->data['page'] = 'master-jurusan';
        $this->data['items'] = $this->model->findAll();
        return view('Panel/Page/Master/Jurusan/jurusan', $this->data);
    }
    public function add()
    {
        return $this->respondCreated();
    }
    public function edit($id)
    {
        return $this->respondCreated();
    }
}