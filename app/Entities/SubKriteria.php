<?php

namespace App\Entities;

use App\Models\KriteriaModel;
use CodeIgniter\Entity\Entity;

class SubKriteria extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getKriteria()
    {
        if (!$this->attributes['id_kriteria']) {
            return null;
        }
        $model = new KriteriaModel();
        return $model->find($this->attributes['id_kriteria']);
    }
}