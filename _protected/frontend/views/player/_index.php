<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Players';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-lightbox' => 'news-image', 'data-title' => $photoInfo['alt']];
?>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <figure style="text-align: center">
        <?= Html::a($photo, Url::to(['view', 'id' => $model->id])) ?>
    </figure>
    <div class="well bs-component">
        <h3>
            <?php if ($model->nation != 0): ?>
                <?=

                \modernkernel\flagiconcss\Flag::widget([
                    'tag' => 'span', // flag tag
                    'country' => $model->getNationShort($model->nation), // where xx is the ISO 3166-1-alpha-2 code of a country,
                    'squared' => false, // set to true if you want to have a squared version flag
                    'options' => [] // tag html options
                ]);
                ?>
            <?php endif ?>
            <?= Html::a($model->name , Url::to(['view', 'id' => $model->id])) ?>
        </h3>
        <div class="lead"></div>
        <p class="time">
            <i class="material-icons">schedule</i> <?= Yii::t('app', 'Entered ') . ' ' . date('d.m.Y', $model->created_at) ?>
        </p>
    </div>
</div>


