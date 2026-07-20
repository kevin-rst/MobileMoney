<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> </title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile-money.css') ?>">
    <script defer src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/transaction-details.js') ?>"></script>
</head>
<body class="mm-app mm-frontoffice">
    <div class="mm-shell">
        <header class="mm-topbar">
            <div class="container mm-topbar__inner">
                <a class="mm-brand" href="<?= site_url('/dashboard') ?>">
                    <span class="mm-brand__mark">MM</span>
                    <span class="mm-brand__text">
                        <small>Mobile Money</small>
                        Espace client
                    </span>
                </a>

                <nav class="mm-nav" aria-label="Navigation principale">
                    <a class="mm-nav__primary" href="<?= site_url('/dashboard') ?>">Tableau de bord</a>
                    <a href="<?= base_url('client/solde/' . (session()->get('client_id') ?? '1') ) ?>">Mon solde</a>
                    <a href="<?= base_url('client/operations') ?>">Transaction</a>
                    <form action="<?= site_url('/logout') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit">Se déconnecter</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="container mm-page">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="mm-alert mm-alert--success">
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="mm-alert mm-alert--danger">
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>
</html>