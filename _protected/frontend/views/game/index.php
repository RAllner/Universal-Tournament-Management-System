<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Games');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?php if (Yii::$app->user->can('createArticle')): ?>
            <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Game'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('adminArticle')): ?>
            <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>
        <?php endif ?>
            </span>
    </h1>
    <div class="row">
        <div class="col-lg-8">
            <div class="well">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-8">
            <div class="well">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
