<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <form class="mm-form" action="<?= site_url('/login') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mm-field">
            <label for="numero_telephone">Numéro de téléphone ou code</label>
            <input type="text" name="numero_telephone" id="numero_telephone" placeholder="Ex. 034 12 345 67" required>
        </div>

        <div class="mm-inline-actions">
            <input class="mm-btn" type="submit" value="Se connecter">
        </div>
    </form>
<?= $this->endSection() ?>