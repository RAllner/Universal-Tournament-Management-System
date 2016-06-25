<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'style' => 'width:100%']);
$options = ['data-lightbox' => 'profile-image', 'data-title' => $photoInfo['alt']];
?>

<div class="article-view">
    <div class="col-lg-12 no-padding">
        <div class="pull-right">

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
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
        <div class="clearfix"></div>

        <div class="article-image-wrap-detail" style="background-image: url('<?= $photoInfo['url'] ?>')">
            <div class="intro-Text-wrap">
                <span class="article-Category">
                <?php echo "<div class='" . CssHelper::generalCategoryCss($model->categoryName) . "'>" . $model->categoryName . "</div>"; ?>
                </span>

                <h1 class="articleTitle" itemprop="headline"><?= $model->title ?></h1>

                <p class="introText" itemprop="description">
                    <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
                    <i class="material-icons">schedule</i> <?= Yii::t('app', 'Published on') . ' ' . date('d.m.Y, G:i', $model->created_at) ?>
                </p>
            </div>
        </div>
        <div class="col-lg-12 well bs-component">
            <div class="col-lg-10 col-lg-offset-2">

                <p><?= $model->summary ?></p>

                <p><?= $model->content ?></p>
            </div>
        </div>
    </div>


</div>
