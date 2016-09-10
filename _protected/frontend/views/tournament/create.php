<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Tournament */

$this->title = Yii::t('app', 'Create Tournament');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-create">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Tournaments'), ['index'], ['class' => 'btn btn-warning']) ?>
    </span>

    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="well bs-component">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
