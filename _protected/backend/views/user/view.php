<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username; ?>

<div class="user-view">

    <h1><?= Html::encode($this->title) ?>

        <div class="pull-right">

            <?php if (Yii::$app->user->can('updateUser', ['model' => $model])): ?>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], [
                    'class' => 'btn btn-primary']) ?>
            <?php endif ?>
            <?php if (Yii::$app->user->can('deleteUser', ['model' => $model])): ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this user?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
            <?php if (Yii::$app->user->can('admin')): ?>
                <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-warning']) ?>
            <?php endif ?>
        </div>
    </h1>
    <div class="clearfix"></div>

    <div class="well">


        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'username',
                'email:email',
                //'password_hash',
                [
                    'attribute' => 'status',
                    'value' => $model->getStatusName(),
                ],
                [
                    'attribute' => 'item_name',
                    'value' => $model->getRoleName(),
                ],
                //'auth_key',
                //'password_reset_token',
                //'account_activation_token',
                'created_at:date',
                //'updated_at:date',
            ],
        ]) ?>
    </div>
</div>

