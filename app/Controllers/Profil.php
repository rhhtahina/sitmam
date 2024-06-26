<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HabilitationModel;
use CodeIgniter\HTTP\ResponseInterface;

class Profil extends BaseController
{
    protected $habilitationModel;

    public function __construct()
    {
        $this->habilitationModel = new HabilitationModel();
    }

    public function index()
    {
        $this->load();
    }

    public function load()
    {
        $arr['data_page'] = $this->habilitationModel->getAllpage();
        echo view('profil/list_profil');
    }

    public function addProfil()
    {
        echo 'controller add profil';
    }
}
