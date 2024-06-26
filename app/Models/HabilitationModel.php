<?php

namespace App\Models;

use CodeIgniter\Model;

class HabilitationModel extends Model
{
    protected $db;
    protected $tbl_page = TBL_PAGE;

    public function getAllPage()
    {
        $this->db = db_connect();
    }
}
