<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Halloffame */

$this->title = Yii::t('app', 'Create HOF Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hall Of Fame'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">
    <div class="row">
        <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
            <h1><?= Html::encode($this->title) ?>
                <span class="pull-right">

        <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>

    </span>

            </h1>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-8">
            <div class="well">
            <?= $this->render('_form', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>

