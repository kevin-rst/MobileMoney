<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Commissions<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="mm-panel">
        <div class="mm-panel__header d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3">
            <div>
                <div class="mm-kicker">Back-office</div>
                <h1>Liste des commissions</h1>
                <p>Gérez les commissions liées aux opérateurs de votre réseau Mobile Money.</p>
            </div>

            <a class="mm-btn" href="<?= site_url('commissions/showForm') ?>">Ajouter une nouvelle commission</a>
        </div>

        <div class="mm-panel__body">
            <div class="mm-table-wrap">
                <table class="mm-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Commission</th>
                            <th>Opérateur</th>
                            <th>Propriétaire</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($commissions ?? []) as $commission) : ?>
                            <tr>
                                <td><?= esc($commission['id']) ?></td>
                                <td><span class="mm-badge mm-badge--ghost"><?= esc($commission['pct_commission']) * 100 ?>%</span></td>
                                <td><?= esc($commission['operateur_nom']) ?></td>
                                <td><span class="mm-badge mm-badge--primary"><?= $commission['operateur_proprio'] == '1' ? 'Oui' : 'Non' ?></span></td>
                                <td>
                                    <a class="mm-card-link" href="<?= site_url('commissions/showForm/' . $commission['id']) ?>">Modifier</a>
                                </td>
                                <td>
                                    <a class="mm-card-link" href="<?= site_url('commissions/delete/' . $commission['id']) ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>