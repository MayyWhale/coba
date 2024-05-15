<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Entities\Akumulasi;
use App\Models\AkumulasiModel;
use App\Models\AlternatifModel;
use App\Models\JurusanModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class Hitung extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->name = "pairwise";
        $this->modelKriteria = new KriteriaModel();
        $this->modelSubKriteria = new SubKriteriaModel();
        $this->modelAkumulasi = new AkumulasiModel();
        $this->modelJurusan = new JurusanModel();
        $this->modelAlternatif = new AlternatifModel();
        $this->modelUser = new UserModel();
    }

    public function content()
    {
        $user = user();
        $interval = 4;
        if ($user->step_kriteria < 10) {
            switch ($user->step_kriteria) {
                case 0:
                    $items = $this->modelKriteria->where([
                        "deleted_at" => null
                    ])->findAll();
                    $data['title'] = "Akumulasi Kriteria Utama";
                    $data['url'] = base_url(route_to("hitung-kriteria"));
                    break;
                case 1:
                    $akumulasi = $this->modelAkumulasi->where([
                        "type" => "main",
                        "id_user" => user()->id,
                    ])->first();
                    if (!$akumulasi) {
                        $this->fail([
                            'title' => "Kriteria Utama",
                            'text' => "Akumulasi Kriteria Utama Tidak ditemukan, Harap Hubungi admin",
                        ], 400);
                    }
                    $end = false;
                    for ($cek = 0; $cek < count($akumulasi->id_pair); $cek++) {
                        if (!$end) {
                            $cekMain = $this->modelAkumulasi->where([
                                "type" => "sub",
                                "id_user" => user()->id,
                                "id_main" => $akumulasi->id_pair[$cek],
                            ])->findAll();
                            if (!$cekMain) {
                                $items = $this->modelSubKriteria->where([
                                    "id_kriteria" => $akumulasi->id_pair[$cek],
                                    "deleted_at" => null
                                ])->findAll();
                                $data['url'] = base_url(route_to("hitung-subkriteria", $akumulasi->id_pair[$cek]));
                                $data['title'] = $items ? "Akumulasi Sub Kriteria {$items[0]->kriteria->nama}" : 'Akumulasi Sub Kriteria';
                                $end = true;
                            }
                        }
                    }
                    break;
                default:
                    $items = null;
                    break;
            }

            if (!$items) {
                return $this->fail([
                    'title' => "Akumulasi Kriteria",
                    'text' => "Kriteria / Sub Kriteria tidak ditemukan, Harap Hubungi admin"
                ], 400);
            }

            $fields = [];

            $pairwise = (pow(count($items), 2) - count($items)) / 2;
            $setter = count($items) - 1;
            $setterGo = $setter;
            $position = 0;
            $increment = 1;
            for ($i = 0; $i < $pairwise; $i++) {
                if (!($i < $setterGo)) {
                    $setter = $setter - 1;
                    $setterGo = $setterGo + $setter;
                    $position += 1;
                    $increment = 1;
                }
                $fields[] = $user->step_kriteria == 0 ?
                    [$items[$position]->nama, $items[$position + $increment]->nama] :
                    [$items[$position]->keterangan, $items[$position + $increment]->keterangan];
                $increment++;
            }
            foreach ($fields as $field) {
                $data['inputs'][] = [
                    "name" => "{$this->name}[]",
                    "ltitle" => $field[0],
                    "rtitle" => $field[1],
                    "interval" => $interval,
                ];
            }
        } else {
            $data = [
                'done' => true
            ];
        }

        return $this->respond($data, 200);
    }

    public function kriteria()
    {
        $data = $this->request->getVar();

        $items = $this->modelKriteria->where([
            "deleted_at" => null
        ])->findAll();

        if (!$items) {
            $this->fail([
                'title' => "Akumulasi Kriteria Utama",
                'text' => "Kriteria tidak ditemukan, Harap Hubungi admin",
            ], 400);
        }

        $id_pair = [];
        foreach ($items as $v) {
            $id_pair[] = $v->id;
        }

        $item = new Akumulasi([
            "id_user" => user()->id,
            "type" => 'main',
            "id_pair" => $id_pair,
            "nilai" => $data[$this->name],
        ]);

        if ($this->modelAkumulasi->save($item)) {
            $user = user();
            $user->step_kriteria = 1;

            $this->modelUser->save($user);

            return redirect()->back()->with('message', 'Data akumulasi kriteria berhasil disimpan');
        }
        return redirect()->back()->with('error', 'Data akumulasi kriteria gagal disimpan');
    }

    public function kriteriaSub($id)
    {
        $data = $this->request->getVar();
        $akumulasi = $this->modelAkumulasi->where([
            "type" => "main",
            "id_user" => user()->id,
        ])->first();

        $items = $this->modelSubKriteria->where([
            "id_kriteria" => $id,
            "deleted_at" => null
        ])->findAll();

        if (!$items) {
            $this->fail([
                'title' => "Akumulasi Sub Kriteria Utama",
                'text' => "Sub Kriteria tidak ditemukan, Harap Hubungi admin"
            ], 400);
        }

        $id_pair = [];
        foreach ($items as $v) {
            $id_pair[] = $v->id;
        }

        $item = new Akumulasi([
            "id_user" => user()->id,
            "type" => 'sub',
            "id_pair" => $id_pair,
            "id_main" => $id,
            "nilai" => $data[$this->name],
        ]);

        if ($this->modelAkumulasi->save($item)) {
            $end = false;
            for ($cek = 0; $cek < count($akumulasi->id_pair); $cek++) {
                if (!$end) {
                    $cekMain = $this->modelAkumulasi->where([
                        "type" => "sub",
                        "id_user" => user()->id,
                        "id_main" => $akumulasi->id_pair[$cek],
                    ])->findAll();
                    if ($cekMain && ($cek == count($akumulasi->id_pair) - 1)) {
                        $user = user();
                        $user->step_kriteria = 10;

                        $this->modelUser->save($user);
                    }
                }
            }

            return redirect()->back()->with('message', 'Data akumulasi kriteria berhasil disimpan');
        }
        return redirect()->back()->with('error', 'Data akumulasi kriteria gagal disimpan');
    }

    public function alternatif($id)
    {
        $data = $this->request->getVar();
        $item = $this->modelAlternatif->find($id);
        $item->nilai = $data['nilai'];

        if ($this->modelAlternatif->save($item)) {
            $sub = $this->modelAlternatif->where([
                'id_user' => user_id(),
            ])->findAll();
            $end = true;
            foreach ($sub as $cek) {
                if (!isset($cek->nilai)) {
                    $end = false;
                }
            }
            if ($end) {
                $user = user();
                $user->step_jurusan = 10;

                $this->modelUser->save($user);
                return redirect()->back()->with('message', "Seluruh Nilai Alternatif Sudah diinput");
            }
            return redirect()->back()->with('message', "Nilai Alternatif {$item->jurusan->nama} Berhasil diinput");
        }
        return redirect()->back()->with('error', "Nilai Alternatif {$item->jurusan->nama} Gagal diinput");
    }

    public function formAlternatif()
    {
        $id = $this->request->getVar('id');
        $item = $this->modelJurusan->find($id);

        $sub = $this->modelAkumulasi->where([
            'id_user' => user_id(),
            'type' => 'sub',
        ])->findAll();

        $fields = [];
        foreach ($sub as $subkey => $subval) {
            $options = [];
            if ($subval->list_sub) {
                foreach ($subval->list_sub as $k => $v) {
                    $options[] = [
                        "value" => $v->id,
                        "text" => $v->keterangan
                    ];
                }
            }
            $fields[] = [
                "type" => "select",
                "name" => "nilai[]",
                "prefix" => "Pilih",
                "label" => ucwords($subval->kriteria->nama),
                "options" => $options
            ];
        }

        $data = [
            "url" => base_url(route_to("hitung-alternatif-save", (int)$id)),
            "mode" => "modal",
            "fields" => $fields
        ];

        return $this->respond($data, 200);
    }

    public function reset()
    {
        // set step jurusan and step kriteria to 0 if 10

        $data = [
            'step_jurusan' => 0,
            'step_kriteria' => 0,
        ];
        $find = $this->modelUser->find(user_id());
        $find->fill($data);
        if ($find->hasChanged()) {
            $this->modelUser->save($find);
            $this->modelAkumulasi->where([
                "id_user" => user()->id
            ])->delete();
            $this->modelAlternatif->where([
                "id_user" => user()->id
            ])->delete();
            return redirect()->back()->with('message', 'Data berhasil direset');
        } else {
            return redirect()->back()->with('error', 'Data gagal direset');
        }

    }
}
