<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Galleries */

$this->title = Yii::t('app', 'Update Gallery') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="galleries-update">

    <h1><?= Html::encode($this->title) ?>
    <span class="pull-right">
        <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
    </span>
    </h1>
    <div class="clearfix"></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
