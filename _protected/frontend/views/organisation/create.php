<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Organisation */

$this->title = Yii::t('app', 'Create Organisation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organisations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
