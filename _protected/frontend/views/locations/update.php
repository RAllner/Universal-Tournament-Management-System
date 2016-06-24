<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Locations */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Locations',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="locations-update">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
            <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-warning']) ?>

        </span>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
