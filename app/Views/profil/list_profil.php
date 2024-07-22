<?= view_cell('\App\Libraries\LibView::header') ?>
<?= view_cell('\App\Libraries\LibView::navBarMenu') ?>
<?= view_cell('\App\Libraries\LibView::menuVertical') ?>

<link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap/css/bootstrap-duallistbox.min.css') ?>">

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

    .modal-custom {
        max-width: 40%;
        /* Custom width */
        max-height: 75%;
    }

    .custom_card {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .arrow {
        border: solid black;
        border-width: 0 3px 3px 0;
        display: inline-block;
        padding: 3px;
        transform: rotate(45deg);
        transition: transform 0.2s;
    }

    .down {
        transform: rotate(45deg);
    }

    .up {
        transform: rotate(-135deg);
    }

    .moveall,
    .removeall,
    .move,
    .remove,
    .pull-right {
        display: none !important;
    }

    .hide {
        display: none;
    }

    /* Datatable */
    .dt-left {
        text-align: left;
    }

    .dt-right {
        text-align: right;
    }

    .dataTables_filter {
        float: right !important;
    }

    #table_profil_length {
        float: left !important;
    }

    .sorting_1 {
        width: 140px;
    }
</style>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Gestion de profil</h1>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header button-right">
                        <button type="button" class="btn btn-icon icon-left btn-primary btn-right" id="add_profil" data-toggle="modal" data-target="#modal_ajout_profil"><i class="far fa-user"></i> Ajout Profil</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table_profil">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            Actions
                                        </th>
                                        <th class="text-center">
                                            Profil
                                        </th>
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

<!-- MODAL AJOUT PROFIL -->
<div id="modal_ajout_profil" class="modal fade">
    <div class="modal-dialog modal-custom">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Ajout d'un profil</h5>
                <button type="button" class="close" data-dismiss="modal" data-popup="tooltip" title="Fermer le pop-up" data-placement="left">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Profil <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Profil" name="profil_name" id="profil_name" required>
                    <label for="profil_name" id="profil_name-error" class="validation-error-label text-danger"></label>
                </div>
                <div class="card border">
                    <div class="card-header custom_card">
                        <h6>Liste des pages à associer au profil <span class="text-danger">*</span></h6>
                        <button id="toggleButton" class="btn btn-primary btn-sm">
                            <i class="arrow down"></i>
                        </button>
                    </div>
                    <div id="cardBody" class="card-body" style="display: block;">
                        <select multiple="multiple" id="page" class="form-control listbox">
                            <?php foreach ($data_page as $key_p => $val_p) : ?>
                                <option value="<?= $val_p->id ?>"><?= $val_p->libelle ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="page" id="page-error" class="validation-error-label"></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-icon btn-success button" id="save_profil" onclick="insert_profil()">
                        <i class="loading-icon fa fa-spinner fa-spin hide"></i>
                        <i class="fas fa-check check_validation"></i>
                        <span class="btn-txt">Enregistrer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL AJOUT PROFIL -->

<?= view_cell('\App\Libraries\LibView::footer'); ?>

<script type="text/javascript" src="assets/js/profil/profil.js?d=<?= date('YmdHis') ?>"></script>
<script type="text/javascript" src="assets/js/page/datatable.js?d=<?= date('YmdHis')  ?>"></script>
<script type="text/javascript" src="assets/modules/inputs/duallistbox.min.js"></script>