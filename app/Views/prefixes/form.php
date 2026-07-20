<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Formulaire de préfixe<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1>Formulaire de préfixe</h1>

<form action="<?= site_url('prefixes/save') ?>" method="post">
    <input type="hidden" name="id" value="<?= isset($prefixe) ? $prefixe['id'] : '' ?>">

    <label for="prefixe">Préfixe :</label>
    <input type="text" name="prefixe" id="prefixe" value="<?= old('prefixe') ?? (isset($prefixe) ? $prefixe['prefixe'] : '') ?>" required>
    <?php if (session('errors.prefixe')): ?>
        <div><?= session('errors.prefixe') ?></div>
    <?php endif; ?>
    <br><br>

    <label for="operateur_id">Opérateur :</label>
    <select name="operateur_id" id="operateur_id" required>
        <option value="">Sélectionnez un opérateur</option>
        <?php foreach ($operateurs as $operateur): ?>
            <option value="<?= $operateur['id'] ?>" <?= old('operateur_id') && old('operateur_id') == $operateur['id'] || (isset($prefixe) && $prefixe['operateur_id'] == $operateur['id']) ? 'selected' : '' ?>><?= $operateur['nom'] ?></option>
        <?php endforeach; ?>
    </select>
    <?php if (session('errors.operateur_id')): ?>
        <div><?= session('errors.operateur_id') ?></div>
    <?php endif; ?>
        <br><br>

    <button type="submit">Enregistrer</button>
</form>
<?= $this->endSection() ?>