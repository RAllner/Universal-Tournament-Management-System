<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 02.06.2016
 * Time: 15:11
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Galleries */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app', 'Update Gallery') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

    if(!$model->isNewRecord) {
        $imageInfos = $model->ImageInfos;
        $imageCount = $model->ImageCount;
        $options = ['data-lightbox'=>'gallery-image'];

        for ($i = 0; $i <= $imageCount-1; $i++) {

            echo '<div class="col-lg-3"><a href="'.$imageInfos['imageUrls'][$i].'" data-lightbox="gallery" ><img src="'.$imageInfos['imageUrls'][$i].'" style="max-height:150px; max-width:100%"/></a>';
            echo '</br><div class="btn btn-danger" >Delete</div></div>';
            if(($i ==3 ) || ($i>3 && (($i+1) % 4 == 0))){
                echo '<div class="clearfix"></div>';
            }
        }
    }

    ?>