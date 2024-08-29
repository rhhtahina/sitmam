<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table            = TBL_UTILISATEUR;
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'login', 'mdp', 'nom', 'prenom', 'profil_id', 'date_creation', 'cree_par', 'date_modification', 'modifie_par', 'date_suppression', 'supprime_par', 'flag_suppression'];

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function addUser($arr)
    {
        $result = $this->db->table($this->table)
            ->insert($arr);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function verifDoublon($name, $colonne)
    {
        $nb = 0;
        if ($name != "") {
            return  $this->db->table($this->table)->where('lower(' . $colonne . ')', strtolower($name))->where('flag_suppression', 0)->countAllResults();
        }
        return $nb;
    }
}
