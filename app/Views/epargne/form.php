<?= $this->extend('layouts/frontoffice') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="mm-panel">
        <div class="mm-panel__header">
            <div class="mm-kicker">Epargne</div>
            <h1>Choisir le pourcentage d'epargne</h1>
        </div>

        <div class="mm-panel__body">
            <form class="mm-form" action="<?= base_url('epargne/inserer') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mm-field">
                    <label for="montant">Pourcentage:</label>
                    <input type="number" name="pct_epargne" id="montant" step="0.01" required>
                </div>

                <div class="mm-inline-actions">
                    <button class="mm-btn" id="btn-submit" type="submit">Effectuer la transaction</button>
                </div>
            </form>
        </div>
    </section>

<?= $this->endSection() ?>