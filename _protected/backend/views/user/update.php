<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $role common\rbac\models\Role; */

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings')];
?>
<div class="user-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <div class="well">
                <?= $this->render('_form', [
                    'user' => $user,
                    'role' => $role,
                ]) ?>
            </div>
        </div>
    </div>
</div>
