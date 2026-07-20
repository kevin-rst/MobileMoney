<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Préfixes<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="mm-panel">
        <div class="mm-panel__header d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3">
            <div>
                <div class="mm-kicker">Back-office</div>
                <h1>Liste des préfixes valables</h1>
                <p>Gérez les préfixes liés aux opérateurs de votre réseau Mobile Money.</p>
            </div>

            <a class="mm-btn" href="<?= site_url('prefixes/showForm') ?>">Ajouter un nouveau préfixe</a>
        </div>

        <div class="mm-panel__body">
            <div class="mm-table-wrap">
                <table class="mm-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Préfixe</th>
                            <th>Opérateur</th>
                            <th colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($prefixes ?? []) as $prefixe) : ?>
                            <tr>
                                <td><?= esc($prefixe['id']) ?></td>
                                <td><span class="mm-badge mm-badge--ghost"><?= esc($prefixe['prefixe']) ?></span></td>
                                <td><?= esc($prefixe['operateur_nom']) ?></td>
                                <td>
                                    <a class="mm-card-link" href="<?= site_url('prefixes/showForm/' . $prefixe['id']) ?>">Modifier</a>
                                </td>
                                <td>
                                    <a class="mm-card-link" href="<?= site_url('prefixes/delete/' . $prefixe['id']) ?>">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>