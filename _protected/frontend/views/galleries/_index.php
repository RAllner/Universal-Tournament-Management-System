<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Galleries';
$imageInfos = $model->ImageInfos;
?>

<div class="col-lg-12 well bs-component">
    <h3>
        <?= Html::encode($model->title)?>
    </h3>
        <span class="pull-right">
       <?php echo "<div class='".CssHelper::generalCategoryCss($model->categoryName)."'>".$model->categoryName."</div>"; ?>
    </span>
    <p class="time">
        <i class="material-icons">photo_library</i> <?php echo $model->ImageCount;?>
        <i class="material-icons">account_circle</i> <?= Yii::t('app','Author').' '.$model->authorName ?>
        <i class="material-icons">schedule</i> <?= Yii::t('app','Published on').' '.date('F j, Y, g:i a', $model->created_at) ?>
        <a href=<?= Url::to(['galleries/view', 'id' => $model->id]) ?>>
            <i class="material-icons">chevron_right</i><?= yii::t('app', 'Details'); ?>
        </a>
    </p>


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