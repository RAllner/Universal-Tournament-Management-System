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
$isOwner = Yii::$app->user->can('updateOrganisation', ['model' => $model]);
$isAdmin = $model->isUserAdmin();
?>
<div class="organisation-view">

    <h1><?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?php if ($isOwner): ?>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php endif ?>
            <?php if (Yii::$app->user->can('deleteOrganisation', ['model' => $model])): ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this Organisation?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>
    <div class="well">
        <div class="media">
            <div class="media-left">

                    <img class="media-object" style="width:150px" src="<?= $photoInfo['url'] ?>"
                         alt="<?= $model->name ?>">

            </div>
            <div class="media-body media-middle">
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Owner') . ' ' . $model->authorName ?>
                            <i class="material-icons">schedule</i> <?= Yii::t('app', 'Created on') . ' ' . date('F j, Y, g:i a', $model->created_at) ?>
                        </p>
                        <p>
                            <?= $model->description ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <table class="col-md-12">
                            <thead>
                            <tr>
                                <th>
                                    <?= Yii::t('app', 'User') ?>
                                </th>
                                <th>
                                    <?= Yii::t('app', 'Joined') ?>
                                </th>
                                <th>
                                    <?= Yii::t('app', 'Admin') ?>
                                </th>
                                <?php
                                if ($isOwner || $isAdmin): ?>
                                    <th>
                                        <i class="material-icons">remove</i>
                                    </th>
                                <?php endif ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            foreach ($model->organisationHasUsers as $ouser) {
                                $user = User::find()->where(['id' => $ouser->user_id])->one();
                                $admin = '';
                                if ($ouser->admin == 1 || $model->user_id == $user->id) {
                                    if ($isAdmin || $isOwner) {
                                        $admin = Yii::t('app', 'Yes'). Html::a(' <i class="material-icons">do_not_disturb</i>', Url::to(['set-member-admin', 'id' => $model->id, 'memberID' => $ouser->user_id , 'set' => 0]));
                                    } else {
                                        $admin = Yii::t('app', 'Yes');
                                    }
                                } else {
                                    if ($isAdmin || $isOwner) {
                                        $admin = Html::a(' <i class="material-icons">done</i>', Url::to(['set-member-admin', 'id' => $model->id, 'memberID' => $ouser->user_id , 'set' => 1]));
                                    }
                                }
                                echo '<tr>';
                                echo "<th>" . $user->username;
                                if ($model->user_id == $user->id) {
                                    echo " (" . Yii::t('app', 'Owner') . ") ";
                                }
                                echo "</th><td>" . date('d.m.Y', $model->created_at) . "</td><td>" . $admin . "</td>";
                                if (Yii::$app->user->can('updateOrganisation', ['model' => $model]) || $isAdmin){
                                    echo '<td>' . Html::a('<i class="material-icons">remove</i>', Url::to(['remove-member', 'id' => $model->id, 'memberID' => $ouser->user_id])) . '</td>';
                                }
                                echo '</tr>';
                            }; ?>
                            </tbody>
                        </table>
                        <?php if ($isOwner || $isAdmin): ?>
                        <div class="pull-right">
                        <?= Html::a(Yii::t('app', 'Add User'), Url::to(['organisation/add', 'id' => $model->id]), ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>