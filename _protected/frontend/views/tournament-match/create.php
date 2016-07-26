<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\TournamentMatch */

$this->title = Yii::t('app', 'Create Tournament Match');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tournament Matches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-match-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
