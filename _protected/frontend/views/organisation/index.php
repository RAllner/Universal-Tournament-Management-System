<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrganisationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Organisations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisation-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?php if (Yii::$app->user->can('createOrganisation')): ?>
            <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Organisation'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('adminOrganisation')): ?>
            <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>
        <?php endif ?>
            </span>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="well">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>

    <?= ListView::widget([
        'summary' => false,
        'dataProvider' => $dataProvider,
        'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">'.Yii::t('app', 'We haven\'t created any articles yet.').'</div></div></div>',
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_index', ['model' => $model]);
        },
    ]) ?>

</div>
