<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Solde des clients<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1>Solde des clients</h1>

<table>
    <thead>
        <tr>
            <th>Client</th>
            <th>Numero de telephone</th>
            <th>Total du solde</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comptes as $compte) : ?>
            <tr>
                <td><?= esc($compte['client_nom']) ?> <?= esc($compte['client_prenom']) ?></td>
                <td><?= esc($compte['client_numero_telephone']) ?></td>
                <td><?= esc($compte['solde']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>Total du solde de tous les clients: <?= $soldeTotal['solde'] ?></div>

<?= $this->endSection() ?>