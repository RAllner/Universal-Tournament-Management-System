<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */

$this->title = $model->playername;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hall of Fame Member'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%', 'object-fit' => 'cover']);
$options = ['data-lightbox' => 'profile-image', 'data-title' => $photoInfo['alt']];
?>

<div class="article-view">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">

            <?php if (Yii::$app->user->can('updateArticle', ['model' => $model])): ?>

                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?php endif ?>

            <?php if (Yii::$app->user->can('deleteArticle')): ?>

                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this member?'),
                        'method' => 'post',
                    ],
                ]) ?>

            <?php endif ?>
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>

    </h1>
    <div class="row">
        <div class="col-lg-6 well bs-component">

            <figure style="text-align: center">
                <?= Html::a($photo, $photoInfo['url'], $options) ?>
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
                    'playername',
                    'achievements',
                    'description:html',
                    [
                        'label' => Yii::t('app', 'Category'),
                        'value' => $model->categoryName,
                    ],
                    'created_at:dateTime',
                ],
            ]) ?>
        </div>
    </div>
</div>
