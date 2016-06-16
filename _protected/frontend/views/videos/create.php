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
                <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-warning']) ?>
         </span>
    </h1>
    <div class="clearfix"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
