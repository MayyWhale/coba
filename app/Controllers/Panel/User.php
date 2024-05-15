<?php 
namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Models\UserModel as model;

class User extends BaseController
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
        $this->data['page'] = "user";
        return view('Panel/Page/Master/User/user', $this->data); 
    }



}
?>