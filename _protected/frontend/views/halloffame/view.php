<?php
use common\helpers\CssHelper;
use yii\helpers\Html;
use yii\helpers\Url;
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
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">

                <div class="hof-image-wrap" style="background-image: url('<?= $photoInfo['url'] ?>')">
                    <div class="intro-Text-wrap">
                <span class="article-Category">
                <?php echo "<div class='" . CssHelper::generalCategoryCss($model->categoryName) . "'>" . $model->categoryName . "</div>"; ?>
                </span>
                            <h1 class="articleTitle" itemprop="headline"><?= $model->playername ?></h1>
                        </a>

                    </div>
                </div>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">
            <div class="well">
            <p class="introText" itemprop="description">
                <i class="material-icons">schedule</i> <?= date('d.m.Y, G:i', $model->created_at) . ' ' . Yii::t('app', 'o\' clock') ?></br>
                <i class="material-icons">flag</i> <?= Yii::t('app', 'Achievements') ?>: <?= $model->achievements ?>
            </p>
            <p>
                <?= $model->description ?>
            </p>
        </div>
        </div>
    </div>
</div>
