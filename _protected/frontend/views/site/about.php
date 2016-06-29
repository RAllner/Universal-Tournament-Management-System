<?php
use yii\helpers\Html;
use yii\helpers\Url;



function age($birthDate){
  //date in mm/dd/yyyy format; or it can be in other formats as well
  //explode the date to get month, day and year
  $birthDate = explode("/", $birthDate);
  //get age from date or birthdate
    return (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
      ? ((date("Y") - $birthDate[2]) - 1)
      : (date("Y") - $birthDate[2]));
}


/* @var $this yii\web\View */

$this->title = Yii::t('app', 'About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about" xmlns="http://www.w3.org/1999/html">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-12 well bs-component no-padding">
        <img width="100%" style="margin-bottom: 1em" src="<?= Url::to("@web/images/constant/team/Gruppenfoto.jpg") ?>"/>
        <div class="with-padding">
            <h2>BarCraft HL</h2>
            <p>ist eine studentische und ehrenamtliche Organisation die sich dem E-Sport verschrieben hat.
                Angefangen mit Übertragungen der ESL Turniere in gemütlicher Bar Atmosphäre, richtet das Team
                mittlerweile
                verschiedenste Turniere mit mehr als 40 Teilnehmern aus allen Regionen Deutschlands aus. BarCraft HL ist
                non-profit orientiert und alle Einnahmen fließen direkt in Preise, Geschenke, Werbemaßnahmen und erhöhen
                der
                Veranstaltungsqualität.</p>
        </div>
    </div>

    <div class="row">
    <div class="col-lg-4 col-md-6 col-md-6">
        <div class="well bs-component no-padding">
            <img src="<?= Url::to("@web/images/constant/team/Jodder.jpg") ?>" class="md-card-img" alt="Jodder">
            <div class="with-padding">
                <h3>Jodder</h3>
                <p>
                    <strong>Vorname:</strong> Jasper </br>
                    <strong>Alter:</strong> 26 </br>
                    <strong>Beruf:</strong> Informatiker</br>
                    <strong>Rolle:</strong> Orga, PR, Soziale Medien, Streaming</br>
                    <strong>Mail:</strong> <a class="contact-mail ng-binding" ng-href="mailto:jodder@barcraft-hl.de"
                                              href="mailto:jodder@barcraft-hl.de">jodder@barcraft-hl.de</a> </br>
                </p>
                <p>Als Kanzler und ich 2013 auf battle.net einen Aufruf entdeckten BarCrafts zu veranstalten, stand für
                    mich
                    sofort fest, dass dies mein Baby werden sollte. </p>
                <p>Ich kümmere mich um die Veranstaltungsorganisation und -koordination und Leite die Turniere. Auch die
                    Planung
                    der jeweiligen Seasons geht komplett über meinen Tisch.</p>
                <p> Mein Ziel für BarCraftHL: Maximaler eSport bei minimalem Stress (That's still a work in progress ;)
                    ) und
                    Kanzler in den Wahnsinn treiben.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="well bs-component no-padding">
            <img src="<?= Url::to("@web/images/constant/team/Kanzler.jpg") ?>" class="md-card-img" alt="Jodder">
            <div class="with-padding">
                <h3>Kanzler</h3>
                <p>
                    <strong>Vorname:</strong> Raphael</br>
                    <strong>Alter:</strong> <?= age("07/28/1990") ?> </br>
                    <strong>Beruf:</strong> Informatiker</br>
                    <strong>Rolle:</strong> Orga, Website PR, Soziale Medien, Streaming</br>
                    <strong>Mail:</strong> <a href="mailto:kanzler@barcraft-hl.de">kanzler@barcraft-hl.de</a> </br>
                </p>
                <p>Ich kümmere mich um die Webseite und alle Designaufgaben wie Plakate, Logos, Aushänge, etc. Bei den
                    Turnieren helfe bei der Organisation und kümmere mich um die Technik und unseren Livestream. Ich bin
                    selbst leidenschaftlicher E-Sport-Fan und habe damals erfolgreich CS Source gespielt. Derzeit spiele
                    ich aktiv: Heroes of the Storm, CS:GO, Starcraft 2 und vieles mehr.</p>
                <p>Mein Ziel für BarCraftHL: Think big, become bigger. GG</p>
            </div>
        </div>
    </div>
        <div class="clearfix hidden-lg"></div>
    <div class="col-lg-4 col-md-6">
        <div class="well bs-component no-padding">
            <img src="<?= Url::to("@web/images/constant/team/Zersch.jpg") ?>" class="md-card-img" alt="Jodder">
            <div class="with-padding">
                <h3>Zersch</h3>
                <p>
                    <strong>Vorname:</strong> Tim</br>
                    <strong>Alter:</strong> 29 </br>
                    <strong>Beruf:</strong> Student</br>
                    <strong>Rolle:</strong> Tresen, Aufbau Lokation</br>
                    <strong>Mail:</strong> <a href="mailto:zersch@barcraft-hl.de">zersch@barcraft-hl.de</a> </br>
                </p>
                <p>Ich habe schon in jungen Jahren angefangen zu zocken. Meine ersten Erfahrungen machte ich mit
                    Counterstrike, Warcraft und Diablo. Damals besuchte ich sehr gerne Lan-Partys, leider finden diese
                    so nur noch selten statt. Ich war und bin kein Profi, aber das war auch nie mein Ziel. Für mich war
                    es immer wichtiger Spaß zu haben. Die Turniere lassen alte Zeiten wiederaufleben. BarCraft- oder
                    BarStone-Events zu veranstalten macht mir Freude, vor allem wenn ich sehe, dass ihr daran genauso
                    viel Spaß habt wie wir.</p>
            </div>
        </div>
    </div>
    <div class="clearfix hidden-md"></div>
    <div class="col-lg-4 col-md-6">
        <div class="well bs-component no-padding">
            <img src="<?= Url::to("@web/images/constant/team/NiWo.jpg") ?>" class="md-card-img" alt="Jodder">
            <div class="with-padding">
                <h3>NiWo</h3>
                <p>
                    <strong>Vorname:</strong>Nicklas</br>
                    <strong>Alter:</strong> 23 </br>
                    <strong>Beruf:</strong> Hörakustiker</br>
                    <strong>Rolle:</strong> Casting, Tresen, Aufbau Lokation</br>
                    <strong>Mail:</strong> <a href="mailto:niwo@barcraft-hl.de">niwo@barcraft-hl.de</a> </br>
                </p>
                <p>Ein paar Worte zu meiner Person:</p>
                <p>Von 2008 bis 2011 spielte ich als Pro bei <em>Meet Your Makers</em> im Dota 1 Squad. In dieser Zeit
                    waren wir auch sehr erfolgreich, leider fehlte mir im Verlauf die Zeit um weiter zu machen. Als Dota
                    2 erschien, trat ich der <em>Dota Athletes Liga</em> als Caster bei. Hier arbeite ich bis Heute als
                    Caster und Streamer im MOBA Berreich (DOTA 2). </p>
                <p>Ich bin ein sehr begeisteter Gamer und als die Möglichkeit aufkam hier in Lübeck ebenfalls in diesem
                    Bereich tätig zu werden, habe ich diese sofort ergriffen. Ich spiele selber leidenschaftlich
                    Hearthstone, daher passt das für mich sehr gut zusammen.</p> Ich hoffe, dass ich BarCraft HL im
                Bereich Casting in die nächste Ära führen kann. Die Live Events sind für mich immer ein schönes
                Erlebnis, da das <em>Wir-Gefühl</em> unter den Gamern gestärkt wird. <p>In diesem Sinne:</p>
                <p><em>~Gaming is love, Gaming is life!~</em></p>
            </div>
        </div>
    </div>
        <div class="clearfix hidden-lg"></div>
    <div class="col-lg-4 col-md-6">
        <div class="well bs-component no-padding">
            <img src="<?= Url::to("@web/images/constant/team/TyphoonHawk.jpg") ?>" class="md-card-img" alt="Jodder">
            <div class="with-padding">
                <h3>TyphoonHawk</h3>
                <p>
                    <strong>Vorname:</strong>Jonas</br>
                    <strong>Alter:</strong> 26 </br>
                    <strong>Beruf:</strong> Informatiker</br>
                    <strong>Rolle:</strong> Orga, PR, Soziale Medien, Streaming</br>
                    <strong>Mail:</strong> <a class="contact-mail ng-binding" ng-href="mailto:jodder@barcraft-hl.de"
                                              href="mailto:jodder@barcraft-hl.de">jodder@barcraft-hl.de</a> </br>
                </p>
                <p>E-Sports Turniere zu verfolgen macht mir viel Spaß. Daher freut es mich durch Barcraft dieses Hobby
                    mit anderen zu teilen.</p>
                <p>Ich selbst spiele Starcraft, Heroes of the Storm und Hearthstone. Gelgentlich nehme ich auch an
                    Turnieren teil.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="well bs-component no-padding">
            <img src="<?= Url::to("@web/images/constant/team/Haruc.jpg") ?>" class="md-card-img" alt="Jodder">
            <div class="with-padding">
                <h3>Haruc</h3>
                <p>
                    <strong>Vorname:</strong>Gregor</br>
                    <strong>Alter:</strong> 23 </br>
                    <strong>Beruf:</strong> Lasertechniker</br>
                    <strong>Rolle:</strong> Casting, Aufbau Lokation, Streaming, PR</br>
                    <strong>Mail:</strong> <a href="mailto:haruc@barcraft-hl.de">haruc@barcraft-hl.de</a> </br>
                </p>
                <p>Was ist E-Sport?</p>
                <p>Es ist für mich nicht nur eine Chance in seinem strukturellen, strategischen und kreativen Denken
                    über sich hinaus zu wachsen, sondern ebenso das Spiel, den Wettbewerb und das Teamgefühl mit anderen
                    Spielern gebannt zu verfolgen und zu genießen.</p>
                <p>Begonnen habe ich damals mit Warcraft III sowie CS 1.6 und spiele nun aktiv Starcraft II, Heroes of
                    the Storm und Hearthstone. Aktuell kümmere ich mich bei den Barcrafts mit um den Aufbau und um
                    Nebenorganisatorisches während der Events. Dabei versuche ich stets aus der Distanz (Hamburg) eine
                    Konstante im Uhrwerk des BarCraft HLs zu sein.</p>
            </div>
        </div>
    </div>
</div>
</div>
