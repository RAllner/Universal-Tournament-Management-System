<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Hall Of Fame';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'],['alt' =>$photoInfo['alt']]);
$options = ['data-lightbox'=>'news-image','data-title'=>$photoInfo['alt']];
?>


    <h3>
       <?= $model->title ?>

    </h3>
    <span class="pull-right">
       <?php echo "<div class='".CssHelper::generalCategoryCss($model->categoryName)."'>".$model->categoryName."</div>"; ?>
    </span>
    <p class="time">
        <i class="material-icons">schedule</i> <?= Yii::t('app','Published on').' '.date('F j, Y, g:i a', $model->created_at) ?>
            <a href=<?= Url::to(['article/view', 'id' => $model->id]) ?>>
                <i class="material-icons">chevron_right</i><?= yii::t('app', 'Details'); ?>
            </a>
    </p>



    <figure style="text-align: center">
        <?= Html::a($photo, $photoInfo['url'],$options)?>
    </figure>
    <br>
    <p><?= $model->summary ?></p>
    <p><?= $model->content ?></p>


