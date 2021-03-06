<?php

use frontend\models\Participant;
use frontend\models\Player;
use frontend\models\Tournament;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\Sortable;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ParticipantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tournament frontend\models\Tournament */
/* @var $model frontend\models\Participant */
/* @var $source array */
/* @var $bulk frontend\models\Bulk */
/* @var $externalSignupModel frontend\models\ParticipantExternalSignupForm */


$this->title = $tournament->name . " " . Yii::t('app', 'Participants');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['tournament/index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['tournament/view', 'id' => $tournament->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Participants');

$participants = Participant::find()->where(['tournament_id' => $tournament->id])->orderBy('seed')->all();
$idsOrderedBySeed = "";
/** @var Participant $participant */
foreach ($participants as $participant) {
    $idsOrderedBySeed = $idsOrderedBySeed . $participant->id . ',';
}

$script =
    <<< JS
            $(document).ready(function(){
            if($('.sortable').val()== "true"){
            $( "#sortable-participants" ).sortable({
              disabled: true
            });
            $('ol#sortable-participants li').addClass('disabled');
                  } else {
                $( "#sortable-participants" ).sortable({
              disabled: false
            });
                        $('ol#sortable-participants li').removeClass('disabled');
            }     
 
$('#sortable-participants').sortable({
            update: function(event, ui) {
                var productOrder = $(this).sortable('toArray').toString();
                $(".sendOrder").attr("href", $(".defaultUrl").val()+"&order="+productOrder);
                $(".sendOrder span").removeClass('hidden');
            }
    });
}); 
JS;
$this->registerJs($script, View::POS_END);
if($tournament->participants_count == ""){
    $participantCount = 0;
} else {
    $participantCount = $tournament->participants_count;
}

