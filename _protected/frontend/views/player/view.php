<?php

use common\models\User;
use frontend\models\TeamMember;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Player */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Player'), 'url' => ['own-index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'style' => 'width:100%']);
$options = ['data-lightbox' => 'profile-image', 'data-title' => $photoInfo['alt']];
?>
<div class="player-view">

    <h1><?= Html::encode($this->title). '#'.$model->running_nr ?>
        <div class="pull-right">
            <?php if (Yii::$app->user->can('updatePlayer', ['model' => $model])): ?>

                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?php endif ?>

            <?php if (Yii::$app->user->can('deletePlayer', ['model' => $model])): ?>

                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this article?'),
                        'method' => 'post',
                    ],
                ]) ?>

            <?php endif ?>
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['own-index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="row">
    <div class="col-lg-5 ">
        <figure style="text-align: center">
            <?= Html::a($photo, $photoInfo['url'], $options) ?>
        </figure>
    <div class="well bs-component">

        <p class="time">
            <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Owner ') . ' '. $model->user->username ?>
            <i class="material-icons">schedule</i> <?= Yii::t('app', 'Entered ') . ' ' . date('d.m.Y', $model->created_at) ?>
        </p>
        <h3>Teams</h3>
        <?php
            foreach ($model->teams as $team){
                $teamPhotoInfo = $team->PhotoInfo;
                $teamphoto = Html::img($teamPhotoInfo['url'], ['alt' => $teamPhotoInfo['alt'], 'style' => 'width:30px; margin: 5px']);
                $member = $model->getTeamMemberFrom($team->id);
                echo $teamphoto;
                echo Html::a($team->name, Url::to(['team/view', 'id' => $team->id])).' - '.Yii::t('app','Joined').' '. date('d.m.Y',$member->created_at).'</br>';
        }
        ?>

    </div>
    </div>
    </div>
</div>
