<?php

namespace frontend\models;

use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Yii;

/**
 * This is the model class for table "galleries".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $summary
 * @property integer $status
 * @property integer $category
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Galleries extends ActiveRecord
{


    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;

    const CATEGORY_ESPORT = 1;
    const CATEGORY_GENERAL = 2;
    const CATEGORY_HEARTHSTONE = 3;
    const CATEGORY_STARCRAFT = 4;
    const CATEGORY_WARCRAFT = 5;
    const CATEGORY_OVERWATCH = 6;
    const CATEGORY_DIABLO = 7;
    const CATEGORY_OTHER = 8;

    /**
     * @var UploadedFile
     */
    public $imageFiles;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%galleries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'summary', 'status'], 'required'],
            [['user_id', 'status', 'category'], 'integer'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 0],
            [['summary'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }


    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Creator'),
            'title' => Yii::t('app', 'Title'),
            'summary' => Yii::t('app', 'Summary'),
            'status' => Yii::t('app', 'Status'),
            'category' => Yii::t('app', 'Category'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    public function upload()
    {

        if ($this->validate()) {
            $i = 0;
            $escapedTitle = $this->sanitize($this->title);
            $path = Url::to('@webroot/images/galleries/'.$this->created_at.$escapedTitle);
            $pathToImages = $path.'/images';
            $pathToThumbs = $path.'/thumbs';
            if (!file_exists($path)) {
                mkdir($path, 0777);
                mkdir($pathToImages, 0777);
                mkdir($pathToThumbs, 0777);
            }else {
                $oldImageFiles = scandir($pathToImages);
                $i = count($oldImageFiles)-2;
            }
            foreach ($this->imageFiles as $file) {
                $filename = $i.'.'.$file->extension;
                $file->saveAs($pathToImages . '/' . $filename);
                if($file->extension == 'png') {
                    $this->png2jpg($pathToImages . '/' , $filename);
                }
                $i++;
            }
            $this->createThumbs($pathToImages, $pathToThumbs, 64);

            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $oldDirName
     * @param $newDirName
     */
    public function rename($oldDirName, $newDirName){
        $path = Url::to('@webroot/images/galleries/');
        $escapedNewName = $this->sanitize($newDirName);
        $escapedOldName = $this->sanitize($oldDirName);
        if (file_exists($path.$this->created_at.$escapedOldName) && is_dir($path.$this->created_at.$escapedOldName)) {
            if (rename($path . $this->created_at . $escapedOldName, $path . $this->created_at . $escapedNewName)) {
                Yii::$app->session->setFlash('success', 'Gallery directory name changed to ' . $escapedNewName);
            } else {
                Yii::$app->session->setFlash('error', 'Gallery directory name not changed from' . $escapedOldName . ' to ' . $escapedNewName);
            }
        }
    }




    function png2jpg($originalFilePath, $filename) {
            $info = pathinfo($originalFilePath.$filename);
            $image = imagecreatefrompng($originalFilePath.$filename);
            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
            imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
            imagealphablending($bg, TRUE);
            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            imagedestroy($image);
            $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file
            $newFilePath = $originalFilePath. $info['filename'] . '.jpg';
            imagejpeg($bg, $newFilePath , $quality);
            imagedestroy($bg);
            unlink($originalFilePath.$filename);
            return true;
    }



    function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth )
    {
        $pathToImages = $pathToImages.'/';
        $pathToThumbs = $pathToThumbs.'/';

        // open the directory
        $dir = opendir( $pathToImages );

        // loop through it, looking for any/all JPG files:
        while (false !== ($fname = readdir( $dir ))) {
            // parse path for the extension
            $info = pathinfo($pathToImages . $fname);
            // continue only if this is a JPEG image
            if ( strtolower($info['extension']) == 'jpg' )
            {
                // load image and get image size
                $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
                $width = imagesx( $img );
                $height = imagesy( $img );

                // calculate thumbnail size
                $new_width = $thumbWidth;
                $new_height = floor( $height * ( $thumbWidth / $width ) );

                // create a new temporary image
                $tmp_img = imagecreatetruecolor( $new_width, $new_height );

                // copy and resize old image into new image
                imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

                // save thumbnail into a file
                imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
            }
        }
        // close the directory
        closedir( $dir );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets the id of the article creator.
     * NOTE: needed for RBAC Author rule.
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->user_id;
    }

    /**
     * Gets the author name from the related User table.
     *
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->user->username;
    }

    /**
     * Returns the gallery status in nice format.
     *
     * @param  null|integer $status Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getStatusName($status = null)
    {
        $status = (empty($status)) ? $this->status : $status ;

        if ($status === self::STATUS_DRAFT)
        {
            return Yii::t('app', 'Draft');
        }
        else
        {
            return Yii::t('app', 'Published');
        }
    }


    /**
     * Returns the array of possible article status values.
     *
     * @return array
     */
    public function getStatusList()
    {
        $statusArray = [
            self::STATUS_DRAFT     => Yii::t('app', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('app', 'Published'),
        ];

        return $statusArray;
    }


    /**
     * Returns the gallery category in nice format.
     *
     * @param  null|integer $category Category integer value if sent to method.
     * @return string                 Nicely formatted category.
     */
    public function getCategoryName($category = null)
    {
        $category = (empty($category)) ? $this->category : $category ;

        if ($category === self::CATEGORY_ESPORT)
        {
            return Yii::t('app', 'ESport');
        }
        elseif ($category === self::CATEGORY_GENERAL)
        {
            return Yii::t('app', 'General');
        }
        elseif ($category === self::CATEGORY_HEARTHSTONE)
        {
            return Yii::t('app', 'Hearthstone');
        }
        elseif ($category === self::CATEGORY_STARCRAFT)
        {
            return Yii::t('app', 'Starcraft');
        }
        elseif ($category === self::CATEGORY_WARCRAFT)
        {
            return Yii::t('app', 'Warcraft');
        }
        elseif ($category === self::CATEGORY_OVERWATCH)
        {
            return Yii::t('app', 'Overwatch');
        }
        elseif ($category === self::CATEGORY_DIABLO)
        {
            return Yii::t('app', 'Diablo');
        }
        else
        {
            return Yii::t('app', 'Other');
        }
    }


    /**
     * Returns the array of possible article category values.
     *
     * @return array
     */
    public function getCategoryList()
    {
        $statusArray = [
            self::CATEGORY_ESPORT => Yii::t('app', 'ESport'),
            self::CATEGORY_GENERAL  => Yii::t('app', 'General'),
            self::CATEGORY_HEARTHSTONE => Yii::t('app', 'Hearthstone'),
            self::CATEGORY_STARCRAFT   => Yii::t('app', 'Starcraft'),
            self::CATEGORY_WARCRAFT   => Yii::t('app', 'Warcraft'),
            self::CATEGORY_OVERWATCH   => Yii::t('app', 'Overwatch'),
            self::CATEGORY_DIABLO   => Yii::t('app', 'Diablo'),
            self::CATEGORY_OTHER  => Yii::t('app', 'Other'),
        ];
        return $statusArray;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->upload();
            return true;
        } else {
            return false;
        }
    }


    /**
     *
     */
    public function deleteImage($imageNr){
        $escapedTitle = $this->sanitize($this->title);
        $path = Url::to('@webroot/images/galleries/'.$this->created_at.$escapedTitle);
        $pathToImages = $path.'/images/';
        $pathToThumbs = $path.'/thumbs/';

        unlink($pathToImages.$imageNr.'.jpg');
        unlink($pathToThumbs.$imageNr.'.jpg');

        for($i = $imageNr+1; $i<$this->getImageCount()+1; $i++){
            rename($pathToImages.$i.".jpg", $pathToImages.($i-1).".jpg");
            rename($pathToThumbs.$i.".jpg", $pathToThumbs.($i-1).".jpg");
        }
    }


    /**
     * @return mixed
     */
    public function getImageCount(){
        $escapedTitle = $this->sanitize($this->title);
        $path = Url::to('@webroot/images/galleries/'.$this->created_at.$escapedTitle.'/images');
        if(file_exists($path))
        return $countedImages = count(scandir($path)) - 2;
        else return 0;
    }


    public function getImageInfos()
    {

        $escapedTitle = $this->sanitize($this->title);
        $path = Url::to('@webroot/images/galleries/'.$this->created_at.$escapedTitle);
        $url = Url::to('@web/images/galleries/'.$this->created_at.$escapedTitle);
        $pathToImages = $path.'/images';


        for ($i = 0; $i <= $this->getImageCount(); $i++) {
            $imageInfos['imageUrls'][$i]= $url.'/images/'.$i.'.jpg';
            $imageInfos['thumbsUrls'][$i]= $url.'/thumbs/'.$i.'.jpg';
        }


        return $imageInfos;
    }


    /**
     * Function: sanitize
     * Returns a sanitized string, typically for URLs.
     *
     * Parameters:
     *     $string - The string to sanitize.
     *     $force_lowercase - Force the string to lowercase?
     *     $anal - If set to *true*, will remove all non-alphanumeric characters.
     */
    function sanitize($string, $force_lowercase = true, $anal = false) {
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'Ğ'=>'G', 'İ'=>'I', 'Ş'=>'S', 'ğ'=>'g', 'ı'=>'i', 'ş'=>'s', 'ü'=>'u' );
        $string = strtr( $string, $unwanted_array );

        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

}
