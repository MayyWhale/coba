<?php

namespace App\Entities;

use App\Models\JurusanModel;
use CodeIgniter\Entity\Entity;

class Alternatif extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'nilai'   => 'csv',
    ];

    public function getJurusan()
    {
        if (!$this->attributes['id_jurusan']) {
            return null;
        }
        $model = new JurusanModel();
        return $model->find($this->attributes['id_jurusan']);
    }
}