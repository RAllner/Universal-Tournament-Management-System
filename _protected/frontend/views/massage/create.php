<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Massage */

$this->title = Yii::t('app', 'Create Massage');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Massages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="massage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
