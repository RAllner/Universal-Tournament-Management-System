<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Videos */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videos-view">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">


            <?php if (Yii::$app->user->can('updateArticle', ['model' => $model])): ?>

                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?php endif ?>

            <?php if (Yii::$app->user->can('deleteArticle')): ?>

                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this video?'),
                        'method' => 'post',
                    ],
                ]) ?>

            <?php endif ?>

            <?= Html::a(Yii::t('app', 'Back'), ['index', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>

        </div>
    </h1>
    <div class="clearfix"></div>

    <div class="well">
        <p>
            <iframe class="spot-light-video" height="500px" frameborder="0" allowfullscreen="" src="<?= $model->url ?>"></iframe>
        </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'authorName',
            'url:url',
            'title',
            'statusName',
            'categoryName',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>
    </div>


</div>
