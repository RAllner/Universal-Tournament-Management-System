<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Galleries';
$imageInfos = $model->ImageInfos;
?>

<div class="col-lg-12">
    <div class="well">
        <span class="pull-right">
        <h4>
            <span class="label label-default <?= CssHelper::generalCategoryCss($model->categoryName)?>"><?php echo $model->categoryName ?></span>
        </h4>
    </span>
    <h2>
        <?= Html::encode($model->title)?>
    </h2>

    <p class="time">
        <i class="material-icons">photo_library</i> <?php echo $model->ImageCount;?>
        <i class="material-icons">account_circle</i> <?= Yii::t('app','Author').' '.$model->authorName ?>
        <i class="material-icons">schedule</i> <?= Yii::t('app','Published on').' '. date('d.m.Y, G:i', $model->created_at). ' '.Yii::t('app','o\' clock') ?>
        <a href=<?= Url::to(['galleries/view', 'id' => $model->id]) ?>>
            <i class="material-icons">chevron_right</i><?= yii::t('app', 'Details'); ?>
        </a>
    </p>
    <div class="clearfix"></div>

    <?php
        if ($model->ImageCount != 0) {
            $fotorama = \metalguardian\fotorama\Fotorama::begin(
                [
                    'options' => [
                        'loop' => true,
                        'hash' => true,
                        'width' => '100%',
                        'height' => '80%',
                        'nav' => 'thumbs',
                        'data-ratio' => '800/600',
                        'allowfullscreen' => true
                    ],
                    'spinner' => [
                        'lines' => 20,
                    ],
                    'tagName' => 'span',
                    'useHtmlData' => false,

                    'htmlOptions' => [
                        'class' => $model->id,
                        'id' => $model->id,
                    ],
                ]
            );

            for ($i = 0; $i < $model->ImageCount; $i++) {
                echo "<a href='" . $imageInfos['imageUrls'][$i] . "'><img src='" . $imageInfos['thumbsUrls'][$i] . "'></a>";
            }

            $fotorama->end();
        }
    ?>
    </div>
</div>