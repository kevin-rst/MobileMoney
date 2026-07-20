<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Formulaire de frais<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1>Formulaire de frais</h1>

<form action="<?= site_url('frais/save') ?>" method="post">
    <input type="hidden" name="id" value="<?= isset($frais) ? $frais['id'] : '' ?>">

    <label for="montant_min">Montant minimum :</label>
    <input type="number" step="0.01" name="montant_min" id="montant_min" value="<?= old('montant_min') ?? (isset($frais) ? $frais['montant_min'] : '') ?>" required>
    <?php if (session('errors.montant_min')): ?>
        <div><?= session('errors.montant_min') ?></div>
    <?php endif; ?>
    <br><br>

    <label for="montant_max">Montant maximum :</label>
    <input type="number" step="0.01" name="montant_max" id="montant_max" value="<?= old('montant_max') ?? (isset($frais) ? $frais['montant_max'] : '') ?>" required>
    <?php if (session('errors.montant_max')): ?>
        <div><?= session('errors.montant_max') ?></div>
    <?php endif; ?>
    <br><br>

    <label for="frais">Frais :</label>
    <input type="number" step="0.01" name="frais" id="frais" value="<?= old('frais') ?? (isset($frais) ? $frais['frais'] : '') ?>" required>
    <?php if (session('errors.frais')): ?>
        <div><?= session('errors.frais') ?></div>
    <?php endif; ?>
    <br><br>

    <label for="type_operation_id">Type d'opération :</label>
    <select name="type_operation_id" id="type_operation_id" required>
        <option value="">-- Choisir --</option>
        <?php if (isset($types) && is_array($types)): ?>
            <?php foreach ($types as $type): ?>
                <?php $selected = (old('type_operation_id') ?? (isset($frais) ? $frais['type_operation_id'] : '')) == $type['id'] ? 'selected' : '' ?>
                <option value="<?= esc($type['id']) ?>" <?= $selected ?>><?= esc($type['libelle']) ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    <?php if (session('errors.type_operation_id')): ?>
        <div><?= session('errors.type_operation_id') ?></div>
    <?php endif; ?>
    <br><br>

    <button type="submit">Enregistrer</button>
</form>
<?= $this->endSection() ?>