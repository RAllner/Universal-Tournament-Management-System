<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Videos';
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well bs-component">
    <h3>
       <?= $model->title ?>

    </h3>
    <span class="pull-right">
       <?php echo "<div class='".CssHelper::generalCategoryCss($model->categoryName)."'>".$model->categoryName."</div>"; ?>
    </span>
    <p class="time">
        <i class="material-icons">account_circle</i> <?= Yii::t('app','Author').' '.$model->authorName ?>
        <i class="material-icons">schedule</i> <?= Yii::t('app','Published on').' '.date('F j, Y, g:i a', $model->created_at) ?>
            <a href=<?= Url::to(['videos/view', 'id' => $model->id]) ?>>
                <i class="material-icons">chevron_right</i><?= yii::t('app', 'Details'); ?>
            </a>
    </p>




    <br>
<p>
    <iframe class="spot-light-video" height="500px" frameborder="0" allowfullscreen="" src="<?= $model->url ?>"></iframe>
   </p>

</div>
