<?php

use frontend\models\Player;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TeamMember */
/* @var $form ActiveForm */
$this->title = Yii::t('app', 'Add Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
foreach (Player::find()->all() as $player){
    $object  = (object)[ 'label' => $player['nameWithRunningNr'], 'value' => $player['id']];
    $source[] = $object;
}

?>
<div class="team-add">
    <h1>Add Member</h1>
    <div class="container">
    <div class="row">
        <div class="well col-lg-8">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'player_id')->widget(\yii\jui\AutoComplete::classname(), [
                'clientOptions' => [
                    'source' => $source,
                ],
            ])->hint(Yii::t('app', 'Enter a player name or Id. We will help you with that.')) ?>
            <?= $form->field($model, 'admin')->checkbox()->hint(Yii::t('app', 'Admin members can edit the team attributes and add or remove members.')) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div>
