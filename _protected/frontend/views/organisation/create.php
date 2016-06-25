<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Organisation */

$this->title = Yii::t('app', 'Create Organisation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organisations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisation-create">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
           <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>

        </span>
    </h1>
    <div class="clearfix"></div>
    <div class="col-lg-8 well bs-component">

        <?= $this->render('_form', ['model' => $model]) ?>

    </div>

</div>
