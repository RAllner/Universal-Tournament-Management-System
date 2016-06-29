<?php
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HalloffameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', Yii::$app->name) . ' ' . Yii::t('app', 'Hall Of Fame');
$this->params['breadcrumbs'][] = Yii::t('app', 'Hall Of Fame');
?>

<div class="halloffame-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">

                    <?php if (Yii::$app->user->can('createArticle')): ?>
                        <?= Html::a('<i class="material-icons">create</i> '.Yii::t('app', 'Create HOF Member'), ['create'], ['class' => 'btn btn-success'])?>
                    <?php endif ?>
                    <?php if (Yii::$app->user->can('adminArticle')): ?>

                        <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>

                    <?php endif ?>
            </span>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
    <?= ListView::widget([
        'summary' => false,
        'dataProvider' => $dataProvider,
        'emptyText' => Yii::t('app', 'We haven\'t added any Hall of fame Members yet.'),
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_index', ['model' => $model]);
        },
    ]) ?>
    </div>
</div>

