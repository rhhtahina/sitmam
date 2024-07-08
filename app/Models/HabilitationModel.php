<?php

namespace App\Models;

use CodeIgniter\Model;

class HabilitationModel extends Model
{
    protected $db;
    protected $tbl_page = TBL_PAGE;
    protected $tbl_section = TBL_SECTION;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

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
     * Nombre profil
     * @param $profilName
     * @return integer
     */
    public function getProfilName($profilName)
    {
    }
}
