<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>UTMS Alpha 0.1</h1>
        <h2>Universal Tournament Management System</h2>

        <p class="lead">Wellcome
            <?php
                if(!Yii::$app->user->isGuest) {
                    echo "<b>".Yii::$app->user->identity->username."</b>";
                }
            ?>
             on the new Platform for your Tournament!</p>
        </br>
        <?php
        if (Yii::$app->user->isGuest) {

            ?>


            <div class="btn-group">
                <a class="btn btn-primary" href="site/login">Login</a>
                <a class="btn btn-default" href="site/signup">Signup</a>
            </div>
            <?php
        }
        ?>
    </div>

    </div>
</div>


