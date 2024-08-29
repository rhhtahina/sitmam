<?= view_cell('\App\Libraries\LibView::header') ?>
<?= view_cell('\App\Libraries\LibView::navBarMenu') ?>
<?= view_cell('\App\Libraries\LibView::menuVertical') ?>

<style>
    .button-right {
        display: flex;
        justify-content: flex-end;
        padding: 10px;
        /* Optional, for spacing */
    }

    .modal-header {
        display: flex;
        justify-content: center;
        position: relative;
    }

    .modal-header h5 {
        flex: 1;
        text-align: center;
    }

    .modal-header .close {
        position: absolute;
        right: 1rem;
        top: 0.5rem;
    }

    .hide {
        display: none;
    }
</style>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Gestion des utilisateurs</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header button-right">
                        <button type="button" class="btn btn-icon icon-left btn-primary btn-right" id="add_utilisateur" data-toggle="modal" data-target="#modal_ajout_utilisateur"><i class="far fa-user"></i> Ajout Utilisateur</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table_utilisateur">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            Actions
                                        </th>
                                        <th class="text-center">Nom</th>
                                        <th class="text-center">Prénom</th>
                                        <th class="text-center">Login</th>
                                        <th class="text-center">Profil</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL AJOUT UTILISATEUR -->
<div id="modal_ajout_utilisateur" class="modal fade">
    <div class="modal-dialog modal-custom">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Ajout d'un utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" data-popup="tooltip" title="Fermer le pop-up" data-placement="left">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Nom <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Nom" name="nom_utilisateur" id="nom_utilisateur" required>
                            <label for="nom_utilisateur" id="nom_utilisateur-error" class="validation-error-label text-danger"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Prénom <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Prénom" name="prenom_utilisateur" id="prenom_utilisateur" required>
                            <label for="prenom_utilisateur" id="prenom_utilisateur-error" class="validation-error-label text-danger"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Login <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" placeholder="Login" name="login_utilisateur" id="login_utilisateur" required>
                            <label for="login_utilisateur" id="login_utilisateur-error" class="validation-error-label text-danger"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Profil <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" placeholder="Profil" name="profil_utilisateur" id="profil_utilisateur" required>
                                <option value="">Selectionnez un profil ...</option>
                                <?php foreach ($profil as $list_profil): ?>
                                    <option value="<?= $list_profil['id'] ?>"><?= $list_profil['libelle'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="profil_utilisateur" id="profil_utilisateur-error" class="validation-error-label text-danger"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Mot de passe <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" placeholder="Mot de passe" name="mdp_utilisateur" id="mdp_utilisateur" required>
                            <label for="mdp_utilisateur" id="mdp_utilisateur-error" class="validation-error-label text-danger"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Confirmation mot de passe <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" placeholder="Confirmation mot de passe" name="confirmation_mdp_utilisateur" id="confirmation_mdp_utilisateur" required>
                            <label for="confirmation_mdp_utilisateur" id="confirmation_mdp_utilisateur-error" class="validation-error-label text-danger"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-icon btn-success button" id="save_utilisateur" onclick="insert_utilisateur()">
                        <i class="loading-icon fa fa-spinner fa-spin hide"></i>
                        <i class="fas fa-check check_validation"></i>
                        <span class="btn-txt">Enregistrer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL AJOUT UTILISATEUR -->

<?= view_cell('\App\Libraries\LibView::footer'); ?>

<script type="text/javascript" src="assets/js/utilisateur/utilisateur.js?d=<?= date('YmdHis') ?>"></script>
<script type="text/javascript" src="assets/js/page/datatable.js?d=<?= date('YmdHis')  ?>"></script>