<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mobile-money.css') ?>">
    <script defer src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</head>
<body class="mm-app mm-auth-layout">
    <main class="mm-auth">
        <div class="mm-panel mm-auth__card">
            <div class="mm-panel__body">
                <div class="mm-auth__intro">
                    <div class="mm-auth__brand">
                        <span class="mm-brand__mark">MM</span>
                        <div>
                            <div class="mm-kicker">Mobile Money</div>
                            <h1>Connexion sécurisée</h1>
                        </div>
                    </div>
                    <p class="mm-auth__meta">Accédez à votre portefeuille digital avec une interface claire, rapide et adaptée aux usages mobiles.</p>
                </div>

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

                <div class="mm-divider my-4"></div>

                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </main>
</body>
</html>