<?php

namespace App\Entities;

use App\Models\SubKriteriaModel;
use CodeIgniter\Entity\Entity;

class Kriteria extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getSub()
    {
        $model = new SubKriteriaModel();
        $items = $model->where([
            "id_kriteria" => $this->attributes['id'],
            "deleted_at" => null
        ])->findAll();
        return $items;
    }
}