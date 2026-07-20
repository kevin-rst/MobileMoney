<?= $this->extend('layouts/frontoffice') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h1>Réaliser une transaction</h1>

    <form action="<?= base_url('client/transaction') ?>" method="post">
        <label for="montant">Montant :</label>
        <input type="number" name="montant" id="montant" required>
        <br><br>

        <label for="type_operation">Type d'opération :</label>
        <select name="type_operation" id="type_operation">
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['id'] ?>"><?= $type['libelle'] ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        
        <label for="client_destination">Compte destinataire :</label>
        <input type="text" name="compte_destination" id="client_destination" disabled>

        <button type="submit">Effectuer la transaction</button>
    </form>

<?= $this->endSection() ?>