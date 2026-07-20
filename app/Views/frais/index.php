<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Frais<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="mm-panel">
        <div class="mm-panel__header d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3">
            <div>
                <div class="mm-kicker">Back-office</div>
                <h1>Liste des frais par tranche de montant</h1>
                <p>Configurez les frais appliqués selon le type d’opération.</p>
            </div>

            <a class="mm-btn" href="<?= site_url('frais/showForm') ?>">Ajouter un nouveau frais</a>
        </div>

        <div class="mm-panel__body">
            <div class="mm-table-wrap">
                <table class="mm-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Montant minimum</th>
                            <th>Montant maximum</th>
                            <th>Frais</th>
                            <th>Type d'opération</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($frais ?? []) as $item) : ?>
                            <tr>
                                <td><?= esc($item['id']) ?></td>
                                <td><?= esc($item['montant_min']) ?></td>
                                <td><?= esc($item['montant_max']) ?></td>
                                <td><span class="mm-badge mm-badge--secondary"><?= esc($item['frais']) ?></span></td>
                                <td><?= esc($item['type_operation_libelle'] ?? '') ?></td>
                                <td>
                                    <a class="mm-card-link" href="<?= site_url('frais/showForm/' . $item['id']) ?>">Modifier</a>
                                </td>
                                <td>
                                    <a class="mm-card-link" href="<?= site_url('frais/delete/' . $item['id']) ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>