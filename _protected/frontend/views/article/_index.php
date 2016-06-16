<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Articles';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>

<div class="col-lg-12 well bs-component">

    <h3>
        <a href=<?= Url::to(['article/view', 'id' => $model->id]) ?>>
            <?= $model->title ?>
        </a>


    </h3>
    <span class="pull-right">
       <?php echo "<div class='" . CssHelper::generalCategoryCss($model->categoryName) . "'>" . $model->categoryName . "</div>"; ?>
    </span>
    <p class="time">
        <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
        <i class="material-icons">schedule</i> <?= Yii::t('app', 'Published on') . ' ' . date('F j, Y, g:i a', $model->created_at) ?>
    </p>


    <figure style="text-align: center">
        <?= Html::a($photo, Url::to(['article/view', 'id' => $model->id]), $options) ?>
    </figure>

    <p><?= $model->summary ?></p>
        <span class="pull-right">
    <a class="btn btn-primary" href=<?= Url::to(['article/view', 'id' => $model->id]) ?>>
        <?= yii::t('app', 'Read more'); ?><i class="material-icons">chevron_right</i>
    </a>
            </span>
    <div class="clearfix"></div>
</div>


