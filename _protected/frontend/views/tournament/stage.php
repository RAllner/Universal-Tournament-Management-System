<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 22.07.2016
 * Time: 12:26
 */

/* @var $this yii\web\View */
/* @var $tournament frontend\models\Tournament */
/* @var $dataProvider frontend\models\TournamentMatchSearch */
/* @var $model frontend\models\TournamentMatch */

use frontend\models\Tournament;
use yii\helpers\Html;
use yii\widgets\ListView;


$stage_name = ($model->stage_type == Tournament::STAGE_FS)? Yii::t('app', 'Bracket') : Yii::t('app', 'Final Stage');

$this->title = $tournament->name. " ".$stage_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['view', 'id' => $tournament->id]];
$this->params['breadcrumbs'][] = $stage_name;
$photoInfo = $tournament->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];

?>
<div class="tournament-stage">
    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">

            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2 col-xs-3">
            <?php echo $this->render('nav', ['model' => $tournament, 'active' => Tournament::ACTIVE_FINAL_STAGE]); ?>
            </div>
        <div class="col-md-10 col-xs-9">
            <div class="well">
                <div class="row">
                <table class="col-xs-12">
                    <tr>
                        <th><?= Yii::t('app','Match ID') ?></th>
                        <th><?= Yii::t('app','Participant A') ?></th>
                        <th><?= Yii::t('app','Points A') ?></th>
                        <th><?= Yii::t('app','Points B') ?></th>
                        <th><?= Yii::t('app','Participant B') ?></th>
                        <th><?= Yii::t('app','Round') ?></th>
                        <th><i class="material-icons">edit</i></th>
                    </tr>
                <?= ListView::widget([
                    'summary' => false,
                    'dataProvider' => $dataProvider,
                    'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'We haven\'t created any matches yet.') . '</div></div></div>',
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $this->render('_stage', ['model' => $model]);
                    },
                ]) ?>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>


