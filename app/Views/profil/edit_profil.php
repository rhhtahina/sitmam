<form class="form-validate-upd-jquery">
    <div class="form-group">
        <label>Profil <span class="text-bold text-danger" <?= $display ?>>*</span></label>
        <input type="text" class="form-control input-xs" placeholder="Profil" name="profil_upd" id="profil_upd" required="required" value="<?= $data["libelle"] ?>" <?= $disabled ?>>
    </div>

    <?php if ($action == 'upd') : ?>
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="panel-title">Liste des pages associées au profil <span class="text-bold text-danger" <?= $display ?>>*</span></div>
            </div>
        </div>
    <?php elseif ($action == 'voir') : ?>
        <div class="panel panel-flat">
            <div class="panel-heading">
                <div class="panel-title">Liste des pages associées au profil <span class="text-bold text-danger" <?= $display ?>>*</span></div>
            </div>
        </div>
    <?php endif; ?>
</form>