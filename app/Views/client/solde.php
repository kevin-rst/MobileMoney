<?= $this->extend('layouts/frontoffice') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>
    <?php $historiqueItems = $historique ?? []; ?>
    <section class="mm-hero">
        <div class="mm-kicker">Compte</div>
        <h1>Votre solde actuel</h1>
        <p>Suivez vos mouvements financiers et vérifiez l’activité de votre portefeuille en temps réel.</p>
        <div class="mm-stats">
            <div class="mm-stat">
                <strong><?= esc((string) ($solde ?? 0)) ?> Ar</strong>
                <span class="mm-muted">Montant disponible</span>
            </div>
            <div class="mm-stat">
                <strong><?= empty($historiqueItems) ? '0' : count($historiqueItems) ?></strong>
                <span class="mm-muted">Opérations affichées</span>
            </div>
        </div>
    </section>

    <section class="mm-panel mt-4">
        <div class="mm-panel__header">
            <h2>Historique des transactions</h2>
            <p>Les dernières opérations enregistrées sur ce compte.</p>
        </div>

        <div class="mm-panel__body">
            <?php if (empty($historiqueItems)) : ?>
                <div class="mm-alert">
                    <span>Aucune transaction trouvée.</span>
                </div>
            <?php else : ?>
                <div class="mm-table-wrap">
                    <table class="mm-table">
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
                            <?php foreach ($historiqueItems as $operation): ?>
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
                </div>
            <?php endif; ?>
        </div>
    </section>
<?= $this->endSection() ?>
