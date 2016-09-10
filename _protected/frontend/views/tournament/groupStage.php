<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 22.07.2016
 * Time: 12:26
 */

/* @var $model frontend\models\Tournament */
/* @var $this yii\web\View */
/* @var $dataProvider frontend\models\TournamentMatchSearch */
/* @var $losersDataProvider frontend\models\TournamentMatchSearch */
/* @var $treeDataProvider frontend\models\TournamentMatchSearch */
/* @var $losersTreeDataProvider frontend\models\TournamentMatchSearch */
/* @var $treeDataProviderArray [] array */
/* @var $losersTreeDataProviderArray [] array */
/* @var $dataProviderArray [] array */
/* @var $losersDataProviderArray [] array */

use frontend\models\Tournament;
use yii\helpers\Html;
use yii\jui\Draggable;
use yii\web\View;
use yii\widgets\ListView;


$stage_name = Yii::t('app', 'Group Stage');

$this->title = $model->name . " " . $stage_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $stage_name;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];

$script =
    <<< JS
    $(document).on("click",".zoom-in, .zoom-out",function (e) {
      var zoomIn = $(e.target).hasClass("zoom-in");
      console.log($(e.target).hasClass("zoom-in"));
      var groupTarget = $(this).data("target");
      var matrix = $(".tournament-tree-"+groupTarget).css("transform");
      var values = matrix.match(/-?[\d\.]+/g);
      var scaleFactor = parseFloat(values[0]);
      scaleFactor = zoomIn ? scaleFactor+0.1 : scaleFactor-0.1;

      if(scaleFactor > 0.4 && scaleFactor < 2){

        $(".tournament-tree-"+groupTarget).addClass("zoom-animate");
        $(".tournament-tree-"+groupTarget).css("transform","scale("+(scaleFactor)+")");
        var newheight = $(".tournament-tree-"+groupTarget).originalElement.height()*scaleFactor;
        $(".tournament-tree-"+groupTarget).css({
        "min-height": newheight+"px"
        });
        
        $(".round-title2"+groupTarget).css({
            "width" : 198 * scaleFactor+"px",
            "min-width":198 * scaleFactor+"px",
            "text-indent":23 * scaleFactor+"px"
        })
        
        setTimeout(function() { $(".tournament-tree-"+groupTarget).addClass("zoom-animate")},400);
      }
    })
    
    
    $('.clone-tournament').click(function(e) {
        var tournament2 = $("#clone-me").html(); 
        
        var wrapper = $("<div>").addClass("fixed-wrapper").hide();
        wrapper.append(tournament2);
        $("body").append(wrapper);
        wrapper.fadeIn();
        $('.fixed-wrapper .tournament-tree').draggable();
        $('.fixed-wrapper').addClass('well')
        $('.fixed-wrapper')
        .css('margin-bottom: 0');
        
        $('.fixed-wrapper .tournament-tree-wrapper').css({
        'height': $( window ).height()+'px'
        }
        );
        
        var cloneCloseButton = $(".fixed-wrapper .clone-tournament");
        cloneCloseButton.html("<i class='material-icons'>fullscreen_exit</i>").click(function(){
        $(".fixed-wrapper").fadeOut("slow", function() {
          this.remove();
        })
        })
    })
    
    $('.show-seeds').click(function() {
      $('.match .m-id').toggle();
    })
    
    
    
    $( "#draggable-tournament-tree-1" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-1').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-1" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-1').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-tree-2" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-2').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-2" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-2').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-tree-3" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-3').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-3" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-3').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-tree-4" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-4').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-4" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-4').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-tree-5" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-5').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-5" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-5').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-tree-6" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-6').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-6" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-6').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-tree-7" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-7').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-7" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-7').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-tree-8" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-8').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-8" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-8').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-tree-9" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-9').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-9" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-9').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-tree-10" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper-10').css("transform","translateX("+ui.position.left+"px)")
    } );    
    $( "#draggable-losers-tournament-tree-10" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper-10').css("transform","translateX("+ui.position.left+"px)")
    } );
    
    $( "#draggable-tournament-tree" ).on( "dragstart", function( event, ui ) {
        $( "#draggable-tournament-tree" ).css({
                'cursor': 'grabbing',
                'cursor': '-moz-grabbing',
                'cursor': '-webkit-grabbing'
        })
    } );
    $( "#draggable-tournament-tree" ).on( "dragstop", function( event, ui ) {
            $( "#draggable-tournament-tree" ).css({
                'cursor': 'move',
                'cursor': 'grab',
                'cursor': '-moz-grab',
                'cursor': '-webkit-grab'
        })
    } );
    
    
       $(':checkbox').on('change', function () {
         var targetID = $(this).data('target');
             
         if($(this).parents('.selected').length){
                $(':checkbox').closest('div').removeClass('selected');
                 $('.field-tournamentmatch-winner_id-'+targetID+'> input').val("");
                 $('.field-tournamentmatch-loser_id-'+targetID+'> input').val("");
         } else {
                $(':checkbox').not(this).closest('div').removeClass('selected');
                $(':checkbox').not(this).closest('div').addClass('unselected'); 
                $(this).closest('div').addClass('selected');
                $(this).closest('div').removeClass('unselected');
                $('.field-tournamentmatch-winner_id-'+targetID+'> input').val($(this).val());
                $('.field-tournamentmatch-loser_id-'+targetID+'> input').val($(this).closest('div.match-winner').find('.fake-button.unselected input').val());
                
        }
});


