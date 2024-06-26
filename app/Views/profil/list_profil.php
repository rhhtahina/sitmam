<?= view_cell('\App\Libraries\LibView::header') ?>
<?= view_cell('\App\Libraries\LibView::navBarMenu') ?>
<?= view_cell('\App\Libraries\LibView::menuVertical') ?>

<link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap/cssbootstrap-duallistbox.min.css.css') ?>">

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
</style>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Gestion de profil</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header button-right">
                        <button type="button" class="btn btn-icon icon-left btn-primary btn-right" id="add_profil" data-toggle="modal" data-target="#modal_ajout_profil"><i class="far fa-user"></i> Ajout Profil</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>Task Name</th>
                                        <th>Progress</th>
                                        <th>Members</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            1
                                        </td>
                                        <td>Create a mobile app</td>
                                        <td class="align-middle">
                                            <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                                                <div class="progress-bar bg-success" data-width="100%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                                        </td>
                                        <td>2018-01-20</td>
                                        <td>
                                            <div class="badge badge-success">Completed</div>
                                        </td>
                                        <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2
                                        </td>
                                        <td>Redesign homepage</td>
                                        <td class="align-middle">
                                            <div class="progress" data-height="4" data-toggle="tooltip" title="0%">
                                                <div class="progress-bar" data-width="0"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Nur Alpiana">
                                            <img alt="image" src="assets/img/avatar/avatar-3.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Hariono Yusup">
                                            <img alt="image" src="assets/img/avatar/avatar-4.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Bagus Dwi Cahya">
                                        </td>
                                        <td>2018-04-10</td>
                                        <td>
                                            <div class="badge badge-info">Todo</div>
                                        </td>
                                        <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3
                                        </td>
                                        <td>Backup database</td>
                                        <td class="align-middle">
                                            <div class="progress" data-height="4" data-toggle="tooltip" title="70%">
                                                <div class="progress-bar bg-warning" data-width="70%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Rizal Fakhri">
                                            <img alt="image" src="assets/img/avatar/avatar-2.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Hasan Basri">
                                        </td>
                                        <td>2018-01-29</td>
                                        <td>
                                            <div class="badge badge-warning">In Progress</div>
                                        </td>
                                        <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            4
                                        </td>
                                        <td>Input data</td>
                                        <td class="align-middle">
                                            <div class="progress" data-height="4" data-toggle="tooltip" title="100%">
                                                <div class="progress-bar bg-success" data-width="100%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <img alt="image" src="assets/img/avatar/avatar-2.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Rizal Fakhri">
                                            <img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Isnap Kiswandi">
                                            <img alt="image" src="assets/img/avatar/avatar-4.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Yudi Nawawi">
                                            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Khaerul Anwar">
                                        </td>
                                        <td>2018-01-16</td>
                                        <td>
                                            <div class="badge badge-success">Completed</div>
                                        </td>
                                        <td><a href="#" class="btn btn-secondary">Detail</a></td>
                                    </tr>
                                </tbody>
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
                    <input type="text" class="form-control" placeholder="Profil">
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
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-icon btn-success"><i class="fas fa-check"></i> Enregistrer</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL AJOUT PROFIL -->

<?= view_cell('\App\Libraries\LibView::footer'); ?>

<script type="text/javascript" src="assets/js/profil/profil.js?d=<?= date('YmdHis') ?>"></script>
<script type="text/javascript" src="assets/modules/inputs/duallistbox.min.js"></script>