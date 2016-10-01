<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-account', 
    'token' => $user->account_activation_token]);
?>
<p>
<?= Yii::t('app','Hello') ?> <?= Html::encode($user->username) ?>,
</p>
<p>
<?= Yii::t('app','Follow this link to activate your account:') ?>
</p>
<p>
<?= Html::a('Please, click here to activate your account.', $resetLink) ?>
</p>
