<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Players */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Players',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Players'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="players-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-8 well bs-component">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>