$('.set-add').on('click', function() {
    var targetID = $(this).data('target');
    var setCount = $('input.setCount'+targetID).val();
    if(setCount == 1){
        $('.set-remove'+targetID).removeClass('hidden');
        $('.set-remove'+targetID).show();
    } 
        setCount++;
        $('div.setsA'+targetID).prepend('<label class="set-points form-control additionalSetA'+ targetID + setCount +'">'+'<input type="number" name="A" min="0" value="0"></label>');
        $('div.setsB'+targetID).prepend('<label class="set-points form-control additionalSetB'+ targetID + setCount +'">'+'<input type="number" name="B" min="0" value="0"></label>');
        

    $('input.setCount'+targetID).val(""+setCount);
})

$('.set-remove').on('click', function() {
    var targetID = $(this).data('target');
    var setCount = $('input.setCount'+targetID).val();
    alert(setCount);

    $('label.set-points.form-control.additionalSetA'+ targetID + setCount).remove();
    $('label.set-points.form-control.additionalSetB'+ targetID + setCount).remove();
    setCount--
    if(setCount == "1"){
        $(this).hide();
    }
    $('input.setCount'+targetID).val(""+setCount);
});

$('.report-match').on('click', function() {
   var targetID = $(this).data('target');
   var setCount = $('input.setCount'+targetID).val();
   var scoreCSV = "";
   var scoreMatches_A = "0";
   var scoreMatches_B = "0";
   for(i=1;i<= setCount; i++){
        var i_string = i.toString();
        var scoreA = $('.additionalSetA'+ targetID + i_string +' > input').val();
        var scoreB = $('.additionalSetB'+ targetID + i_string +' > input').val();
        if(scoreA > scoreB){
            scoreMatches_A++;
        } else if(scoreB > scoreA){
            scoreMatches_B++;
        }
        if(i == 1){
        scoreCSV = scoreCSV+scoreA+'-'+scoreB;
        } else {
        scoreCSV = scoreCSV+','+scoreA+'-'+scoreB;
        }
   }
   $('.field-tournamentmatch-participant_score_A-'+targetID+'> input').val(scoreMatches_A);
   $('.field-tournamentmatch-participant_score_B-'+targetID+'> input').val(scoreMatches_B);
   $('.field-tournamentmatch-scores-'+targetID+'> input').val(scoreCSV);
   $('form#'+targetID).submit();
});

JS;
$this->registerJs($script, View::POS_END);

$treeMatchModels = $treeDataProvider->getModels();

$currentRound = null;
$currentGroup = null;

