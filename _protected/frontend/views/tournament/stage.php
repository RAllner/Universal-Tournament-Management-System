<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 22.07.2016
 * Time: 12:26
 */

/* @var $this yii\web\View */
/* @var $tournament frontend\models\Tournament */
/* @var $dataProvidernew frontend\models\TournamentMatchSearch */
/* @var $model frontend\models\TournamentMatch */

use frontend\models\Participant;
use frontend\models\Tournament;
use frontend\models\TournamentMatch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\jui\Draggable;
use yii\web\View;
use yii\widgets\ListView;


$stage_name = ($tournament->stage_type == Tournament::STAGE_FS) ? Yii::t('app', 'Bracket') : Yii::t('app', 'Final Stage');

$this->title = $tournament->name . " " . $stage_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournaments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['view', 'id' => $tournament->id]];
$this->params['breadcrumbs'][] = $stage_name;
$photoInfo = $tournament->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];

$script =
    <<< JS
    $(document).on("click",".zoom-in, .zoom-out",function (e) {
      var zoomIn = $(e.target).hasClass("zoom-in");
      var matrix = $(".tournament-tree").css("transform");
      var values = matrix.match(/-?[\d\.]+/g);
      var scaleFactor = parseFloat(values[0]);
      scaleFactor = zoomIn ? scaleFactor+0.1 : scaleFactor-0.1;
      if(scaleFactor > 0.4 && scaleFactor < 2){
      
        $('.tournament-tree').addClass("zoom-animate");
        $('.tournament-tree').css("transform","scale("+(scaleFactor)+")");
        
        $('.round-title2').css({
            "width" : 198 * scaleFactor+"px",
            "min-width":198 * scaleFactor+"px",
            "text-indent":23 * scaleFactor+"px"
        })
        
        setTimeout(function() { $('.tournament-tree').addClass("zoom-animate")},400);
      }
    })
    
    
    $('.clone-tournament').click(function(e) {
        var tournament2 = $("#clone-me").html(); 
        
        var wrapper = $("<div>").addClass("fixed-wrapper").hide();
        wrapper.append(tournament2);
        $("body").append(wrapper);
        wrapper.fadeIn();
        $('.fixed-wrapper .tournament-tree').draggable();
        
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
JS;
$this->registerJs($script, View::POS_END);


$treeMatchModels = $tournament->getTreeMatches(Tournament::STAGE_FS);
$currentRound = null;


?>
<div class="tournament-stage">
    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">
            <?= $link = ($tournament->status == Tournament::STATUS_COMPLETE) ? Html::a('<i class="material-icons">done</i> ' . Yii::t('app', 'Finish Tournament'), ['finish', 'id' => $tournament->id], ['class' => 'btn btn-success']) : "" ?>
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2 col-xs-3">
            <?php echo $this->render('nav', ['model' => $tournament, 'active' => Tournament::ACTIVE_FINAL_STAGE]); ?>
        </div>
        <div class="col-md-10 col-xs-9" id="clone-me">
            <div class="well">
                <button class="btn zoom-in"><i class="material-icons">zoom_in</i></button>
                <button class="btn zoom-out"><i class="material-icons">zoom_out</i></button>
                <div class="pull-right">
                <button class="btn show-seeds">Seeds</button>
                <button class="btn clone-tournament" title="<?= Yii::t('app', 'Fullscreen')?>"><i class="material-icons">fullscreen</i></button>
                </div>
                <div class="clearfix"></div>

                <div class="row" style="overflow: hidden;">
                    <div id="round-title-wrapper" style="width: 2000px;">

                        <?php
                        echo '<div class="round-title">';
                        foreach ($treeMatchModels as $key => $model) {
                            /** @var $model \frontend\models\TournamentMatch */
                            if ($model->round !== $currentRound) {
                                echo '<div class="round-title2">' . $model->getRoundName($model->round, $tournament, 0) . '</div>';
                                $currentRound = $model->round;
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


                    <div class="col-xs-12 tournament-tree ">

                        <?php
                        foreach ($treeMatchModels as $key => $model) {
                            /** @var $model \frontend\models\TournamentMatch */

                            if ($model->round !== $currentRound) {
                                if ($currentRound !== null) echo '</div>';


                                echo '<div class="round">';

                                $currentRound = $model->round;
                            }

                            echo $tournament->createMatchElement($key, $model);

                        } ?>

                    </div>
                    <?php Draggable::end() ?>
                </div>


            </div>

        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="centered">
                    <tr>
                        <th><?= Yii::t('app', 'Match ID') ?></th>
                        <th><?= Yii::t('app', 'Participant A') ?></th>
                        <th><?= Yii::t('app', 'Points A') ?></th>
                        <th><?= Yii::t('app', 'Points B') ?></th>
                        <th><?= Yii::t('app', 'Participant B') ?></th>
                        <?php if($tournament->status != Tournament::STATUS_FINISHED): ?>
                        <th><?= Yii::t('app', 'Round') ?></th>
                        <?php endif ?>
                        <th> </th>
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



