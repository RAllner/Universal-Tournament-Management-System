<?php

use common\models\User;
use frontend\models\TeamMember;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Player */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Player profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'style' => 'width:100%']);
$options = ['data-lightbox' => 'profile-image', 'data-title' => $photoInfo['alt']];
$participants = \frontend\models\Participant::find()
    ->where(['player_id' => $model->id])
    ->all();

?>
<div class="player-view">

    <h1>
        <?php if ($model->nation != 0): ?>
            <?=

            \modernkernel\flagiconcss\Flag::widget([
                'tag' => 'span', // flag tag
                'country' => $model->getNationShort($model->nation), // where xx is the ISO 3166-1-alpha-2 code of a country,
                'squared' => false, // set to true if you want to have a squared version flag
                'options' => [] // tag html options
            ]);
            ?>
        <?php endif ?>
        <?= Html::encode($this->title) ?>

        <div class="pull-right">
            <?php if (Yii::$app->user->can('updatePlayer', ['model' => $model])): ?>

                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?php endif ?>
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
            <div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="player-profile-nav" class="active"><a href="#profile" aria-controls="profile" role="tab"
                                                                    data-toggle="tab"><?= Yii::t('app', 'Profile') ?></a>
                    </li>
                    <li role="player-profile-nav"><a href="#tournaments" aria-controls="tournaments" role="tab"
                                                     data-toggle="tab"><?= Yii::t('app', 'Tournament History') ?></a></li>
                    <?php if (!is_null($model->stream)): ?>
                        <li role="player-profile-nav"><a href="#livestream" aria-controls="livestream" role="tab"
                                                         data-toggle="tab"><?= Yii::t('app', 'Live stream') ?></a>
                        </li>
                    <?php endif ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active fade in" id="profile">
                        <div class="well bs-component">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><?= Yii::t('app', 'Personal information') ?></div>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <i class="material-icons">schedule</i>
                                                <?php
                                                $string = Yii::t('app', 'Created At') . ': ' . date('d.m.Y', $model->created_at);
                                                if ($model->created_at != $model->updated_at) {
                                                    $string .= ' ' . Yii::t('app', 'Updated At') . ': ' . date('d.m.Y', $model->updated_at);
                                                }
                                                echo $string ?>
                                            </li>
                                            <li class="list-group-item">
                                                <i class="material-icons">perm_identity</i>
                                                <?= Yii::t('app', 'Gender') ?>:
                                                <?= $model->genderName ?>
                                                <?= Yii::t('app', 'Age') ?>:
                                                <?= $model->age ?>

                                            </li>

                                            <li class="list-group-item">
                                                <i class="material-icons">language</i>
                                                <?= Yii::t('app', 'Languages') . ': ' . $model->languages ?>
                                            </li>
                                            <li class="list-group-item">
                                                <i class="material-icons">link</i>
                                                <?= Yii::t('app', 'Website') ?>:
                                                <a href="<?= $model->website ?>"><?= $model->website ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <i class="material-icons">videogame_asset</i>
                                                <?= Yii::t('app', 'Games') ?>:
                                                <?= $model->games ?>
                                            </li>
                                        </ul>
                                        <div class="panel-body">

                                            <b><?= Yii::t('app', 'Description') ?>:</b>
                                            <?= $model->description ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <h3>Teams</h3>
                                    <?php
                                    if (count($model->teams) > 0) {
                                        foreach ($model->teams as $team) {
                                            $teamPhotoInfo = $team->PhotoInfo;
                                            $teamphoto = Html::img($teamPhotoInfo['url'], ['alt' => $teamPhotoInfo['alt'], 'style' => 'width:30px; margin: 5px']);
                                            $member = $model->getTeamMemberFrom($team->id);
                                            echo $teamphoto;
                                            echo Html::a($team->name, Url::to(['team/view', 'id' => $team->id])) . ' - ' . Yii::t('app', 'Joined') . ': ' . date('d.m.Y', $member->created_at) . '</br>';
                                        }
                                    } else {
                                        echo '<p>'.Yii::t('app','This individual is still not a member of a team yet.').'</p>';
                                        if(Yii::$app->user->can('updatePlayer', ['model' => $model])){
                                           echo Html::a(Yii::t('app', 'Create'), ['/team/create'], ['class' => 'btn btn-success']);
                                        }
                                    }
                                    ?>
                                </div>
                            </div>


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
                    <?php if (!is_null($model->stream)): ?>
                        <div role="tabpanel" class="tab-pane fade" id="livestream">
                            <div class="well bs-component">
                                <iframe
                                    src="https://player.twitch.tv/?channel={<?= $model->stream ?>}"
                                    height="720"
                                    width="100%"
                                    frameborder="0"
                                    scrolling="no"
                                    allowfullscreen="true">
                                </iframe>
                            </div>
                        </div>
                    <?php endif ?>
                </div>

            </div>

        </div>
    </div>
</div>
