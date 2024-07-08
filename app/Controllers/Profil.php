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

        echo view('profil/list_profil', $arr);
    }

    /**
     * Ajout profil 
     */
    public function createProfil()
    {
        $profil = $this->request->getVar('profil_name');
        $arr_pages = $this->request->getVar('page');

        echo "profil = $profil";
        echo '<pre>';
        print_r($arr_pages);
        echo '</pre>';
    }
}