?>
<div class="tournament-stage">
    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">
            <button class="btn show-seeds" title="<?= Yii::t('app', 'Seeds') ?>" data-target="winners"><i
                    class="material-icons">remove_red_eye</i></button>
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Tournaments'), ['index'], ['class' => 'btn btn-warning']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12">
            <?php echo $this->render('nav', ['model' => $model, 'active' => Tournament::ACTIVE_GROUP_STAGE]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?php for ($group = 1;
            $group <= $model->getGroupCount();
            $group++) { ?>

            <h4><?= Yii::t('app', 'Group') . ' ' . $group ?>
            </h4>

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#bracket<?= $group ?>"
                                                          aria-controls="bracket<?= $group ?>" role="tab"
                                                          data-toggle="tab">Bracket</a></li>
                <li role="presentation"><a href="#table<?= $group ?>" aria-controls="table<?= $group ?>" role="tab"
                                           data-toggle="tab">Table</a></li>

            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="bracket<?= $group ?>">
                    <div class="well tournament-well" id="clone-me<?= $group ?>">
                        <div class="row" style="overflow: hidden;">
                            <div id="round-title-wrapper-<?= $group ?>" style="width: 2000px;">
                                <div class="round-title">
                                    <?php
                                    foreach ($treeDataProviderArray[$group]->getModels() as $key => $match) {
                                        /** @var $match \frontend\models\TournamentMatch */
                                        if ($match->round !== $currentRound) {
                                            echo '<div class="round-title2 round-title2' . $group . '">' . $match->getRoundName($match->round, $model, 0) . '</div>';
                                            $currentRound = $match->round;
                                        }
                                    }
                                    $currentRound = null;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row tournament-tree-wrapper">
                            <?php Draggable::begin(['id' => 'draggable-tournament-tree-' . $group
                            ]);
                            ?>
                            <div class="col-xs-12 tournament-tree" id="tournament-tree" data-target="<?= $group ?>">
                                <?php
                                foreach ($treeDataProviderArray[$group]->getModels() as $key => $match) {
                                    /** @var $match \frontend\models\TournamentMatch */

                                    if ($match->round !== $currentRound) {
                                        if ($currentRound !== null) echo '</div>';
                                        echo '<div class="round">';
                                        $currentRound = $match->round;
                                    }
                                    echo $model->createMatchElement($key, $match);
                                } ?>
                            </div>
                            <?php Draggable::end() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="table<?= $group ?>">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="centered" width="100%">
                            <tr>
                                <th><?= Yii::t('app', 'Match ID') ?></th>
                                <th><?= Yii::t('app', 'Round') ?></th>
                                <th><?= Yii::t('app', 'Participant A') ?></th>
                                <th><?= Yii::t('app', 'Score') ?></th>
                                <th><?= Yii::t('app', 'Participant B') ?></th>
                                <th><?= Yii::t('app', 'State') ?></th>
                                <?php if ($model->status != Tournament::STATUS_FINISHED): ?>
                                    <th></th>
                                <?php endif ?>
                            </tr>
                            <?= ListView::widget([
                                'summary' => false,
                                'dataProvider' => $dataProviderArray[$group],
                                'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'We haven\'t started the tournament yet.') . '</div></div></div>',
                                'itemOptions' => ['class' => 'item'],
                                'itemView' => function ($model, $key, $index, $widget) {
                                    return $this->render('_stage', ['model' => $model, 'stage' => Tournament::STAGE_FS]);
                                },
                            ]) ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($model->gs_format == Tournament::FORMAT_DOUBLE_ELIMINATION): ?>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#losersBracket<?= $group ?>"
                                                          aria-controls="bracket<?= $group ?>" role="tab"
                                                          data-toggle="tab">Losers Bracket</a></li>
                <li role="presentation"><a href="#losersTable<?= $group ?>" aria-controls="losersTable<?= $group ?>"
                                           role="tab"
                                           data-toggle="tab">Table</a></li>

            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="losersBracket<?= $group ?>">
                    <div class="well tournament-well" id="clone-me<?= $group ?>">
                        <div class="row" style="overflow: hidden;">
                            <div id="losers-round-title-wrapper-<?= $group ?>" style="width: 2000px;">
                                <div class="round-title">
                                    <?php
                                    foreach ($treeDataProviderArray[$group]->getModels() as $key => $match) {
                                        /** @var $match \frontend\models\TournamentMatch */
                                        if ($match->round !== $currentRound) {
                                            echo '<div class="round-title2 round-title2' . $group . '">' . $match->getRoundName($match->round, $model, 0) . '</div>';
                                            $currentRound = $match->round;
                                        }
                                    }
                                    $currentRound = null;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row tournament-tree-wrapper">
                            <?php Draggable::begin(['id' => 'draggable-losers-tournament-tree-' . $group
                            ]);
                            ?>
                            <div class="col-xs-12 tournament-losers-tree" id="tournament-tree-<?= $group ?>">
                                <?php
                                foreach ($losersTreeDataProviderArray[$group]->getModels() as $key => $match) {
                                    /** @var $match \frontend\models\TournamentMatch */

                                    if ($match->round !== $currentRound) {
                                        if ($currentRound !== null) echo '</div>';
                                        echo '<div class="round">';
                                        $currentRound = $match->round;
                                    }
                                    echo $model->createDEMatchElement($key, $match);
                                } ?>
                            </div>
                            <?php Draggable::end() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="losersTable<?= $group ?>">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="centered" width="100%">
                            <tr>
                                <th><?= Yii::t('app', 'Match ID') ?></th>
                                <th><?= Yii::t('app', 'Round') ?></th>
                                <th><?= Yii::t('app', 'Participant A') ?></th>
                                <th><?= Yii::t('app', 'Score') ?></th>
                                <th><?= Yii::t('app', 'Participant B') ?></th>
                                <th><?= Yii::t('app', 'State') ?></th>
                                <?php if ($model->status != Tournament::STATUS_FINISHED): ?>
                                    <th></th>
                                <?php endif ?>
                            </tr>
                            <?= ListView::widget([
                                'summary' => false,
                                'dataProvider' => $losersDataProviderArray[$group],
                                'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'We haven\'t started the tournament yet.') . '</div></div></div>',
                                'itemOptions' => ['class' => 'item'],
                                'itemView' => function ($model, $key, $index, $widget) {
                                    return $this->render('_stage', ['model' => $model, 'stage' => Tournament::STAGE_FS]);
                                },
                            ]) ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>
        <?php
        $currentRound = null;
        } ?>

        <?= ListView::widget([
            'summary' => false,
            'dataProvider' => $dataProvider,
            'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'We haven\'t started the tournament yet.') . '</div></div></div>',
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_modal', ['model' => $model, 'stage' => Tournament::STAGE_GS]);
            },
        ]) ?>
        <?= ListView::widget([
            'summary' => false,
            'dataProvider' => $losersDataProvider,
            'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'We haven\'t started the tournament yet.') . '</div></div></div>',
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_modal', ['model' => $model, 'stage' => Tournament::STAGE_GS]);
            },
        ]) ?>
        <?php if (!($model->status >= Tournament::STATUS_RUNNING)): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="well">
                        <?= Yii::t('app', 'Tournament not yet ready.') ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
</div>
