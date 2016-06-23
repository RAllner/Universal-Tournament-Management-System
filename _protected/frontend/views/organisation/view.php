<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\Organisation */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organisations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>
<div class="organisation-view">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">

            <?php if (Yii::$app->user->can('updateArticle', ['model' => $model])): ?>

                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?php endif ?>

            <?php if (Yii::$app->user->can('adminArticle')): ?>

                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this Organisation?'),
                        'method' => 'post',
                    ],
                ]) ?>

            <?php endif ?>
            <?php if (Yii::$app->user->can('adminArticle')): ?>

                <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-warning']) ?>

            <?php endif ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="well">
        <div class="media">
            <div class="media-left">

                <a href="#">
                    <img class="media-object" style="width:100px" src="<?= $photoInfo['url'] ?>"
                         alt="<?= $model->name ?>">
                </a>
            </div>
            <div class="media-body media-middle">
                <div class="pull-right">
                    <h5><?= Yii::t('app', 'Members') ?></h5>
                    <table class="col-lg-12">
                        <thead>
                        <tr>
                            <th>
                                <?= Yii::t('app', 'User') ?>
                            </th>
                            <th>
                                <?= Yii::t('app', 'Joined') ?>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->organisationHasUsers as $ouser) {
                            echo '<tr>';
                            $user = User::find()->where(['id' => $ouser->user_id])->one();
                            echo "<td>".$user->username . "</td><td>" .date('F j, Y, g:i a', $ouser->created_at)."</td>";
                            echo '</tr>';
                        }; ?>
                        </tbody>
                    </table>
                    <?= Html::a(Yii::t('app', 'Add User'), Url::to(['organisation/add', 'id' => $model->id]), ['class' => 'btn btn-warning']) ?>
                </div>
                <p>
                    <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Owner') . ' ' . $model->authorName ?>
                    <i class="material-icons">schedule</i> <?= Yii::t('app', 'Created on') . ' ' . date('F j, Y, g:i a', $model->created_at) ?>
                </p>
                <p>
                    <?= $model->description ?>
                </p>


            </div>
        </div>
    </div>


</div>
