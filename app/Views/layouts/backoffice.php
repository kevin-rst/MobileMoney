<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> </title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile-money.css') ?>">
    <script defer src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</head>
<body class="mm-app mm-backoffice">
    <div class="mm-shell">
        <header class="mm-topbar">
            <div class="container-fluid mm-topbar__inner px-3 px-lg-4">
                <a class="mm-brand" href="<?= site_url('/backoffice') ?>">
                    <span class="mm-brand__mark">MM</span>
                    <span class="mm-brand__text">
                        <small>Administration</small>
                        Mobile Money
                    </span>
                </a>

                <nav class="mm-nav" aria-label="Navigation back-office">
                    <a class="mm-nav__primary" href="<?= site_url('/backoffice') ?>">Accueil</a>
                    <a href="<?= site_url('/prefixes') ?>">Préfixes</a>
                    <a href="<?= site_url('/frais') ?>">Frais</a>
                    <a href="<?= site_url('/commissions') ?>">Commissions</a>
                    <a href="<?= site_url('/statistiques/clients/solde') ?>">Soldes</a>
                    <a href="<?= site_url('/statistiques/operateurs/gain') ?>">Gains</a>
                    <a href="<?= site_url('/statistiques/operateurs/montant') ?>">Montants</a>
                    <form action="<?= site_url('/logout') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit">Se déconnecter</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="container-fluid mm-page px-3 px-lg-4">
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
            <br>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>
</html>