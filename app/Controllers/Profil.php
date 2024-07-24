<?php

namespace App\Controllers;

use App\Libraries\LibDatatable;
use App\Models\HabilitationModel;
use App\Controllers\BaseController;
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
        $arr['data'] = $this->habilitationModel->where('actif', 1)->where('flag_suppression', 0)->orderBy('libelle', 'ASC')->findAll();
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
        $favoris = "";

        /* Vérification de doublon du nom de profil*/
        $verifProfil = $this->habilitationModel->getProfilName($profil);
        /* Vérifier si les pages sélectionnées sont déjà associées à un autre profil */
        $verifPage = $this->habilitationModel->comparePageOfProfil($arr_pages);

        if ($verifProfil > 0) {
            $msg = 'doublon profil';
        } elseif (!is_null($verifPage)) {
            $msg = 'doublon page||' . $verifPage;
        } else {
            $responsedb = $this->habilitationModel->addProfil($profil, $arr_pages, $favoris);
            $msg = ($responsedb) ? '1' : '0';
        }

        return $msg;
    }

    /**
     * Visualisation profil
     */
    public function viewProfil()
    {
        $id = $this->request->getVar('id');
        $action = $this->request->getVar('action');

        $arrData = $this->habilitationModel->where('id', $id)->first();

        $arr["data"] = $arrData;
        $arr["data_page"] = $this->habilitationModel->getAllPage();

        /* id de page par profil */
        $arr_profil = $this->fetchPageByProfil($id);
    }

    public function getAllProfil()
    {
        $columnOrder = array(null, "libelle");
        $column = array("id", "libelle");
        $columnSearch = array("libelle");
        $libDt = new LibDatatable(1, TBL_PROFIL, [], array("actif" => 1, "flag_suppression" => 0), $column, $columnOrder, $columnSearch, array('libelle' => 'asc'), "", 3);
        $arr = $libDt->ajaxDataTables();
        return json_encode($arr);
    }

    public function fetchPageByProfil($id)
    {
    }
}
