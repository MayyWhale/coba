<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel as model;
use App\Entities\User as entity;
use CodeIgniter\API\ResponseTrait;
use Myth\Auth\Password;

class User extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->model = new model();
    }

    public function add()
    {
        $data = $this->request->getPost();

        $Rules = [
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|is_unique[users.username]',
            'password_hash' => 'required',
                    
        ];
        if (!$this->validate($Rules)) {
            $error = $this->validator->getErrors();
            $error = implode("<br>", $error);
            return redirect()->back()->withInput()->with('error', $error);
        }

        $data['active'] = 1;
        $data['password_hash'] = Password::hash($data['password_hash']);

        if ($this->model->save($data)) {
            $id = $this->model->insertID();
            $this->model->addToGroupIn($id, $data['group_id']);
            return redirect()->route('data-user')->with('message', 'Pengguna Baru telah berhasil ditambahkan');;
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data');
        }
    }

    public function edit($id)
    {
        $data = $this->request->getPost();
        $Rules = [
            'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'username' => 'required|is_unique[users.username,id,' . $id . ']',
            'password_hash' => 'required',
        ];
        if (!$this->validate($Rules)) {
            $error = $this->validator->getErrors();
            $error = implode("<br>", $error);
            return redirect()->back()->withInput()->with('error', $error);
        }

        $data['active'] = 1;
        $data['password_hash'] = Password::hash($data['password_hash']);
            

        if ($this->model->update($id, $data)) {
            //group_id
            $data['group_id'] = $this->request->getPost('group_id');
            $data['group_id'] = (int)$data['group_id'];
            $data['user_id'] = $id;
            $data['user_id'] = (int)$data['user_id'];


            $this->model->editGroupById($data['group_id'], $data['user_id']);
            return redirect()->route('data-user')->with('message', 'Data Pengguna berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate data');
        }
    }

    public function delete($id)
    {
        // dd($id);
        if (isset($id)) {
            $this->model->deleteUserAndGroup($id);
            return redirect()->route('data-user')->with('message', 'Pengguna telah berhasil dihapus');;
        }
    }


    public function form()
    {
        $id = $this->request->getVar('id');
        $item = $this->model->find($id);
        $data = [
            "url" => $id ? base_url(route_to("data-user-edit", $id)) : base_url(route_to("data-user-add")),
            "mode" => "modal",
            "fields" => [
                [
                    "type" => "email",
                    "name" => "email",
                    "prefix" => "Masukkan",
                    "label" => "Email",
                    "value" => $item->email ?? ''
                ],
                [
                    "type" => "text",
                    "name" => "username",
                    "prefix" => "Masukkan",
                    "label" => "Username",
                    "value" => $item->username ?? ''
                ],
                [
                    "type" => "password",
                    "name" => "password_hash",
                    "prefix" => "Masukkan",
                    "label" => "Password",
                    "value" => $item->password ?? ''
                ],
                [
                    "type" => "select",
                    "name" => "group_id",
                    "prefix" => "Pilih",
                    "label" => "Group",
                    "value" => $item->group_id ?? '',
                    "options" => [
                        [
                            "value" => 1,
                            "text" => "Admin"
                        ],
                        [
                            "value" => 2,
                            "text" => "User"
                        ]
                    ]
                ],
            ],
        ];

        return $this->respond($data, 200);
    }
}
