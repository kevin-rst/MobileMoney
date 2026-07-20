<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>
    Montant des opérateurs
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="mm-panel">
        <div class="mm-panel__header">
            <div class="mm-kicker">Statistiques</div>
            <h1>Montant des opérateurs</h1>
            <p>Suivez les montants à envoyer aux autres opérateurs.</p>
        </div>

        <div class="mm-panel__body mm-stack">
            <?php if (empty($montantParOperateur)) : ?>
                <div class="mm-alert">
                    <span>Aucune opération trouvée pour les statistiques.</span>
                </div>
            <?php else: ?>
                <div class="mm-grid">
                    <section class="mm-panel">
                        <div class="mm-panel__header">
                            <h2>Total des montants pour chaque opérateur</h2>
                        </div>
                        <div class="mm-panel__body">
                            <div class="mm-table-wrap">
                                <table class="mm-table">
                                    <thead>
                                        <tr>
                                            <th>Opérateur</th>
                                            <th>Montant total</th>
                                            <th>Commission total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (($montantParOperateur ?? []) as $montant) : ?>
                                            <tr>
                                                <td><?= $montant['operateur'] ?></td>
                                                <td><?= $montant['total_montant'] ?></td>
                                                <td><?= $montant['total_commission'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>

                 <div class="mm-alert">
                <span>Montant total: <?= $totalMontant ?></span>
            </div>
            <div class="mm-alert">
                <span>Commission total: <?= $totalCommission ?></span>
            </div>
            <?php endif; ?>
        </div>
    </section>

<?= $this->endSection() ?>