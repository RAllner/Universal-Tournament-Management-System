<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tournaments */

$this->title = Yii::t('app', 'Create Tournaments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournaments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
