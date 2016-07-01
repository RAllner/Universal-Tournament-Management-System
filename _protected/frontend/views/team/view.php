<?php

use frontend\models\Player;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\models\Team */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>
<div class="team-view">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?php if (Yii::$app->user->can('updatePlayer', ['model' => $model])|| $model->isUsersPlayerAdmin()): ?>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php endif ?>
            <?php if (Yii::$app->user->can('deletePlayer', ['model' => $model])): ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this Organisation?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="well">
        <div class="media">
            <div class="media-left">
                    <img class="media-object" style="width:150px" src="<?= $photoInfo['url'] ?>"
                         alt="<?= $model->name ?>">
            </div>
            <div class="media-body media-middle">
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Owner') . ' ' . $model->authorName ?>
                            <i class="material-icons">schedule</i> <?= Yii::t('app', 'Created on') . ' ' . date('F j, Y, g:i a', $model->created_at) ?>
                        </p>
                        <p><i class="material-icons">link</i> <?= $model->website ?> </p>
                        <p>
                            <?= $model->description ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <table class="col-md-12">
                            <thead>
                            <tr>
                                <th>
                                    <?= Yii::t('app', 'Player') ?>
                                </th>
                                <th>
                                    <?= Yii::t('app', 'Joined') ?>
                                </th>
                                <th>
                                    <?= Yii::t('app', 'Admin') ?>
                                </th>
                                <?php if (Yii::$app->user->can('updateOrganisation', ['model' => $model]) || $model->isUsersPlayerAdmin()): ?>
                                    <th>
                                        <i class="material-icons">remove</i>
                                    </th>
                                <?php endif ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $isOwner = Yii::$app->user->can('updatePlayer', ['model' => $model]);
                            $isAdmin = $model->isUsersPlayerAdmin();
                            foreach ($model->teamMembers as $member) {
                                $player = Player::find()->where(['id' => $member->player_id])->one();
                                $admin = '';
                                if ($member->admin == 1 || $model->user_id == $player->user_id) {
                                    if ($isAdmin || $isOwner) {
                                        $admin = Yii::t('app', 'Yes'). Html::a(' <i class="material-icons">do_not_disturb</i>', Url::to(['set-member-admin', 'id' => $model->id, 'memberID' => $member->player_id , 'set' => 0]));
                                    }else {
                                        $admin = Yii::t('app', 'Yes');
                                    }

                                } else {
                                    if ($isAdmin || $isOwner) {
                                    $admin = Html::a(' <i class="material-icons">done</i>', Url::to(['set-member-admin', 'id' => $model->id, 'memberID' => $member->player_id , 'set' => 1]));
                                    }
                                }
                                echo '<tr>';
                                echo "<td>" . Html::a($player->name, Url::to(['player/view', 'id' =>$player->id]));
                                echo "</td><td>" . date('d.m.Y', $model->created_at). "</td><td>" . $admin . "</td>";
                                if ($isOwner || $isAdmin){
                                    echo '<td>' . Html::a('<i class="material-icons">remove</i>', Url::to(['remove-member', 'id' => $model->id, 'memberID' => $member->player_id])) . '</td>';
                                }
                                echo '</tr>';
                            }; ?>
                            </tbody>
                        </table>
                        <?php if (Yii::$app->user->can('updatePlayer', ['model' => $model])|| $isAdmin): ?>
                            <div class="pull-right">
                                <?= Html::a(Yii::t('app', 'Add Member'), Url::to(['team/add', 'id' => $model->id]), ['class' => 'btn btn-success']) ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
