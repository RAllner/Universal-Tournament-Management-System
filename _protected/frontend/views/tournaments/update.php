<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tournaments */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tournaments',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'idtournaments' => $model->idtournaments, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tournaments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
