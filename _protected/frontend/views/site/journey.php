<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Journey');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
            <?= Html::a(Yii::t('app', 'All Locations'), Url::to('@web/locations'), ['class' => 'btn btn-primary']) ?>
        </span>
    </h1>
    <div class="clearfix"></div>
        <div class="col-lg-6 no-padding-left">
            <div class="well bs-component no-padding">
                <img src="<?= Url::to("@web/images/constant/anfahrt/dk.jpg") ?>" class="md-card-img" alt="Jodder">
                <div class="with-padding">
                    <h3>Dorfkrug Lübeck</h3>
                    <p>Der Dorfkrug wird uns vom <a href="http://www.heimrat-hl.de">Heimrat-HL</a> zur Verfügung
                        gestellt. Gemütliche Atmosphäre und studentische Preise. </p>
                    <p><strong>Adresse:</strong> Anschützstraße 11, 23562, Lübeck</p>
                    <p><strong>Erreichbarkeit:</strong> Bus 1 und 9, Haltestelle Fachhochschule.</p>

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2354.2822993737364!2d10.691940216015988!3d53.83784274548289!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47b209176ed6316b%3A0xe4edb3701bf81bb8!2sDorfkrug!5e0!3m2!1sde!2sus!4v1463038413235"
                    width="100%" height="450" frameborder="0" style="border:0" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
    <div class="col-lg-6 no-padding-left no-padding-right">
        <div class="well bs-component no-padding">
            <img src="<?= Url::to("@web/images/constant/anfahrt/gecko.jpg") ?>" class="md-card-img" alt="Jodder">
            <div class="with-padding">
                <h3>Gecko-Bar Hamburg</h3>
                <p>Die Geckobar, im Herzen ein Platz für Billardfreunde, bietet mannigfaltige Möglichkeiten,
                    Veranstaltungen jeder Art durchzuführen. <br> Mehr Informationen über die Location unter <a
                        href="www.gecko-bar.de">gecko-bar.de</a>.</p>
                <p><strong>Adresse:</strong> Von-Sauer-Straße 22, 22761 Hamburg</p>
                <p><strong>Erreichbarkeit:</strong> U-Bahn Station Bahrenfeld (S1 und S11) ca. 13 min Fußweg. Bus 2,
                    Haltestelle Von-Sauer-Straße ca. 4 min.
                </p>

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9478.11934298746!2d9.907356!3d53.56616!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xeef907069d0c3457!2sGecko-Bar!5e0!3m2!1sde!2sus!4v1463037299808"
                width="100%" height="450" frameborder="0" style="border:0" allowfullscreen=""></iframe>
        </div>
    </div>
</div>

</div>
