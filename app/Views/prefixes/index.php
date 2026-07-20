<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Préfixes<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Liste des préfixes valables</h1>

    <a href="<?= site_url('prefixes/showForm') ?>">Ajouter un nouveau préfixe</a>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Préfixe</th>
                <th>Opérateur</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prefixes as $prefixe) : ?>
                <tr>
                    <td><?= esc($prefixe['id']) ?></td>
                    <td><?= esc($prefixe['prefixe']) ?></td>
                    <td><?= esc($prefixe['operateur_nom']) ?></td>
                    <td>
                        <a href="<?= site_url('prefixes/showForm/' . $prefixe['id']) ?>"><button>Modifier</button></a>
                    </td>
                    <td>
                        <a href="<?= site_url('prefixes/delete/' . $prefixe['id']) ?>"><button>Supprimer</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>