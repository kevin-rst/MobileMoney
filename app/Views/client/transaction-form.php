<?= $this->extend('layouts/frontoffice') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="mm-panel">
        <div class="mm-panel__header">
            <div class="mm-kicker">Transaction</div>
            <h1>Réaliser une transaction</h1>
            <p>Le champ du compte destinataire s’active automatiquement pour les transferts.</p>
        </div>

        <div class="mm-panel__body">
            <form class="mm-form" action="<?= base_url('client/transaction') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mm-field">
                    <label for="montant">Montant</label>
                    <input type="number" name="montant" id="montant" min="1" step="0.01" required>
                </div>

                <div class="mm-field">
                    <label for="type_operation">Type d'opération</label>
                    <select name="type_operation" id="type_operation">
                        <?php foreach (($types ?? []) as $type): ?>
                            <option value="<?= $type['id'] ?>"><?= $type['libelle'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mm-field">
                    <h5>Envoie à un simple destinataire:</h5>
                    <label for="client_destination">Compte destinataire</label>
                    <input type="text" name="compte_destination" id="client_destination" disabled>
                </div>
                
                <div class="mm-field" id="destination-field"></div>
                
                <button type="button" id="btn-add">+</button>

                <div id="frais-container"></div>

                <div id="montant-a-payer"></div>

                <div class="mm-inline-actions">
                    <button class="mm-btn" id="btn-submit" type="submit">Effectuer la transaction</button>
                </div>
            </form>
        </div>
    </section>

<?= $this->endSection() ?>