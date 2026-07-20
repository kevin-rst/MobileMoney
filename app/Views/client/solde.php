<?= $this->extend('layouts/frontoffice') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>

    <p>Vous avez un solde de <?= $solde ?> Ar</p>


    <?php if (empty($historique)) : ?>
        <p>Aucune transaction trouvée.</p>
    <?php else : ?>
        <h2>Historique des transactions</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Type</th>
                    <th>Compte source</th>
                    <th>Compte destination</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historique as $operation): ?>
                    <tr>
                        <td><?= esc((string) $operation->date_operation ) ?></td>
                        <td><?= esc((string) $operation->montant ) ?></td>
                        <td><?= esc((string) $operation->type_operation ) ?></td>
                        <td><?= esc((string) $operation->client_source ) ?></td>
                        <td><?= esc((string) $operation->client_destination ) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?= $this->endSection() ?>
