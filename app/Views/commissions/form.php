<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Formulaire de commission<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="mm-panel">
    <div class="mm-panel__header">
        <div class="mm-kicker">Commission</div>
        <h1>Formulaire de commission</h1>
        <p>Associez une commission à l’opérateur correspondant.</p>
    </div>

    <div class="mm-panel__body">
        <form class="mm-form" action="<?= site_url('commissions/save') ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="id" value="<?= isset($commission) ? $commission['id'] : '' ?>">

            <div class="mm-field">
                <label for="pct_commission">Pourcentage de commission</label>
                <input type="number" name="pct_commission" id="pct_commission" value="<?= old('pct_commission') ?? (isset($commission) ? $commission['pct_commission'] : '') ?>" step="0.01" min="0" max="1" required>
                <?php if (session('errors.pct_commission')): ?>
                    <div class="mm-help"><?= session('errors.pct_commission') ?></div>
                <?php endif; ?>
            </div>

            <div class="mm-field">
                <label for="operateur_id">Opérateur</label>
                <select name="operateur_id" id="operateur_id" required>
                    <option value="">Sélectionnez un opérateur</option>
                    <?php foreach (($operateurs ?? []) as $operateur): ?>
                        <option value="<?= $operateur['id'] ?>" <?= old('operateur_id') && old('operateur_id') == $operateur['id'] || (isset($commission) && $commission['operateur_id'] == $operateur['id']) ? 'selected' : '' ?>><?= $operateur['nom'] ?></option>
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