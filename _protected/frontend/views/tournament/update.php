<?php

use frontend\models\Tournament;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tournament */

$this->title = $model->name . " ". Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Settings');
?>
<div class="tournament-update">

    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Tournaments'), ['index'], ['class' => 'btn btn-warning']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12">
            <?php echo $this->render('nav', ['model' => $model, 'active' => Tournament::ACTIVE_SETTINGS]); ?>
        </div>
    </div>
    <div class="row" style="padding-top: 1em">
        <div class="col-xs-12">

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
        </div>
    </div>
</div>
