<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\PdfAsset;
use yii\bootstrap4\Html;

PdfAsset::register($this);

$this->title = "Controllerdan keluvchi title"
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

    </head>
    <body>
    <?php $this->beginBody() ?>




            <?= $content ?>



    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
