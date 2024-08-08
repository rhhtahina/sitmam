<form class="form-validate-upd-jquery">
    <div class="form-group">
        <label>Profil <span class="text-bold text-danger" <?= $display ?>>*</span></label>
        <input type="text" class="form-control input-xs" placeholder="Profil" name="profil_upd" id="profil_upd" required="required" value="<?= $data["libelle"] ?>" <?= $disabled ?>>
        <label id="profil_upd-error" class="validation-error-label text-danger" for="profil_upd"></label>
    </div>

    <?php if ($action == 'upd') : ?>
        <div class="card border">
            <div class="card-header">
                <div class="panel-heading">
                    <h6 class="panel-title">Liste des pages associées au profil <span class="text-bold text-danger" <?= $display ?>>*</span></h6>
                </div>
            </div>
            <div class="card-body">
                <select multiple="multiple" class="form-control listbox" name="page_upd" id="page_upd" <?= $disabled ?>>
                    <?php foreach ($data_page as $key_p => $val_p) : ?>
                        <?php $selected = (in_array($val_p->id, $data_profil_id)) ? "selected" : "0"; ?>
                        <option value="<?= $val_p->id; ?>" <?= $selected; ?>><?= $val_p->libelle; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="page_upd" id="page_upd-error" class="validation-error-label"></label>
            </div>
        </div>
    <?php elseif ($action == 'voir') : ?>
        <div class="form-group">
            <label>Liste des pages accessibles pour ce profil :</label>
            <ul>
                <?php foreach ($data_page_profil as $key_pa => $val_pa) : ?>
                    <li><?= $val_pa->libelle; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="modal-footer" id="div_profil_footer">
        <button type="button" class="btn btn-success btn-xs button" id="save_upd" onclick="maj(<?= $data['id'] ?>)" style="float:right">
            <i class="loading-icon fa fa-spinner fa-spin hide"></i>
            <i class="fas fa-check check_validation"></i>
            <span class="btn-txt">Enregistrer</span>
        </button>
    </div>
</form>

<script type="text/javascript">
    $("#page_upd").bootstrapDualListbox({
        nonSelectedListLabel: "Pages disponibles",
        selectedListLabel: "Pages sélectionnées",
        showFilterInputs: false,
        filterTextClear: "",
        infoText: "",
        infoTextFiltered: "",
        infoTextEmpty: "",
    });
</script>