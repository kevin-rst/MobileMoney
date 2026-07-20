<?= $this->extend('layouts/frontoffice') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>

    <section class="mm-hero">
        <div class="mm-kicker">Espace client</div>
        <h1>Bienvenue dans votre portefeuille Mobile Money</h1>
        <p>Consultez votre solde, envoyez de l'argent et suivez vos opérations dans une interface pensée pour la rapidité et la lisibilité.</p>

        <div class="mm-stats">
            <div class="mm-stat">
                <strong>Solde</strong>
                <span class="mm-muted">Accès direct à votre compte</span>
            </div>
            <div class="mm-stat">
                <strong>Transactions</strong>
                <span class="mm-muted">Envoi et réception simplifiés</span>
            </div>
            <div class="mm-stat">
                <strong>Historique</strong>
                <span class="mm-muted">Suivi des mouvements récents</span>
            </div>
        </div>
    </section>

    <div class="mm-grid mt-4">
        <a class="mm-card-link" href="<?= base_url('client/solde/' . (session()->get('client_id') ?? '1') ) ?>">
            <span class="mm-badge mm-badge--primary">Solde</span>
            <span class="mm-card-link__title">Voir mon solde</span>
            <span class="mm-card-link__desc">Consultez immédiatement le montant disponible sur votre compte.</span>
        </a>

        <a class="mm-card-link" href="<?= base_url('client/operations') ?>">
            <span class="mm-badge mm-badge--secondary">Transaction</span>
            <span class="mm-card-link__title">Réaliser une transaction</span>
            <span class="mm-card-link__desc">Effectuez un transfert ou une opération de manière fluide.</span>
        </a>
    </div>

<?= $this->endSection() ?>
