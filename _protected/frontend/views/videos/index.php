<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VideosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', Yii::$app->name) .' '. Yii::t('app', 'videos');
$this->params['breadcrumbs'][] = Yii::t('app', 'Videos');
?>
<div class="videos-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
            <?php if (Yii::$app->user->can('adminArticle')): ?>

                <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>

            <?php endif ?>
        </span>
    </h1>
    </br>

    <?= ListView::widget([
        'summary' => false,
        'dataProvider' => $dataProvider,
        'emptyText' => Yii::t('app', 'We haven\'t added any Videos yet.'),
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_index', ['model' => $model]);
        },
    ]) ?>

</div>