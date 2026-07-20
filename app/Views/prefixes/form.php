<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Formulaire de préfixe<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="mm-panel">
    <div class="mm-panel__header">
        <div class="mm-kicker">Préfixe</div>
        <h1>Formulaire de préfixe</h1>
        <p>Associez un préfixe à l’opérateur correspondant.</p>
    </div>

    <div class="mm-panel__body">
        <form class="mm-form" action="<?= site_url('prefixes/save') ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="id" value="<?= isset($prefixe) ? $prefixe['id'] : '' ?>">

            <div class="mm-field">
                <label for="prefixe">Préfixe</label>
                <input type="text" name="prefixe" id="prefixe" value="<?= old('prefixe') ?? (isset($prefixe) ? $prefixe['prefixe'] : '') ?>" required>
                <?php if (session('errors.prefixe')): ?>
                    <div class="mm-help"><?= session('errors.prefixe') ?></div>
                <?php endif; ?>
            </div>

            <div class="mm-field">
                <label for="operateur_id">Opérateur</label>
                <select name="operateur_id" id="operateur_id" required>
                    <option value="">Sélectionnez un opérateur</option>
                    <?php foreach (($operateurs ?? []) as $operateur): ?>
                        <option value="<?= $operateur['id'] ?>" <?= old('operateur_id') && old('operateur_id') == $operateur['id'] || (isset($prefixe) && $prefixe['operateur_id'] == $operateur['id']) ? 'selected' : '' ?>><?= $operateur['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (session('errors.operateur_id')): ?>
                    <div class="mm-help"><?= session('errors.operateur_id') ?></div>
                <?php endif; ?>
            </div>

            <div class="mm-inline-actions">
                <button class="mm-btn" type="submit">Enregistrer</button>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection() ?>