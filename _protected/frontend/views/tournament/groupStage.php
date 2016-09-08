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
/* @var $treeDataProvider \yii\data\ActiveDataProvider */
/* @var $treeDataProviderArray [] array */

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

$treeMatchModels = $treeDataProvider->getModels();

$currentRound = null;
$currentGroup = null;

?>
<div class="tournament-stage">
    <h1><?= Html::encode($this->title);
        ?>
        <div class="pull-right">

            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
            <button class="btn show-seeds"><?= Yii::t('app', 'Seeds') ?></button>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2 col-xs-3">
            <?php echo $this->render('nav', ['model' => $model, 'active' => Tournament::ACTIVE_GROUP_STAGE]); ?>
        </div>
        <div class="col-md-10 col-xs-9">
            <?php for ($group = 1;
            $group <= $model->getGroupCount();
            $group++) { ?>
            <div class="well" id="clone-me<?= $group ?>">
                <h4><?= Yii::t('app', 'Group') . ' ' . $group ?></h4>
                <div class="clearfix"></div>

                <div class="row" style="overflow: hidden;">
                    <div id="round-title-wrapper" style="width: 2000px;">
                        <!--                    <pre>-->
                        <?php // print_r($treeDataProviderArray[2]->getModels()) ?>
                        <!--                    </pre>-->
                        <?php
                        echo '<div class="round-title">';
                        foreach ($treeDataProviderArray[$group]->getModels() as $key => $match) {
                            /** @var $match \frontend\models\TournamentMatch */
                            if ($match->round !== $currentRound) {
                                echo '<div class="round-title2 round-title2'.$group.'">' . $match->getRoundName($match->round, $model, 0) . '</div>';
                                $currentRound = $match->round;
                            }
                        }
                        echo "</div>";
                        $currentRound = null;
                        ?>
                    </div>
                </div>

                <div class="row tournament-tree-wrapper">
                    <?php Draggable::begin(['id' => 'draggable-tournament-tree' . $group
                    ]);
                    ?>


                    <div class="col-xs-12 tournament-tree" id="tournament-tree-<?= $group ?>">

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
                    </div>
                    <?php Draggable::end() ?>

                </div>
            </div>

        <?php
        $currentRound = null;
        } ?>


        <div class="row">
            <div class="col-xs-12">

                <table class="centered" width="100%">
                    <tr>
                        <th><?= Yii::t('app', 'Match ID') ?></th>
                        <th><?= Yii::t('app', 'Group') ?></th>
                        <th><?= Yii::t('app', 'Round') ?></th>
                        <th><?= Yii::t('app', 'Participant A') ?></th>
                        <th><?= Yii::t('app', 'Points A') ?></th>
                        <th><?= Yii::t('app', 'Points B') ?></th>
                        <th><?= Yii::t('app', 'Participant B') ?></th>
                        <?php if ($model->status == Tournament::STATUS_RUNNING): ?>
                            <th></th>
                        <?php endif ?>
                    </tr>
                    <?= ListView::widget([
                        'summary' => false,
                        'dataProvider' => $dataProvider,
                        'emptyText' => '<div class="row"><div class="col-lg-12"><div class="well">' . Yii::t('app', 'We haven\'t started the tournament yet.') . '</div></div></div>',
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return $this->render('_stage', ['model' => $model, 'stage' => Tournament::STAGE_GS]);
                        },
                    ]) ?>
                </table>

            </div>
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
</div>