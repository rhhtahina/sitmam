<?php

namespace App\Models;

use CodeIgniter\Model;

class DatatableModel extends Model
{
    protected $db;
    protected $table;
    protected $column_order;
    protected $column_search;
    protected $order;
    protected $group;
    protected $join;
    protected $filter;
    protected $columnSelect;
    protected $db_app;
    protected $request;

    public function __construct($typedb, $tbl, $arrJoin, $arrFilter, $column, $columnOrder, $columnSearch, $order, $grp = "")
    {
        parent::__construct();
        $this->table = $tbl;
        $this->column_order = $columnOrder;
        $this->column_search = $columnSearch;
        $this->order = $order;
        $this->join = $arrJoin;
        $this->filter = $arrFilter;
        $this->columnSelect = $column;
        $this->group = $grp;

        if ($typedb == 1) {
            $this->db_app = db_connect();
        }

        $this->request = \Config\Services::request();
    }

    public function getQuery()
    {
        $builder = $this->db_app->table($this->table)
            ->distinct()
            ->select($this->columnSelect);
        if (!empty($this->join)) {
            foreach ($this->join as $key => $val) :
                $builder->join($val['table'], $val['on'], $val['type']);
            endforeach;
        }
        if (!empty($this->filter)) {
            $builder->where($this->filter);
        }
        if ($this->group != "") {
            $builder->groupBy($this->group);
        }
        return $builder;
    }

    private function _get_datatables_query()
    {
        $builder = $this->getQuery();
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $builder->groupStart();
                    $builder->like('lower(' . $item . ')', strtolower($_POST['search']['value']), false);
                } else {
                    $builder->orLike('lower(' . $item . ')', strtolower($_POST['search']['value']), true);
                }

                if ((count($this->column_search) - 1) == $i) {
                    $builder->groupEnd();
                }
            }
            $i++;
        }

        if (!empty($_POST['order'])) {
            if ($_POST['order'][0]['dir'] != 'false') {
                //$col_order = ($_POST['order'][0]['column'] == 0) ? 1 : $_POST['order'][0]['column'];
                $col_order = $_POST['order'][0]['column'];
                $builder->orderBy($this->column_order[$col_order], $_POST['order'][0]['dir']);
            }
        } elseif (isset($this->order)) {
            $order = $this->order;
            $builder->orderBy(key($order), $order[key($order)]);
        }
        return $builder;
    }

    public function get_datatables()
    {
        $builder = $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $builder->limit($_POST['length'], $_POST['start']);
        }
        $query = $builder->get();
        return $query->getResult();
    }

    public function count_filtered()
    {
        $builder = $this->_get_datatables_query();
        return $builder->countAllResults();
    }

    public function count_all()
    {
        $builder = $this->getQuery();
        return $builder->countAllResults();
    }
}
