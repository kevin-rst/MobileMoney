<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
</head>
<body>
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
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>