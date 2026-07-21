<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Promotions<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="mm-panel">
        <div class="mm-panel__header d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3">
            <div>
                <div class="mm-kicker">Back-office</div>
                <h1>Liste des promotions</h1>
                <p>Gérez les promotions liées aux opérateurs de votre réseau Mobile Money.</p>
            </div>

            <a class="mm-btn" href="<?= site_url('promotions/showForm') ?>">Ajouter une nouvelle promotion</a>
        </div>

        <div class="mm-panel__body">
            <div class="mm-table-wrap">
                <table class="mm-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Promotion</th>
                            <th>Opérateur</th>
                            <th>Propriétaire</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($promotions ?? []) as $promotion) : ?>
                            <tr>
                                <td><?= esc($promotion['id']) ?></td>
                                <td><span class="mm-badge mm-badge--ghost"><?= esc($promotion['pct_promotion']) * 100 ?>%</span></td>
                                <td><?= esc($promotion['operateur_nom']) ?></td>
                                <td><span class="mm-badge mm-badge--primary"><?= $promotion['operateur_proprio'] == '1' ? 'Oui' : 'Non' ?></span></td>
                                <td>
                                    <a class="mm-card-link" href="<?= site_url('promotions/showForm/' . $promotion['id']) ?>">Modifier</a>
                                </td>
                                <td>
                                    <a class="mm-card-link" href="<?= site_url('promotions/delete/' . $promotion['id']) ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>