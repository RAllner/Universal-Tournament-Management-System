<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Teams');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
                                <?php if (Yii::$app->user->can('adminPlayer')): ?>
                                    <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>
                                <?php endif ?>

            </span>
    </h1>
    <div class="clearfix"></div>
    <div class="row">

        <div class="col-lg-4 ">

            <div class="well">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if (Yii::$app->user->can('createPlayer')): ?>
        <div class="col-md-4">
            <?= Html::a('+', ['create'], ['class' => 'btn btn-success btn-block', 'style'=> 'font-size: 90px; line-height: 100px; margin: 0']) ?>
        </div>
        <?php endif ?>
    <?= ListView::widget([
        'summary' => false,
        'dataProvider' => $dataProvider,
        'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">'.Yii::t('app', 'We haven\'t created any Teams yet.').'</div></div></div>',
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_index', ['model' => $model]);
        },
    ]) ?>
    </div>
</div>
