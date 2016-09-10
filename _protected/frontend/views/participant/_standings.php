<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 27.07.2016
 * Time: 18:21
 */

/* @var $this yii\web\View */
/* @var $model frontend\models\Participant */

$rankArray = explode(',' ,$model->history);
$rankString = "";
foreach($rankArray as $rank){
    if($rank == "l"){
        $rankString = $rankString. "<div class='achieved-match-loss'>l</div>";
    } else if($rank == "w"){
        $rankString = $rankString. "<div class='achieved-match-win'>w</div>";
    }
}
?>

<tr>
    <td>
        <?= $model->rank ?>
    </td>
    <td>
        <?= $model->name ?>
    </td>
    <td>
        <?= $rankString ?> 
    </td>

</tr>
