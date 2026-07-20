<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>
    Gain des opérateurs
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Gain des opérateurs</h1>

    <table>
        <thead>
            <tr>
                <th>Opérateur</th>
                <th>Code</th>
                <th>Gain total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($operateurs as $op) : ?>
                <tr>
                    <td><?= $op['nom'] ?></td>
                    <td><?= $op['code'] ?></td>
                    <td><?= $op['gain'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>Gain total: <?= $gainTotal['gain'] ?></div>
    
    <?php if (empty($totalByType) && empty($totalByMois)) : ?>
        <br>
        <div>Aucune opération trouvée pour calculer les totaux.</div>
    <?php else: ?>
        <h2>Total des frais par type d'opération</h2>
        <table>
            <thead>
                <tr>
                    <th>Type d'opération</th>
                    <th>Total des frais</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($totalByType as $total) : ?>
                    <tr>
                        <td><?= $total['type_operation'] ?></td>
                        <td><?= $total['total_frais'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Total des frais par mois</h2>
        <table>
            <thead>
                <tr>
                    <th>Mois</th>
                    <th>Total des frais</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($totalByMois as $total) : ?>
                    <tr>
                        <td><?= $total['mois'] ?></td>
                        <td><?= $total['total_frais'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

<?= $this->endSection() ?>