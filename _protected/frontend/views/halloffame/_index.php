<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
/* @var $model \frontend\models\Halloffame */
$this->title = 'Hall Of Fame';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'style:' => 'height: 150px', 'class' => 'media-object']);
$options = ['data-lightbox' => 'news-image', 'data-title' => $photoInfo['alt']];
?>

<div class=" col-xs-12 col-sm-5 col-md-4 col-lg-3">

    <div class="hof-image-wrap" style="background-image: url('<?= $photoInfo['url'] ?>')">
        <div class="intro-Text-wrap">
                <span class="article-Category">
                <?php echo "<div class='" . CssHelper::generalCategoryCss($model->categoryName) . "'>" . $model->categoryName . "</div>"; ?>
                </span>
            <a href="<?= Url::to(['view', 'id' => $model->id]) ?>">
                <h1 class="articleTitle" itemprop="headline"><?= $model->playername ?></h1>
            </a>
            <p class="introText" itemprop="description">
                <small><i class="material-icons">flag</i> <?= $model->achievements ?></small>
            </p>
        </div>
    </div>
    </br>
</div>