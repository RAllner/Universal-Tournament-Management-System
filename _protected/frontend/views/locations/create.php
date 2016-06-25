<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Locations */

$this->title = Yii::t('app', 'Create Locations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locations-create">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>

        </span>
    </h1>
    <div class="row">
        <div class="col-lg-8">
            <div class="well bs-component">


                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>

        </div>
    </div>
</div>
