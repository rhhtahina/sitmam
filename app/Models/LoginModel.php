<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    /**
     * Toutes les pages associées au profil
     *
     */
    public function my_favorite_page()
    {
        $session = \Config\Services::session();
        $id_profil = isset($session->get('infos_perm')['profil_id']) ? $session->infos_perm['profil_id'] : null;
        if (!is_numeric($id_profil)) {
            return null;
        }
        $page = $this->db
            ->table('acces')
            ->join('page', 'page.id = acces.page_id', 'INNER')
            ->where('profil_id', $id_profil)
            ->where('page.actif', 1)
            ->orderBy('page_accueil', 'DESC')
            ->orderBy('libelle', 'ASC')
            ->limit(1)
            ->select('page.*')
            ->get()->getResult();
        return isset($page[0]) ? $page[0] : null;
    }

    public function myMenu_()
    {
        $session = \Config\Services::session();
        $id_profil = !empty($session->get('infos_perm')) ? $session->infos_perm['profil_id'] : null;
        if (!is_numeric($id_profil)) {
            return array();
        }
        $arrPage = array();
        $pages = $this->db
            ->table('acces')
            ->join('page', 'page.id = acces.page_id', 'INNER')
            ->join('section', 'page.section_id = section.id and section.actif = 1', 'left')
            ->where('profil_id', $id_profil)
            ->where('page.actif', 1)
            ->orderBy('section.ordre', 'ASC')
            //->select('page.*')
            ->distinct()
            ->select('section.id as section_id,section.libelle section_libelle,section.icone section_icone,section.ordre,section.avoir_sous_section')
            ->get()->getResult();
        foreach ($pages as $key => $val) :
            $arrPage['section'][$val->section_id]['id'] = $val->section_id;
            $arrPage['section'][$val->section_id]['libelle'] = $val->section_libelle;
            $arrPage['section'][$val->section_id]['icone'] = $val->section_icone;
            $arrPage['section'][$val->section_id]['has_more_section'] = $val->avoir_sous_section;
        endforeach;
        return $arrPage;
    }

    public function myMenu()
    {
        $session = \Config\Services::session();
        $id_profil = !empty($session->get('infos_perm')) ? $session->infos_perm['profil_id'] : null;
        if (!is_numeric($id_profil)) {
            return array();
        }
        $arrPage = array();
        $pages = $this->db
            ->table('acces')
            ->join('page', 'page.id = acces.page_id', 'INNER')
            ->join('section', 'page.section_id = section.id and section.actif = 1', 'inner')
            ->join('sous_section', 'page.sous_section_id = sous_section.id and sous_section.actif = 1', 'left')
            ->where('profil_id', $id_profil)
            ->where('page.actif', 1)
            ->orderBy('section.ordre', 'ASC')
            ->orderBy('page.ordre', 'ASC')
            ->select('page.*')
            ->select('sous_section.libelle sous_section_libelle')
            ->select('section.id as section_id,section.libelle section_libelle,section.icone section_icone,section.ordre,section.avoir_sous_section')
            ->get()->getResult();
        foreach ($pages as $key => $val) :
            $arrPage['section'][$val->section_id]['id'] = $val->section_id;
            $arrPage['section'][$val->section_id]['libelle'] = $val->section_libelle;
            $arrPage['section'][$val->section_id]['icone'] = $val->section_icone;
            $arrPage['section'][$val->section_id]['has_more_section'] = $val->avoir_sous_section;
            if ($val->is_list_vertical == 1) {
                if (is_numeric($val->sous_section_id)) {
                    $arrPage[$val->section_id][$val->sous_section_libelle][$key]['lien'] = $val->lien;
                    $arrPage[$val->section_id][$val->sous_section_libelle][$key]['libelle'] = $val->libelle;
                    $arrPage[$val->section_id][$val->sous_section_libelle][$key]['show_menu'] = $val->show_menu;
                } else {
                    $arrPage[$val->section_id][$key]['lien'] = $val->lien;
                    $arrPage[$val->section_id][$key]['libelle'] = $val->libelle;
                    $arrPage[$val->section_id][$key]['id'] = $val->id;
                    $arrPage[$val->section_id][$key]['show_menu'] = $val->show_menu;
                }
            }
        endforeach;
        return $arrPage;
    }

    /**
     * Lien accessible au profil
     *
     * @return Array
     */
    public function mySection($sectionId)
    {
        $session = \Config\Services::session();
        $id_profil = !empty($session->get('infos_perm')) ? $session->infos_perm['profil_id'] : null;
        if (!is_numeric($id_profil)) {
            return array();
        }
        if (is_numeric($sectionId)) {
            return $this->db
                ->table('acces')
                ->join('page', 'page.id = acces.page_id', 'INNER')
                ->join('sous_section', 'page.sous_section_id = sous_section.id and sous_section.actif = 1', 'left')
                ->where('profil_id', $id_profil)
                ->where('page.section_id', $sectionId)
                ->orderBy('sous_section.ordre', 'ASC')
                ->orderBy('ordre', 'asc')
                ->select('sous_section.*')
                ->get()->getResult();
        }
        return [];
    }

    public function my_pages($sectionId, $sousSection)
    {
        $session = \Config\Services::session();
        $id_profil = !empty($session->get('infos_perm')) ? $session->infos_perm['profil_id'] : null;
        if (!is_numeric($id_profil)) {
            return array();
        }
        if (is_numeric($sectionId)) {
            $builder = $this->db
                ->table('acces')
                ->join('page', 'page.id = acces.page_id', 'INNER')
                ->join('sous_section', 'page.sous_section_id = sous_section.id and sous_section.actif = 1', 'left')
                ->where('profil_id', $id_profil)
                ->where('page.section_id', $sectionId);
            if (is_numeric($sousSection) && $sousSection > 0) {
                $builder->where('page.sous_section_id', $sousSection);
            }
            $builder->where('page.actif', 1)
                ->where('page.show_menu', 1)
                ->orderBy('page.ordre', 'ASC')
                ->select('page.*')
                ->select('sous_section.libelle sous_section_libelle');
            return $builder->get()->getResult();
        }
        return [];
    }

    /**
     * Si l'utilisateur a accès à la page
     *
     * @param  Integer $id_page
     * @return Boolean
     */
    public function can_go_here(int $id_page)
    {
        $session = \Config\Services::session();
        $id_profil = !empty($session->get('infos_perm')) ? $session->infos_perm['profil_id'] : null;
        if (is_numeric($id_page) && is_numeric($id_profil)) {
            return $this->db->table('acces')
                ->join('page', 'page.id = acces.page_id', 'INNER')
                ->join('profil', 'profil.id = acces.profil_id', 'INNER')
                ->where('profil_id', $id_profil)
                ->where('page_id', $id_page)
                ->where('profil.actif', 1)
                ->where('page.actif', 1)
                ->countAllResults() > 0;
        }
        return is_numeric($id_page) ? false : true; //if no num page then give access
    }

    /**
     * Ré-actualisation des données de l'utilisateur
     *
     */
    public function refresh_login_user_data()
    {
        $session = \Config\Services::session();
        $id_user = isset($session->get('infos_perm')['user_id']) ? $session->infos_perm['user_id'] : null;
        if (is_numeric($id_user)) {
            $data_user = $this->db->table('utilisateur')
                ->join('profil', 'profil.id = utilisateur.profil_id', 'left')
                ->where('utilisateur.id', $id_user)
                ->where('utilisateur.flag_suppression', 0)
                ->where('utilisateur.actif', 1)
                ->select('utilisateur.id as user_id,societe_id,profil_id,division_id,utilisateur.actif as actif_user,utilisateur.flag_suppression,profil.libelle as profil_libelle,profil.actif as profil_actif,college_id')
                ->get()->getRowArray();
            if (isset($data_user['user_id'])) {
                $session->set("infos_perm", $data_user);
                return;
            }
        }
        $session->remove("infos_perm");
    }

    public function getLogo($societeId)
    {
        if (isset($societeId)) {
            $arr = str_replace("'", "", str_replace('}', ')', str_replace('{', '(', $societeId)));
            if (isset($arr)) {
                return $this->db->table('fn_societe')
                    ->where("id in $arr", null, false)
                    ->where('actif', 1)
                    ->distinct()
                    ->select('logo')
                    ->get()
                    ->getResultArray();
            }
        }
        return [];
    }

    public function checkHabilitationReadOnly($page_id, $profil_id, $college_id)
    {
        if (is_numeric($page_id) && is_numeric($page_id) && !is_null($college_id)) {
            return $this->db->table(TBL_HABILITATION)
                ->where('page_id', $page_id)
                ->where('profil_id', $profil_id)
                //->where(" '$college_id' && college_id", null)
                ->where("(college_id <@ '$college_id' and college_id @> '$college_id')", null, false)
                ->where('flag_suppression', 0)
                ->where('flag_read_only', 1)
                ->countAllResults();
        }
        return 0;
    }

    public function checkHabilitationReadWrite($page_id, $profil_id, $college_id)
    {
        if (is_numeric($page_id) && is_numeric($page_id) && !is_null($college_id)) {
            return $this->db->table(TBL_HABILITATION)
                ->where('page_id', $page_id)
                ->where('profil_id', $profil_id)
                ->where("(college_id <@ '$college_id' and college_id @> '$college_id')", null, false)
                ->where('flag_suppression', 0)
                ->where('flag_read_write', 1)
                ->countAllResults();
        }
        return 0;
    }
}
