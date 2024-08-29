<?php

namespace App\Controllers;

use App\Libraries\LibDatatable;
use App\Controllers\BaseController;
use App\Models\HabilitationModel;
use App\Models\UtilisateurModel;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    protected $habilitationModel;
    protected $utilisateurModel;

    public function __construct()
    {
        $this->habilitationModel = new HabilitationModel();
        $this->utilisateurModel = new UtilisateurModel();
    }

    public function index()
    {
        $this->load();
    }

    public function load()
    {
        $arr['data'] = $this->utilisateurModel->where('flag_suppression', 0)->orderBy('nom', 'ASC')->get()->getResult();
        $arr['profil'] = $this->habilitationModel->where('actif', 1)->where('flag_suppression', 0)->orderBy('libelle', 'ASC')->findAll();

        echo view('utilisateur/list_utilisateur', $arr);
    }

    public function createUser()
    {
        // Récupérer le login et le convertir en minuscules
        $login = strtolower($this->request->getVar('login'));

        $data = [
            'login' => $login,
            'mdp' => password_hash($this->request->getVar('mdp'), PASSWORD_BCRYPT),
            'nom' => $this->request->getVar('nom'),
            'prenom' => $this->request->getVar('prenom'),
            'profil_id' => $this->request->getVar('profil_id'),
            'date_creation' => date('Y-m-d H:i:s'),
            'cree_par' => 1,
        ];

        $verifNom = $this->utilisateurModel->verifDoublon($data['nom'], 'nom');
        $verifPrenom = $this->utilisateurModel->verifDoublon($data['prenom'], 'prenom');
        $verifLogin = $this->utilisateurModel->verifDoublon($data['login'], 'login');

        if ($verifNom == 1 && $verifPrenom == 1) {
            $msg = "doublon nom";
        } else if ($verifLogin == 1) {
            $msg = "doublon login";
        } else {
            $result = $this->utilisateurModel->addUser($data);
            $msg = $result ? 'ok' : 'ko';
        }

        return $msg;
    }

    public function getAllUser()
    {
        $arrFilter = [
            TBL_UTILISATEUR . ".flag_suppression" => 0
        ];
        $arrJoin = [
            array(
                'table' => TBL_PROFIL,
                'on' => TBL_PROFIL . '.id = ' . TBL_UTILISATEUR . '.profil_id',
                'type' => 'left'
            )
        ];
        $columnOrder = array(null, TBL_UTILISATEUR . ".nom", TBL_UTILISATEUR . ".prenom", TBL_UTILISATEUR . ".login", TBL_PROFIL . ".libelle");
        $column = array(TBL_UTILISATEUR . ".id", TBL_UTILISATEUR . ".nom", TBL_UTILISATEUR . ".prenom", TBL_UTILISATEUR . ".login", TBL_PROFIL . ".libelle");
        $columnSearch = array(TBL_UTILISATEUR . ".nom", TBL_UTILISATEUR . ".prenom", TBL_UTILISATEUR . ".login", TBL_PROFIL . ".libelle");
        $libDt = new LibDatatable(1, TBL_UTILISATEUR, $arrJoin, $arrFilter, $column, $columnOrder, $columnSearch, array('nom' => 'asc'), "", 3);
        $arr = $libDt->ajaxDataTables();

        return json_encode($arr);
    }
}
