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

        $arr['data_page_profil'] = $this->habilitationModel->getAllPageByProfilId($id);
        $arr['data_profil_id'] = $arr_profil;

        $arr["disabled"] = ($action == "voir") ? "disabled=disabled" : "";
        $arr["display"] = ($action == "voir") ? 'style="display:none;"' : "";
        $arr["action"] = $action;

        echo view('profil/edit_profil', $arr);
    }

    /**
     * Update Profil
     */
    public function updateProfil()
    {
        $id = $this->request->getVar('id');
        $profil = $this->request->getVar('profil');
        $arr_pages = $this->request->getVar('page');

        $profilOld = $this->getProfilById($id);
        /* Page id par profil enregistré dans la BDD */
        $arr_old_page = $this->fetchPageByProfil($id);
        $arr_diff_page = array_merge(array_diff($arr_old_page, $arr_pages), array_diff($arr_pages, $arr_old_page));

        /* ras => aucun changement => comparer le profil saisi et le profil enregistré dans BDD */
        $compareProfil =  (($profilOld == $profil) && empty($arr_diff_page)) ? "ras" :  "go";

        echo $compareProfil;
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
        $arr_page = array();
        $arr_profil_page = $this->habilitationModel->getPageByProfil($id);
        foreach ($arr_profil_page as $key => $val) :
            array_push($arr_page, $val['page_id']);
        endforeach;
        return $arr_page;
    }

    /**
     * Prendre un profil par id
     */
    public function getProfilById($id)
    {
        $arrData = $this->habilitationModel->where('id', $id)->first();
        $profil = !empty($arrData) ? $arrData["libelle"] : null;
        return $profil;
    }
}
