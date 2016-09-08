<?php
use common\helpers\CssHelper;
use frontend\models\Tournament;
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Tournament */

$this->title = 'Tournaments';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>

<div class="col-lg-12 well tournament">

    <a href="<?= Url::to(['tournament/view', 'id' => $model->id]) ?>">
        <div class="media tournament">
            <div class="media-left">
                <a href="<?= Url::to(['tournament/view', 'id' => $model->id]) ?>">
                    <img class="media-object img-circle" style="width:70px" src="<?= $photoInfo['url'] ?>"
                         alt="<?= $model->name ?>">
                </a>
            </div>
            <div class="media-body media-middle">
                <div class="pull-right">

                    <i class="material-icons">schedule</i> <?= $model->begin . ' ' . Yii::t('app', 'o\' clock') ?>
                    </br>
                    <?= '<div class='.CssHelper::tournamentStatusCss($model->statusName).">".$model->getStatusName($model->status).'</div>';?>
                </div>
                <h3 class="media-heading">
                    <a href="<?= Url::to(['tournament/view', 'id' => $model->id]) ?>">
                        <?= $model->name ?>
                    </a>

                </h3>
                <p class="tournament-index-text">
                    <i class="material-icons">info</i>
                    <?= $model->game->name ?>:
                    <?php
                    if($model->stage_type === Tournament::STAGE_TYPE_TWO_STAGE) {
                        echo  $model->getFormatShortName($model->gs_format);
                        echo ' ('.$model->participants_compete.' <i class="material-icons">directions_run</i> ' .$model->participants_advance.') ';
                    }
                    echo $model->getFormatShortName($model->fs_format); ?>
                    </br>
                    <i class="material-icons">people</i> <?= $model->participants_count. '/'.$model->max_participants. ' '. Yii::t('app', 'participants registered') ?>
                </p>

            </div>
        </div>
    </a>
</div>



