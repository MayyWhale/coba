<?php

namespace App\Entities;

use App\Models\AkumulasiModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;
use CodeIgniter\Entity\Entity;

class Akumulasi extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id_pair'   => 'csv',
        'nilai'   => 'csv',
    ];

    public function getListMain()
    {
        if (!$this->attributes['type'] == 'main') {
            return null;
        }
        $id_pair = explode(',', $this->attributes['id_pair']);
        $model = new KriteriaModel();
        $result = [];
        foreach ($id_pair as $i) {
            $result[] = $model->find($i);
        }
        return $result;
    }

    public function getListSub()
    {
        if (!$this->attributes['type'] == 'sub') {
            return null;
        }
        $id_pair = explode(',', $this->attributes['id_pair']);
        $model = new SubKriteriaModel();
        $result = [];
        foreach ($id_pair as $i) {
            $result[] = $model->find($i);
        }
        return $result;
    }

    public function getKriteria()
    {
        if (!$this->attributes['type'] == 'sub') {
            return null;
        }
        if (!$this->attributes['id_main']) {
            return null;
        }
        $model = new KriteriaModel();
        return $model->find($this->attributes['id_main']);
    }
}