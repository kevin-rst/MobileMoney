<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>
    Gain des opérateurs
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="mm-panel">
        <div class="mm-panel__header">
            <div class="mm-kicker">Statistiques</div>
            <h1>Gain des opérateurs</h1>
            <p>Suivez les gains générés et la ventilation des frais par période.</p>
        </div>

        <div class="mm-panel__body mm-stack">
            <div class="mm-table-wrap">
                <table class="mm-table">
                    <thead>
                        <tr>
                            <th>Opérateur</th>
                            <th>Code</th>
                            <th>Propriété</th>
                            <th>Gain total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($operateurs ?? []) as $op) : ?>
                            <tr>
                                <td><?= $op['nom'] ?></td>
                                <td><span class="mm-badge mm-badge--ghost"><?= $op['code'] ?></span></td>
                                <td><span class="mm-badge mm-badge--primary"><?= $op['proprio'] == '1' ? 'Oui' : 'Non' ?></span></td>
                                <td><span class="mm-badge mm-badge--primary"><?= $op['gain'] ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mm-alert">
                <span>Gain total: <?= ($gainTotal['gain'] ?? 0) ?></span>
            </div>

            <?php if (empty($totalByType) && empty($totalByMois)) : ?>
                <div class="mm-alert">
                    <span>Aucune opération trouvée pour calculer les totaux.</span>
                </div>
            <?php else: ?>
                <div class="mm-grid">
                    <section class="mm-panel">
                        <div class="mm-panel__header">
                            <h2>Total des frais par type d'opération</h2>
                        </div>
                        <div class="mm-panel__body">
                            <div class="mm-table-wrap">
                                <table class="mm-table">
                                    <thead>
                                        <tr>
                                            <th>Type d'opération</th>
                                            <th>Total des frais</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (($totalByType ?? []) as $total) : ?>
                                            <tr>
                                                <td><?= $total['type_operation'] ?></td>
                                                <td><?= $total['total_frais'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <section class="mm-panel">
                        <div class="mm-panel__header">
                            <h2>Total des frais par mois</h2>
                        </div>
                        <div class="mm-panel__body">
                            <div class="mm-table-wrap">
                                <table class="mm-table">
                                    <thead>
                                        <tr>
                                            <th>Mois</th>
                                            <th>Total des frais</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (($totalByMois ?? []) as $total) : ?>
                                            <tr>
                                                <td><?= $total['mois'] ?></td>
                                                <td><?= $total['total_frais'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?= $this->endSection() ?>