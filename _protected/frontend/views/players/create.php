<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Players */

$this->title = Yii::t('app', 'Create Player');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Players'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="players-create">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">
                <?= Html::a(Yii::t('app', 'Back'), ['own-index'], ['class' => 'btn btn-warning']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>

    <div class="col-lg-4 well bs-component">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
    
</div>
