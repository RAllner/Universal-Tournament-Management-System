<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Videos */

$this->title = Yii::t('app', 'Add Videos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videos-create">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
                <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
         </span>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-8 well bs-component">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
