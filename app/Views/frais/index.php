<?= $this->extend('layouts/backoffice') ?>

<?= $this->section('title') ?>Frais<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Liste des frais par tranche de montant (Rétrait et Transfert)</h1>

    <a href="<?= site_url('frais/showForm') ?>">Ajouter un nouveau frais</a>

    <table>
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
            <?php foreach ($frais as $item) : ?>
                <tr>
                    <td><?= esc($item['id']) ?></td>
                    <td><?= esc($item['montant_min']) ?></td>
                    <td><?= esc($item['montant_max']) ?></td>
                    <td><?= esc($item['frais']) ?></td>
                    <td><?= esc($item['type_operation_libelle'] ?? '') ?></td>
                    <td>
                        <a href="<?= site_url('frais/showForm/' . $item['id']) ?>"><button>Modifier</button></a>
                    </td>
                    <td>
                        <a href="<?= site_url('frais/delete/' . $item['id']) ?>"><button>Supprimer</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>