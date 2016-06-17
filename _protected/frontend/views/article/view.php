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

    <h2>
        <?= $model->title ?>
        <div class="pull-right">

            <?= Html::a(Yii::t('app', 'Back'), ['index', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
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
            <?php if (Yii::$app->user->can('adminArticle')): ?>

                <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-warning']) ?>

            <?php endif ?>
        </div>
    </h2>


    <div class="clearfix"></div>
    <div class="col-lg-8 well bs-component">


    <span class="pull-right">
       <?php echo "<div class='" . CssHelper::generalCategoryCss($model->categoryName) . "'>" . $model->categoryName . "</div>"; ?>
    </span>
        <p class="time">
            <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
            <i class="material-icons">schedule</i> <?= Yii::t('app', 'Published on') . ' ' . date('F j, Y, g:i a', $model->created_at) ?>
        </p>


        <figure style="text-align: center">
            <?= Html::a($photo, $photoInfo['url'], $options) ?>
        </figure>
        <br>
        <p><?= $model->summary ?></p>
        <p><?= $model->content ?></p>
    </div>


    </div>
</div>
