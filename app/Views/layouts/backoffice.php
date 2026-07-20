<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> </title>
</head>
<body>
    <nav>
        <a href="<?= site_url('/backoffice') ?>">Home</a>
        <a href="<?= site_url('/prefixes') ?>">Préfixes</a>
        <a href="<?= site_url('/frais') ?>">Frais</a>
        <a href="<?= site_url('/statistiques/clients/solde') ?>">Comptes des clients</a>
        <a href="<?= site_url('/statistiques/operateurs/gain') ?>">Gain des opérateurs</a>
        <div>
            <form action="<?= site_url('/logout') ?>" method="post">
                <button type="submit">Se déconnecter</button>
            </form>
        </div>
    </nav>

    <?php if (session()->getFlashdata('success')) : ?>
        <div>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    
    <div>
        <?=  $this->renderSection('content') ?>
    </div>
</body>
</html>