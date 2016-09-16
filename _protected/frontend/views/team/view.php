<?php

use common\helpers\CssHelper;
use frontend\models\Player;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\models\Team */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%', 'class' => 'media-object']);
$options = ['data-lightbox' => 'team-image', 'data-title' => $photoInfo['alt']];
$participants = \frontend\models\Participant::find()
    ->where(['team_id' => $model->id])
    ->all();
?>
<div class="team-view">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?php if (Yii::$app->user->can('updatePlayer', ['model' => $model]) || $model->isUsersPlayerAdmin()): ?>
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

    <div class="row">
        <div class="col-md-2">
            <figure style="text-align: center">
                <?= Html::a($photo, $photoInfo['url'], $options) ?>
            </figure>
        </div>
        <div class="col-md-10">
            <div class="row">

                <ul class="nav nav-tabs" role="tablist">
                    <li role="player-profile-nav" class="active"><a href="#information" aria-controls="information"
                                                                    role="tab"
                                                                    data-toggle="tab"><?= Yii::t('app', 'Information') ?></a>
                    </li>
                    <li role="player-profile-nav"><a href="#member" aria-controls="member" role="tab"
                                                     data-toggle="tab"><?= Yii::t('app', 'Member') ?></a></li>
                    <li role="player-profile-nav"><a href="#tournaments" aria-controls="tournaments" role="tab"
                                                     data-toggle="tab"><?= Yii::t('app', 'Tournaments') ?></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active fade in" id="information">
                        <div class="well">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><?= Yii::t('app', 'Information') ?></div>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Members') . ": " . count($model->teamMembers) ?>
                                            </li>
                                            <li class="list-group-item">
                                                <i class="material-icons">schedule</i> <?= Yii::t('app', 'Created on') . ' ' . date('F j, Y, g:i a', $model->created_at) ?>
                                            </li>
                                            <li class="list-group-item">
                                                <p>
                                                    <i class="material-icons">link</i> <?= Yii::t('app', 'Website') . ': ' . $model->website ?>
                                                </p>
                                            </li>
                                        </ul>
                                        <div class="panel-body">
                                            <b><?= Yii::t('app', 'Description') ?>:</b>
                                            <?= $model->description ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
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
                                                    $admin = Yii::t('app', 'Yes') . Html::a(' <i class="material-icons">do_not_disturb</i>', Url::to(['set-member-admin', 'id' => $model->id, 'memberID' => $member->player_id, 'set' => 0]));
                                                } else {
                                                    $admin = Yii::t('app', 'Yes');
                                                }

                                            } else {
                                                if ($isAdmin || $isOwner) {
                                                    $admin = Html::a(' <i class="material-icons">done</i>', Url::to(['set-member-admin', 'id' => $model->id, 'memberID' => $member->player_id, 'set' => 1]));
                                                }
                                            }
                                            echo '<tr>';
                                            echo "<td>" . Html::a($player->name, Url::to(['player/view', 'id' => $player->id]));
                                            echo "</td><td>" . date('d.m.Y', $member->created_at) . "</td><td>" . $admin . "</td>";
                                            if ($isOwner || $isAdmin) {
                                                echo '<td>' . Html::a('<i class="material-icons">remove</i>', Url::to(['remove-member', 'id' => $model->id, 'memberID' => $member->player_id])) . '</td>';
                                            }
                                            echo '</tr>';
                                        }; ?>
                                        </tbody>
                                    </table>
                                    <?php if (Yii::$app->user->can('updatePlayer', ['model' => $model]) || $isAdmin): ?>
                                        <div class="pull-right">
                                            <?= Html::a(Yii::t('app', 'Add Member'), Url::to(['team/add', 'id' => $model->id]), ['class' => 'btn btn-success']) ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="member" style="background: #181818">

                        <div class="row">
                            <?php
                            foreach ($model->teamMembers as $member) {
                            /** @var Player $player */
                            $player = Player::find()->where(['id' => $member->player_id])->one();
                            $photoInfo = $player->PhotoInfo;
                            $photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'style:' => 'width: 150px; height: 150px', 'class' => 'media-object']);
                            $options = ['data-lightbox' => 'news-image', 'data-title' => $photoInfo['alt']];
                            ?>
                            <div class="col-lg-3">
                                <a href="<?= Url::to(['player/view', 'id' => $player->id]) ?>">
                                    <div class="team-image-wrap"
                                         style="background-image: url('<?= $photoInfo['url'] ?>')">
                                        <div class="intro-Text-wrap-team">
                                            <p class="teammembertitle" itemprop="headline"><?= $player->name ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3">
                                <a href="<?= Url::to(['player/view', 'id' => $player->id]) ?>">
                                    <div class="team-image-wrap"
                                         style="background-image: url('<?= $photoInfo['url'] ?>')">
                                        <div class="intro-Text-wrap-team">
                                            <p class="teammembertitle" itemprop="headline"><?= $player->name ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3">
                                <a href="<?= Url::to(['player/view', 'id' => $player->id]) ?>">
                                    <div class="team-image-wrap"
                                         style="background-image: url('<?= $photoInfo['url'] ?>')">
                                        <div class="intro-Text-wrap-team">
                                            <p class="teammembertitle" itemprop="headline"><?= $player->name ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3">
                                <a href="<?= Url::to(['player/view', 'id' => $player->id]) ?>">
                                    <div class="team-image-wrap"
                                         style="background-image: url('<?= $photoInfo['url'] ?>')">
                                        <div class="intro-Text-wrap-team">
                                            <p class="teammembertitle" itemprop="headline"><?= $player->name ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3">
                                <a href="<?= Url::to(['player/view', 'id' => $player->id]) ?>">
                                    <div class="team-image-wrap"
                                         style="background-image: url('<?= $photoInfo['url'] ?>')">
                                        <div class="intro-Text-wrap-team">
                                            <p class="teammembertitle" itemprop="headline"><?= $player->name ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tournaments">
                    <table class="centered col-xs-12">
                        <tr>
                            <th> <?= Yii::t('app', 'Tournament') ?> </th>
                            <th> <?= Yii::t('app', 'Date') ?> </th>
                            <th> <?= Yii::t('app', 'Rank') ?> </th>
                            <th> <?= Yii::t('app', 'Game History') ?> </th>
                        </tr>

                        <?php
                        /** @var \frontend\models\Participant $participant */
                        foreach ($participants as $participant) {
                            /**  @var \frontend\models\Tournament $tournament */

                            $rankArray = explode(',', $participant->history);
                            $rankString = "";
                            foreach ($rankArray as $rank) {
                                if ($rank == "l") {
                                    $rankString = $rankString . "<div class='achieved-match-loss'>l</div>";
                                } else if ($rank == "w") {
                                    $rankString = $rankString . "<div class='achieved-match-win'>w</div>";
                                }
                            }
                            $tournament = \frontend\models\Tournament::find()->where(['id' => $participant->tournament_id])->one()
                            ?>
                            <tr>
                                <td> <?= $tournament->name ?></td>
                                <td> <?= $tournament->begin ?></td>
                                <td> <?= $participant->rank ?></td>
                                <td> <?= $rankString ?></td>
                            </tr>
                        <?php } ?>

                    </table>


                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>
</div>
