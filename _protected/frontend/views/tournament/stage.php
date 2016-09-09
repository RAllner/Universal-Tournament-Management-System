<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 22.07.2016
 * Time: 12:26
 */

/* @var $this yii\web\View */
/* @var $dataProvider frontend\models\TournamentMatchSearch */
/* @var $losersDataProvider frontend\models\TournamentMatchSearch */
/* @var $treeDataProvider frontend\models\TournamentMatchSearch */
/* @var $losersTreeDataProvider frontend\models\TournamentMatchSearch */
/* @var $model frontend\models\Tournament */
/* @var $isFinalStage boolean */

use frontend\models\Tournament;
use yii\helpers\Html;
use yii\jui\Draggable;
use yii\web\View;
use yii\widgets\ListView;


$stage_name = ($model->stage_type == Tournament::STAGE_FS) ? Yii::t('app', 'Bracket') : Yii::t('app', 'Final Stage');

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
      var target = $(this).attr("data-target");
      var matrix = $(".tournament-tree").css("transform");
      var values = matrix.match(/-?[\d\.]+/g);
      var scaleFactor = parseFloat(values[0]);
      scaleFactor = zoomIn ? scaleFactor+0.1 : scaleFactor-0.1;
      if(scaleFactor > 0.4 && scaleFactor < 2){
      
        $('.tournament-'+target+'-tree').addClass("zoom-animate");
        $('.tournament-'+target+'-tree').css("transform","scale("+(scaleFactor)+")");
        
        $('.'+target+'-round-title2').css({
            "width" : 198 * scaleFactor+"px",
            "min-width":198 * scaleFactor+"px",
            "text-indent":23 * scaleFactor+"px"
        })
        
        setTimeout(function() { $('.tournament-'+target+'-tree').addClass("zoom-animate")},400);
      }
    })
    
    
    $('.clone-tournament').click(function(e) {
        
        var target = $(this).attr("data-target");
        var tournament2 = $("#clone-me-"+target).html(); 

        
        var wrapper = $("<div>").addClass("fixed-wrapper").hide();
        wrapper.append(tournament2);
        $("body").append(wrapper);
        wrapper.fadeIn();
        $('.fixed-wrapper .tournament-tree').draggable();
        $('.fixed-wrapper .tournament-losers-tree ').draggable();
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
    
    
    
    $( "#draggable-tournament-tree" ).on( "drag", function( event, ui ) {
        $('#round-title-wrapper').css("transform","translateX("+ui.position.left+"px)")
    } );
    $( "#draggable-tournament-losers-tree" ).on( "drag", function( event, ui ) {
        $('#losers-round-title-wrapper').css("transform","translateX("+ui.position.left+"px)")
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
$losersTreeModels = $losersTreeDataProvider->getModels();
$currentRound = null;


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
        <div class="col-xs-12">
            <?php echo $this->render('nav', ['model' => $model, 'active' => Tournament::ACTIVE_FINAL_STAGE]); ?>
        </div>
    </div>
    <div class="row" style="padding-top: 1em;">
        <div class="col-md-12 col-xs-12">
            <?php if ((!$isFinalStage && $model->status >= Tournament::STATUS_RUNNING) || ($isFinalStage && $model->status >= Tournament::STATUS_FINAL_STAGE)): ?>
            <div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#bracket" aria-controls="bracket" role="tab"
                                                              data-toggle="tab">Bracket</a></li>
                    <li role="presentation"><a href="#table" aria-controls="table" role="tab"
                                               data-toggle="tab">Table</a></li>

                </ul>


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="bracket">
                        <div class="well" id="clone-me-winners">
                            <div class="pull-right">
                                <div class="btn-toolbar" role="toolbar" aria-label="toolbar">
                                    <div class="btn-group" role="group" aria-label="zoom">
                                        <button class="btn zoom-in" title="<?= Yii::t('app', 'Zoom in') ?>" data-target="winners"><i
                                                class="material-icons zoom-in">zoom_in</i>
                                        </button>
                                        <button class="btn zoom-out" title="<?= Yii::t('app', 'Zoom out') ?>" data-target="winners"><i
                                                class="material-icons zoom-out">zoom_out</i>
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="...">
                                        <button class="btn show-seeds" title="<?= Yii::t('app', 'Seeds') ?>" data-target="winners"><i
                                                class="material-icons">remove_red_eye</i></button>
                                        <button class="btn clone-tournament" title="<?= Yii::t('app', 'Fullscreen') ?>" data-target="winners">
                                            <i
                                                class="material-icons">fullscreen</i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row" style="overflow: hidden;">
                                <div id="winners-round-title-wrapper" style="width: 2000px;">

                                    <?php
                                    echo '<div class="round-title">';
                                    foreach ($treeMatchModels as $key => $match) {
                                        /** @var $match \frontend\models\TournamentMatch */
                                        if ($match->round !== $currentRound) {
                                            echo '<div class="round-title2 winners-round-title2">' . $match->getRoundName($match->round, $model, 0) . '</div>';
                                            $currentRound = $match->round;
                                        }
                                    }
                                    echo "</div>";
                                    $currentRound = null;
                                    ?>
                                </div>
                            </div>

                            <div class="row tournament-tree-wrapper">
                                <?php Draggable::begin(['id' => 'draggable-tournament-tree'
                                ]);
                                ?>


                                <div class="col-xs-12 tournament-tree tournament-winners-tree">

                                    <?php
                                    foreach ($treeMatchModels as $key => $match) {
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
                <div role="tabpanel" class="tab-pane" id="table">
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
                                    'dataProvider' => $dataProvider,
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
                <?= ListView::widget([
                'summary' => false,
                'dataProvider' => $dataProvider,
                'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'We haven\'t started the tournament yet.') . '</div></div></div>',
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_modal', ['model' => $model, 'stage' => Tournament::STAGE_FS]);
                },
            ]) ?>
            <?php if ($model->fs_format == Tournament::FORMAT_DOUBLE_ELIMINATION): ?>
            <div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#losersBracket" aria-controls="losersBracket"
                                                              role="tab"
                                                              data-toggle="tab">Losers Bracket</a></li>
                    <li role="presentation"><a href="#losersTable" aria-controls="losersBracket" role="tab"
                                               data-toggle="tab">Losers Table</a></li>

                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="losersBracket">
                        <div class="well" id="clone-me-losers">
                            <div class="pull-right">
                                <div class="btn-toolbar" role="toolbar" aria-label="toolbar">
                                    <div class="btn-group" role="group" aria-label="zoom">
                                        <button class="btn zoom-in" title="<?= Yii::t('app', 'Zoom in') ?>" data-target="losers"><i
                                                class="material-icons zoom-in">zoom_in</i>
                                        </button>
                                        <button class="btn zoom-out" title="<?= Yii::t('app', 'Zoom out') ?>" data-target="losers"><i
                                                class="material-icons zoom-out" >zoom_out</i>
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="...">
                                        <button class="btn show-seeds" title="<?= Yii::t('app', 'Seeds') ?>" data-target="losers"><i
                                                class="material-icons" >remove_red_eye</i></button>
                                        <button class="btn clone-tournament" title="<?= Yii::t('app', 'Fullscreen') ?>"  data-target="losers">
                                            <i
                                                class="material-icons">fullscreen</i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row" style="overflow: hidden;">
                                <div id="losers-round-title-wrapper" style="width: 2000px;">
                                    <div class="round-title">
                                        <?php
                                        foreach ($losersTreeModels as $key => $match) {
                                            /** @var $match \frontend\models\TournamentMatch */
                                            if ($match->round !== $currentRound) {
                                                echo '<div class="round-title2 losers-round-title2">' . $match->getRoundName($match->round, $model, 1) . '</div>';
                                                $currentRound = $match->round;
                                            }
                                        }
                                        $currentRound = null;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row tournament-tree-wrapper">
                                <?php Draggable::begin(['id' => 'draggable-tournament-losers-tree'
                                ]);
                                ?>


                                <div class="col-xs-12 tournament-losers-tree ">

                                    <?php
                                    foreach ($losersTreeModels as $key => $match) {
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
                <div role="tabpanel" class="tab-pane" id="losersTable">
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
                                    'dataProvider' => $losersDataProvider,
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
                    <?= ListView::widget([
                        'summary' => false,
                        'dataProvider' => $losersDataProvider,
                        'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'We haven\'t started the tournament yet.') . '</div></div></div>',
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return $this->render('_modal', ['model' => $model, 'stage' => Tournament::STAGE_FS]);
                        },
                    ]) ?>
                <?php endif ?>

                <?php else: ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="well">
                                <?= Yii::t('app', 'Stage not yet ready.') ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>





