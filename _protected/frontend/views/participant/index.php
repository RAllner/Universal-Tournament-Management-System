<?php

use frontend\models\Participant;
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


?>
<div class="participant-index">

    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['tournament/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-12">
            <?php echo $this->render(Url::to('/tournament/nav'), ['model' => $tournament, 'active' => Tournament::ACTIVE_PARTICIPANTS]); ?>
        </div>
        <div class="col-md-6 col-sm-9 col-xs-12">
            <div class="pull-right">
                <?php if($tournament->status < Tournament::STATUS_RUNNING): ?>
                <a href="<?= Url::to(['reorder', 'id' => $tournament->id, 'order' => $idsOrderedBySeed,]) ?>"
                   class="sendOrder"><span class="hidden btn btn-success"><?= Yii::t('app', 'Save order') ?></span></a>
                <?= Html::a('<i class="material-icons">shuffle</i> ' . Yii::t('app', 'Shuffle Seeds'), ['shuffle-seeds', 'tournament_id' => $tournament->id], ['class' => 'btn btn-info']) ?>
                <?php endif ?>
            </div>
            <div class="clearfix"></div>
            <?php

            /** @var Participant $participant */
            foreach ($participants as $participant) {
                $items[$participant->seed] = [
                    'content' =>

                        '<div style="float: left">'.$participant->name.'</div>'

                        . '<div class="control-group">'
                        .'<i class="material-icons">drag_handle</i>'
                            . $control = (Yii::$app->user->can('updateTournament', ['model' => $model])) ? Html::a('<i class="material-icons">delete</i>', Url::to(['delete', 'id' => $participant->id]), ['data-method' => 'post']) : ""
                        . "</div>",
                    'options' => ['id' => $participant->id],
                ];
            }
            if(isset($items)){
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
                   value="<?= $value = ($tournament->status >= Tournament::STATUS_RUNNING)? 'true':'false' ?>">
            <input class="defaultUrl" type="hidden" name="url"
                   value="<?= Url::to(['reorder', 'id' => $tournament->id]) ?>">

            <?php if (Yii::$app->user->can('updateTournament', ['model' => $tournament])): ?>
                <div class="row hidden-md hidden-lg">
                    <div class="col-md-6">

                        <div class="well">
                            <?= $this->render('_adminForm', [
                                'model' => $model,
                                'source' => $source,
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="well">
                            <?= $this->render('_bulkForm', [
                                'bulk' => $bulk,
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <div class="col-md-4 hidden-xs hidden-sm">
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

</div>