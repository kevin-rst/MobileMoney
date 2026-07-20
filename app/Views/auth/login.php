<?= $this->extend('layouts/auth') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <form action="<?= site_url('/login') ?>" method="post">
        <label for="numero_telephone">Numéro de téléphone (ou Code)</label>
        <input type="text" name="numero_telephone" id="numero_telephone" required>
        <br><br>

        <input type="submit" value="Se connecter">
    </form>
<?= $this->endSection() ?>