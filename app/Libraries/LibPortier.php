<?php

namespace App\Libraries;

class LibPortier
{
    protected $session;
    protected $model_login;
    protected $is_ajax;
    protected $data_login;
    protected $fav_page;
    protected $valide_session;
    protected $actif_user;
    protected $can_go_here;
    protected $go_out;
    private function init()
    {
        $this->session = \Config\Services::session();
        $this->model_login = new \App\Models\LoginModel();
        $this->model_login->refresh_login_user_data();
        $request = \Config\Services::request();
        $this->is_ajax = $request->isAJAX();
        $this->data_login = array(
            'error_message' => null,
            'info_message' => null,
        );
        $this->fav_page = $this->model_login->my_favorite_page();
        $this->fav_page = is_null($this->fav_page) ? '/' : $this->fav_page->lien;
    }

    /**
     * Test de validation de session
     * Validité de l'accès à la page
     *
     * @param  Integer $id_page
     * @return Boolean
     */
    public function is_ok(int $id_page = null)
    {
        $this->init();
        $have_session = !empty($this->session->get('infos_perm'));
        $this->valide_session = $have_session && isset($this->session->infos_perm['user_id']) && isset($this->session->infos_perm['profil_id']) && is_numeric($this->session->infos_perm['user_id']) && is_numeric($this->session->infos_perm['profil_id']);
        $this->actif_user = $this->valide_session && $this->session->infos_perm['actif_user'] == 1 && $this->session->infos_perm['flag_suppression'] == 0;
        $this->can_go_here = $this->model_login->can_go_here($id_page);
        $this->go_out = false;
        if (!$this->valide_session) { //accès invalide
            $this->data_login['error_message'] = 'Session invalide';
            $this->go_out = true;
            return false;
        } elseif (!$this->actif_user) { //utilisateur invalide
            $this->data_login['error_message'] = 'Compte desactivé ou supprimé';
            $this->go_out = true;
            return false;
        } elseif (!$this->can_go_here) { //pas accès à la page
            return false;
        }
        return true;
    }

    /**
     * Redirection s'il y a anomalie ou pas
     *
     * @return void
     */
    public function get_redirect()
    {
        if ($this->go_out) {
            $this->session->remove('infos_perm');
            if ($this->is_ajax) {
                echo $this->data_login['error_message'] . ' merci de vous reconnecter: ' . site_url();
                die();
            }
            $this->session->setFlashdata('login_page_data', $this->data_login);
            return redirect()->to('/');
        }
        if ($this->is_ajax) {
            echo 'Accès refusé!';
            die();
        }
        return redirect()->to($this->fav_page);
    }

    public function check_acces_bouton(int $page_id = null)
    {
        $this->init();
        $profil_id = isset($this->session->infos_perm['profil_id']) ? $this->session->infos_perm['profil_id'] : null;
        $college_id = isset($this->session->infos_perm['college_id']) ? $this->session->infos_perm['college_id'] : null;
        $read_only = $this->model_login->checkHabilitationReadOnly($page_id, $profil_id, $college_id);
        $read_write = $this->model_login->checkHabilitationReadWrite($page_id, $profil_id, $college_id);
        if ($read_only == 1) {
            return 'read';
        } elseif ($read_write == 1) {
            return 'write';
        }
        return "";
    }
}