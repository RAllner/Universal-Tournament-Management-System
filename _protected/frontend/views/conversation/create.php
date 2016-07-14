<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Conversation */

$this->title = Yii::t('app', 'Create Conversation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Conversations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conversation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
