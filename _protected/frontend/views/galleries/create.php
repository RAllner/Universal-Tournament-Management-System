<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Galleries */

$this->title = Yii::t('app', 'Create Gallery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="galleries-create">

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
