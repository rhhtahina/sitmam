<?php

namespace App\Models;

use CodeIgniter\Model;

class HabilitationModel extends Model
{
    protected $db;
    protected $table = TBL_PROFIL;
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'libelle', 'actif', 'date_creation', 'cree_par', 'date_modification', 'modifie_par', 'date_suppression', 'supprime_par'];
    protected $returnType = 'array';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $tbl_page = TBL_PAGE;
    protected $tbl_section = TBL_SECTION;
    protected $tbl_access_profiles_pages = TBL_ACCES;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    /**
     * Liste de toutes les pages actives
     */
    public function getAllPage()
    {
        return $this->db->table($this->tbl_page)
            ->join($this->tbl_section, $this->tbl_page . '.section_id = ' . $this->tbl_section . '.id', 'left')
            ->where($this->tbl_page . '.actif', 1)
            ->where($this->tbl_page . '.id != 1', null)
            ->orderBy($this->tbl_page . '.libelle', 'ASC')
            ->select($this->tbl_page . '.*,' . $this->tbl_section . '.libelle as section')
            ->get()
            ->getResult();
    }

    /**
     * Nombre du profil
     * @param $profilName
     * @return integer
     */
    public function getProfilName($profilName)
    {
        $nb = 0;
        if ($profilName != "") {
            return  $this->db->table($this->table)->where('lower(libelle)', strtolower($profilName))->where('actif', 1)->countAllResults();
        }
        return $nb;
    }

    public function comparePageOfProfil($arr_pages, int $profil_id = null)
    {
        // Ajouter la valeur 1 au tableau
        $arr_pages[] = 1;

        $arr = 'array[' . implode(',', $arr_pages) . ']';
        $where = "";
        if (!is_null($profil_id)) {
            $where = " and profil_id != " . $profil_id;
        }
        $sql = "
                    select
                        profil_id,
                        profil_libelle
                    from
                    (
                        select
                            profil_id,
                            profil.libelle as profil_libelle,
                            (select array_agg(distinct arr_filtre order by arr_filtre) from unnest(" . $arr . ") arr_filtre) = ARRAY_AGG(page_id ORDER BY page_id) as page
                        from
                            acces
                        inner join profil on profil.id = acces.profil_id
                        where
                            actif = 1
                            $where
                        group by profil_id, profil.libelle
                        order by profil_id
                    ) as tab
                    where page = true
                    limit 1
                ";
        $result = $this->db->query($sql);
        $res = $result->getRow();
        if (isset($res->profil_id)) {
            return $res->profil_libelle;
        }
        return null;
    }

    /**
     * Add Profil
     */
    public function addProfil($profil, $arr_pages, $id_page_favoris)
    {
        $data = [
            'libelle' => $profil,
            'cree_par' => 1,
            'date_creation' => date("Y-m-d H:i:s")
        ];

        $this->db->transBegin();

        $this->db->table($this->table)
            ->insert($data);
        $profil_id = $this->db->insertID();
        $nb = $this->db->affectedRows();

        if ($nb > 0 && $profil_id > 0) {
            /* Insertion dans access_libelle_pages après que l'insertion du nouveau profil soit ok */
            $data_access_page[] = [
                'profil_id' => $profil_id,
                'page_id' => 1,
                'page_accueil' => 1
            ];

            $k = 1;
            foreach ($arr_pages as $key => $val) :
                $favorite = ($id_page_favoris == $val) ? 1 : 0;
                $data_access_page[$k] = [
                    'profil_id' => $profil_id,
                    'page_id' => $val,
                    'page_accueil' => $favorite
                ];
                $k++;
            endforeach;
            $this->db->table($this->tbl_access_profiles_pages)->insertBatch($data_access_page);
        }

        if ($this->db->transStatus() === false || $nb == 0) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }
}
