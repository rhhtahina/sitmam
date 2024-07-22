<?php

namespace App\Libraries;

use App\Libraries\LibPortier;

class LibDatatable
{
    protected $table;
    protected $join;
    protected $filter;
    protected $column;
    protected $columnOrder;
    protected $search;
    protected $order;
    protected $typeBd;
    protected $group;
    protected $page_id;
    public function __construct($typeBd, $tbl, $arrJoin, $arrFilter, $column, $columnOrder, $columnSearch, $order, $group, $page_id)
    {
        $this->table = $tbl;
        $this->join = $arrJoin;
        $this->filter = $arrFilter;
        $this->column = $column;
        $this->columnOrder = $columnOrder;
        $this->search = $columnSearch;
        $this->order = $order;
        $this->typeBd = $typeBd;
        $this->group = $group;
        $this->page_id = $page_id;
    }

    public function ajaxDataTables()
    {
        $request = \Config\Services::request();
        $libPortier = new LibPortier();
        $model = new \App\Models\DatatableModel($this->typeBd, $this->table, $this->join, $this->filter, $this->column, $this->columnOrder, $this->search, $this->order, $this->group, $this->page_id);
        $list = $model->get_datatables();

        $acces_btn = $libPortier->check_acces_bouton($this->page_id);
        $style = ($acces_btn == "write" || $acces_btn == "") ? "" : 'style = "display:none;"';

        $keys = [];
        foreach ($list as $key => $val) {
            $keys = array_merge($keys, array_keys((array) $val));
        }
        $keys = array_unique($keys);

        $data = array();
        $no = $request->getVar('start');
        foreach ($list as $item) {
            $no++;
            $row = array();
            foreach ($keys as $k) {
                $row[] = $item->$k;
            }
            $row[] = $acces_btn;
            $data[] = $row;
        }


        $output = array(
            "draw" => $request->getVar('draw'),
            "recordsTotal" => $model->count_all(),
            "recordsFiltered" => $model->count_filtered(),
            "data" => $data
        );
        return $output;
    }

    public function format_data($results)
    {
        if (!$results) {
            return false;
        }
        $formattedResults = [];
        foreach ($results as $row) {
            $matricule = $row->matricule;
            if (!isset($formattedResults[$matricule])) {
                $formattedResults[$matricule] = [];
            }
            $formattedRow = (array) $row;
            $formattedResults[$matricule][] = $formattedRow;
        }

        // Reindex the array numerically
        $formattedResults = array_values($formattedResults);

        $modifiedData = [];
        $firstGroup = reset($formattedResults); // Get the first group
        $firstRow = reset($firstGroup); // Get the first row of the first group

        $columnNames = array_keys($firstRow);

        $actionRow = [];
        $emptyRow = [];
        foreach ($columnNames as $column) {
            $actionRow[$column] = null;
            $emptyRow[$column] = null;
        }

        foreach ($formattedResults as $key => $group) {
            // Add the rows of the current group
            if (in_array($group[0]['type'], ['Directeur national', 'Directeur expatrié']) && $group[0]['statut_id'] == 1) {
                $typ = ($group[0]['type'] == 'Directeur national') ? 1 : 2;
                $mail_id = "mail" . $typ;
                if ($group[0]['flag_demande_en_cours'] == 1) {
                    $actionRow['mode_reglement'] = '<button class="btn border-slate text-slate btn-flat"><i class="icon-checkmark"></i> Demande en cours</button>';
                    $actionRow['statut'] = '
                    Affiliation : 
                    <button class="btn border-success text-success btn-flat" onclick="viewDirecteurAffilliation(' . $group[0]['id'] . ', ' . $group[0]['statut_id'] . ')">Oui</button>
                    <button class="btn border-danger text-danger btn-flat" onclick="viewDirecteurRadiation(' . $group[0]['id'] . ', ' . $group[0]['statut_id'] . ')">Non</button>';
                } else {
                    $actionRow['mode_reglement'] = '<button class="btn border-success text-success btn-flat" type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $mail_id . 'Modal" onclick="openMailModal(' . $group[0]['matricule'] . ',' . $typ . ')"><i class="icon-mail5"></i> Demande d\'avis</button>';
                    $actionRow['statut'] = '
                    <span class="text-grey">Affiliation : </span>
                    <button class="btn border-grey text-grey btn-flat" disabled>Oui</button>
                    <button class="btn border-grey text-grey btn-flat" disabled>Non</button>';
                }
                $modifiedData[] = $actionRow;
            }

            $modifiedData = array_merge($modifiedData, $group);

            // Add an empty row to separate groups
            $modifiedData[] = $emptyRow;
        }
        array_pop($modifiedData);
        return $modifiedData;
    }

    public function ajaxDataTablesGestionAssurance()
    {
        $request = \Config\Services::request();
        $libPortier = new LibPortier();
        $model = new \App\Models\DatatableModel($this->typeBd, $this->table, $this->join, $this->filter, $this->column, $this->columnOrder, $this->search, $this->order, $this->group, $this->page_id);
        $list = $model->get_datatables();
        $list = $this->format_data($list);

        if (!$list) {
            $list = [];
        }

        $acces_btn = $libPortier->check_acces_bouton($this->page_id);
        $style = ($acces_btn == "write" || $acces_btn == "") ? "" : 'style = "display:none;"';

        $keys = [];
        foreach ($list as $key => $val) {
            $keys = array_merge($keys, array_keys((array) $val));
        }
        $keys = array_unique($keys);

        $data = array();
        $no = $request->getVar('start');
        foreach ($list as $item) {
            $no++;
            $row = array();
            foreach ($keys as $k) {
                $row[] = $item[$k];
            }
            $row[] = $acces_btn;
            $data[] = $row;
        }

        $output = array(
            "draw" => $request->getVar('draw'),
            "recordsTotal" => $model->count_all(),
            "recordsFiltered" => $model->count_filtered(),
            "data" => $data
        );
        return $output;
    }
}
