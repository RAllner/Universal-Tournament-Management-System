<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Conversation */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Conversation',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Conversations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="conversation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
