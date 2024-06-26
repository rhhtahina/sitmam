<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    public function index()
    {
        $this->load();
    }

    public function load()
    {
        echo view('utilisateur/list_utilisateur');
    }
}
