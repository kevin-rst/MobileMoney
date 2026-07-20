<?= $this->extend('layouts/frontoffice') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h1>Bienvenu dans votre espace client</h1>

    <a href="<?= base_url('client/solde/' . (session()->get('client_id') ?? '1') ) ?>">Voir mon solde</a>
    <a href="<?= base_url('client/operations') ?>">Réaliser une transaction</a>

<?= $this->endSection() ?>
