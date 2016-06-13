<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'],['alt' =>$photoInfo['alt']]);
$options = ['data-lightbox'=>'profile-image','data-title'=>$photoInfo['alt']];
?>

<div class="article-view">

    <h1><?= Html::encode($this->title) ?>

    </h1>

    <div class="col-lg-8 well bs-component">

    <figure style="text-align: center">
        <?= Html::a($photo, $photoInfo['url'],$options)?>
        <figcaption>(Click to enlarge)</figcaption>
    </figure>
    </br>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
             [
                 'label' => Yii::t('app', 'Author'),
                 'value' => $model->authorName,
             ],
            'title',
            'summary:html',
            'content:html',
            // [
            //     'label' => Yii::t('app', 'Status'),
            //     'value' => $model->statusName,
            // ],
            [
                'label' => Yii::t('app', 'Category'),
                'value' => $model->categoryName,
            ],
            'created_at:dateTime',
            //'updated_at:dateTime',
        ],
    ]) ?>
<div class="pull-right">
    <?php if (Yii::$app->user->can('adminArticle')): ?>

        <?= Html::a(Yii::t('app', 'Back'), ['admin'], ['class' => 'btn btn-warning']) ?>

    <?php endif ?>

    <?php if (Yii::$app->user->can('updateArticle', ['model' => $model])): ?>

        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <?php endif ?>

    <?php if (Yii::$app->user->can('deleteArticle')): ?>

        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this article?'),
                'method' => 'post',
            ],
        ]) ?>

    <?php endif ?>
    </div>
</div>
    </div>
