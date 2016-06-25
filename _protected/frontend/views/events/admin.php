<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HalloffameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-admin">


    <h1>    <?= 'Admin ' . Yii::t('app', 'Events') ?>
        <span class="pull-right">
                <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Event'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-primary']) ?>
    </span>

    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="well bs-component">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary' => false,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],


                        [
                            'attribute' => 'user_id',
                            'value' => function ($data) {
                                return $data->getAuthorName();
                            },
                        ],
                        'name',
                        [
                            'attribute' => 'type',
                            'filter' => $searchModel->typeList,
                            'value' => function ($data) {
                                return $data->getTypeName($data->type);
                            },
                            'contentOptions' => function ($model, $key, $index, $column) {
                                return ['class' => CssHelper::generalStatusCss($model->statusName)];
                            }
                        ],

                        [
                            'attribute' => 'status',
                            'filter' => $searchModel->statusList,
                            'value' => function ($data) {
                                return $data->getStatusName($data->status);
                            },
                            'contentOptions' => function ($model, $key, $index, $column) {
                                return ['class' => CssHelper::generalStatusCss($model->statusName)];
                            }
                        ],
                        [
                            'attribute' => 'category',
                            'filter' => $searchModel->categoryList,
                            'value' => function ($data) {
                                return $data->getCategoryName($data->category);
                            },
                            'contentOptions' => function ($model, $key, $index, $column) {
                                return ['class' => CssHelper::generalCategoryCss($model->categoryName)];
                            }
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                            'header' => Yii::t('app', 'Menu')],
                    ],
                ]); ?>

            </div>
        </div>
    </div>

</div>
</div>