<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TestModel;
use CodeIgniter\HTTP\ResponseInterface;

class TestData extends BaseController
{
    protected $testModel;

    public function __construct()
    {
        $this->testModel = new TestModel();
    }

    public function index()
    {
        $data['libelle'] = 'test';
        $this->testModel->insertData($data);
    }
}
