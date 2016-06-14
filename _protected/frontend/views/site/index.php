<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */


$this->title = Yii::t('app', Yii::$app->name);


?>
<div class="site-index">
    <div class="col-md-8">
        <div class="jumbotron">
            <h1>UTMS Alpha 0.1</h1>

            <h2>Universal Tournament Management System</h2>

            <p class="lead">Wellcome
                <?php
                if (!Yii::$app->user->isGuest) {
                    echo "<b>" . Yii::$app->user->identity->username . "</b>";
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
    <div class="col-md-4">
        <div class="well bs-component no-padding">
            <p style="text-align: center" class="with-padding">
                <a href="https://www.facebook.com/BarCraftHL/" class="external-link"><i
                        class="fa fa-facebook-official" aria-hidden="true"></i></a>
                <a href="https://twitter.com/BarCraftHL" class="external-link"><i
                        class="fa fa-twitter-square" aria-hidden="true"></i></a>
                <a href="https://www.youtube.com/channel/UC6Hb-1s-cjpVVgBLvgijoRQ" class="external-link"><i
                        class="fa fa-youtube-square" aria-hidden="true"></i></a>
                <a href="https://www.twitch.tv/barcrafthl" class="external-link"><i
                        class="fa fa-twitch" aria-hidden="true"></i></a>
                <a href="http://bchl.challonge.com/" class="external-link">
                    <object href="http://bchl.challonge.com/" type="image/svg+xml" style="height: 1em"
                            data="<?= Url::to('@web/images/constant/icons/challonge.svg') ?>">Your browser does not
                        support SVGs
                    </object>
                </a>
                <a href="http://wiki.teamliquid.net/hearthstone/Dorfkrug_Cup" class="external-link">
                    <object type="image/svg+xml" style="height: 1em"
                            data="<?= Url::to('@web/images/constant/icons/liquidpedias.svg') ?>">Your browser does not
                        support SVGs
                    </object>
                </a>
            </p>
        </div>

        <a class="twitter-timeline"
           data-widget-id="643309100416278528"
           href="https://twitter.com/BarCraftHL"
           data-screen-name="BarCraftHL">
            Tweets by @BarCraftHL

        </a>
        <script>!function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + "://platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, "script", "twitter-wjs");</script>
    </div>
</div>
</div>


