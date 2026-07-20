<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Solde des clients<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="mm-panel">
    <div class="mm-panel__header">
        <div class="mm-kicker">Statistiques</div>
        <h1>Solde des clients</h1>
        <p>Vue consolidée des comptes actifs sur la plateforme.</p>
    </div>

    <div class="mm-panel__body">
        <div class="mm-table-wrap">
            <table class="mm-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Numero de telephone</th>
                        <th>Total du solde</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($comptes ?? []) as $compte) : ?>
                        <tr>
                            <td><?= esc($compte['client_nom']) ?> <?= esc($compte['client_prenom']) ?></td>
                            <td><?= esc($compte['client_numero_telephone']) ?></td>
                            <td><span class="mm-badge mm-badge--primary"><?= esc($compte['solde']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mm-alert mt-4">
            <span>Total du solde de tous les clients: <?= ($soldeTotal['solde'] ?? 0) ?></span>
        </div>
    </div>
</section>

<?= $this->endSection() ?>