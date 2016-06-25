<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Videos';
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 well bs-component">

    <span class="pull-right">
        <h4>
            <span class="label label-default <?= CssHelper::generalCategoryCss($model->categoryName)?>"><?php echo $model->categoryName ?></span>
        </h4>
    </span>
    <h3>
       <?= $model->title ?>

    </h3>

    <p class="time">
        <i class="material-icons">account_circle</i> <?= Yii::t('app','Author').' '.$model->authorName ?>
        <i class="material-icons">schedule</i> <?= Yii::t('app','Published on').' '.date('F j, Y, g:i a', $model->created_at) ?>
    </p>
    <div class="clearfix"></div>
<p>
    <div class="embed-responsive embed-responsive-16by9">
    <iframe class="embed-responsive-item" src="<?= $model->url ?>"></iframe>
    </div>
   </p>

</div>
