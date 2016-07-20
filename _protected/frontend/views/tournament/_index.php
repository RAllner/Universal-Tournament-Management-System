<?php
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Team */
$this->title = 'Tournaments';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>

<div class="col-lg-12 well">

    <a href="<?= Url::to(['tournament/view', 'id' => $model->id]) ?>">
    <div class="media">
        <div class="media-left">
            <a href="<?= Url::to(['tournament/view', 'id' => $model->id]) ?>">
                <img class="media-object" style="width:100px" src="<?= $photoInfo['url'] ?>" alt="<?= $model->name ?>">
            </a>
        </div>
        <div class="media-body media-middle">
            <h3 class="media-heading">
                <a href="<?= Url::to(['tournament/view', 'id' => $model->id]) ?>">
                    <?= $model->name ?>
                </a>
                <div class="pull-right">
                    <?= $model->game->name?>
                </div>
            </h3>
            <p>
                <i class="material-icons">schedule</i> <?= $model->begin .' '.Yii::t('app','o\' clock') ?>
                <i class="material-icons">people</i> <?= $model->participants_count ?>
            </p>
            <p><?= $model->countdown ?></p>
            <p>

            </p>
        </div>
    </div>
    </a>
</div>