?>
<div class="participant-index">

    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Tournaments'), ['tournament/index'], ['class' => 'btn btn-warning']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12">
            <?php echo $this->render(Url::to('/tournament/nav'), ['model' => $tournament, 'active' => Tournament::ACTIVE_PARTICIPANTS]); ?>
        </div>
    </div>
    <div class="row" style="margin-top: 1em">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="well">

                <div class="pull-right">
                    <?php if ($tournament->status < Tournament::STATUS_RUNNING): ?>
                    <div class="btn-toolbar">
                        <a href="<?= Url::to(['reorder', 'id' => $tournament->id, 'order' => $idsOrderedBySeed,]) ?>"
                           class="sendOrder" title="<?= Yii::t('app', 'Save order') ?>"><span class="hidden btn btn-success"><i
                                    class="material-icons">save</i> </span></a>
                        <?= Html::a('<i class="material-icons">shuffle</i> ', ['shuffle-seeds', 'tournament_id' => $tournament->id], ['class' => 'btn btn-warning', 'title' => Yii::t('app', 'Shuffle seeds')]) ?>
                        </div>
                    <?php endif ?>
                </div>
                <h3><i class="material-icons" style="font-size: 30px; vertical-align: sub; ">people</i> <?= $participantCount . ' / '.  $tournament->max_participants . ' '.Yii::t('app','registered')?></h3>
                <div class="clearfix"></div>

                <?php

                /** @var Participant $participant */
                foreach ($participants as $participant) {
                    if($participant->checked_in == 0){
                        $control = (Yii::$app->user->can('updateTournament', ['model' => $tournament]) && $tournament->status < Tournament::STATUS_RUNNING) ? Html::a('<i class="material-icons unchecked">check_circle</i>', Url::to(['check-in', 'id' => $participant->id]), ['data-method' => 'post']). ' '.Html::a('<i class="material-icons">delete</i>', Url::to(['delete', 'id' => $participant->id]), ['data-method' => 'post']) : "";
                    } else {
                        $control = (Yii::$app->user->can('updateTournament', ['model' => $tournament]) && $tournament->status < Tournament::STATUS_RUNNING) ? Html::a('<i class="material-icons">check_circle</i>', Url::to(['check-in', 'id' => $participant->id]), ['data-method' => 'post']). ' '.Html::a('<i class="material-icons">delete</i>', Url::to(['delete', 'id' => $participant->id]), ['data-method' => 'post']) : "";
                    }
                    if(!is_null($participant->player_id)){
                        /** @var Player $player */
                        $player = Player::find()
                            ->where(['id' => $participant->player_id])
                            ->one();
                        $name = Html::a($player->name, ['@web/../player/view', 'id' => $participant->player_id]);
                    } else if(!is_null($participant->team_id)){
                        /** @var Player $player */
                        $player = Team::find()
                            ->where(['id' => $participant->team_id])
                            ->one();
                        $name = Html::a($player->name, ['@web/../team/view', 'id' => $participant->team_id]);
                    } else{
                        $name = $participant->name;
                    }
                    $items[$participant->seed] = [
                        'content' =>

                            '<div style="float: left">' . $name . '</div>'

                            . '<div class="control-group">'
                            . '<i class="material-icons">drag_handle</i>'
                            . $control

                                . '</div>',
                        'options' => ['id' => $participant->id],
                    ];
                }
                if (isset($items)) {
                    echo Sortable::widget([
                        'id' => 'sortable-participants',
                        'items' => $items,
                        'options' => ['tag' => 'ol'],
                        'itemOptions' => ['tag' => 'li'],
                        'clientOptions' => ['cursor' => 'move'],
                    ]);
                } else {
                    echo Yii::t('app', 'No participants registered');
                }

                ?>

                <input class="sortable" type="hidden" name="order"
                       value="<?= $value = ($tournament->status < Tournament::STATUS_RUNNING && Yii::$app->user->can('updateTournament', ['model' => $tournament])) ? 'false' : 'true' ?>">
                <input class="defaultUrl" type="hidden" name="url"
                       value="<?= Url::to(['reorder', 'id' => $tournament->id]) ?>">
                <p style="text-align: right"><i class="material-icons">drag_handle</i> <?= Yii::t('app', 'Drag and drop to sort')?> </p>
                <p style="text-align: right"><i class="material-icons unchecked">check_circle</i> <?= Yii::t('app', 'CheckIn the participant')?> </p>
                <p style="text-align: right"><i class="material-icons">delete</i> <?= Yii::t('app', 'Remove the participant')?> </p>
            </div>
            <?php if (Yii::$app->user->can('updateTournament', ['model' => $tournament])) { ?>
                <div class="row hidden-md hidden-lg">

                    <div class="col-md-12">

                        <h3><?= Yii::t('app', 'Add participants') ?></h3>

                        <div class="well">
                            <?= $this->render('_adminForm', [
                                'model' => $model,
                                'source' => $source,
                            ]) ?>
                        </div>


                        <div class="well">
                            <?= $this->render('_bulkForm', [
                                'bulk' => $bulk,
                            ]) ?>
                        </div>

                    </div>

                </div>
            <?php } elseif ($tournament->status == Tournament::STATUS_PUBLISHED) { ?>
                <div class="row hidden-md hidden-lg">
                    <?php if(Yii::$app->user->isGuest): ?>
                        <h3><?= Yii::t('app', 'Signup') ?> </h3>
                        <div class="well">
                            <b><?= Yii::t('app', 'Login'). ' ' ?> </b>
                            <p><?= Yii::t('app', 'Login to signup with your player profile') ?>!</p>
                            <?= Html::a(Yii::t('app', 'Login'), ['/site/login'], ['class' => 'btn btn-success btn-block']) ?>
                        </div>
                        <div class="well">
                            <?= $this->render('_externalSignupForm', [
                                'model' => $externalSignupModel,
                            ]) ?>
                        </div>
                    <?php endif ?>
                <?php if(Yii::$app->user->can('member')): ?>
                    <?= $this->render('_form', [
                        'model' => $model,
                        'tournament' => $tournament,
                    ]) ?>

                <?php endif ?>
                </div>
            <?php } ?>
        </div>
        <?php if (Yii::$app->user->can('updateTournament', ['model' => $tournament])) { ?>
            <div class="col-md-4 hidden-xs hidden-sm">
                <h3><?= Yii::t('app', 'Add participants') ?></h3>
                <div class="well">
                    <?= $this->render('_adminForm', [
                        'model' => $model,
                        'source' => $source,
                    ]) ?>
                </div>
                <div class="well">
                    <?= $this->render('_bulkForm', [
                        'bulk' => $bulk,
                    ]) ?>
                </div>
            </div>
        <?php } elseif ($tournament->status == Tournament::STATUS_PUBLISHED) { ?>
        <div class="col-md-4 hidden-xs hidden-sm">
            <?php if(Yii::$app->user->isGuest): ?>
            <h3><?= Yii::t('app', 'Signup') ?> </h3>
            <div class="well">
                <b><?= Yii::t('app', 'Login') ?> </b>
                <p><?= Yii::t('app', 'Login to signup with your player profile') ?>!</p>
                <?= Html::a(Yii::t('app', 'Login'), ['/site/login'], ['class' => 'btn btn-success btn-block']) ?>
            </div>


            <div class="well">
                <?= $this->render('_externalSignupForm', [
                    'model' => $externalSignupModel,
                ]) ?>
            </div>
            <?php endif ?>
            <?php if(Yii::$app->user->can('member')): ?>
                <?= $this->render('_form', [
                    'model' => $model,
                    'tournament' => $tournament,
                ]) ?>

            <?php endif ?>

        </div>
        <?php } ?>
    </div>
</div>