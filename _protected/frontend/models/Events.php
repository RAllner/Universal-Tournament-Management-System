<?php

namespace frontend\models;

use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Yii;

/**
 * This is the model class for table "{{%events}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $locations_id
 * @property integer $tournaments_id
 * @property string $name
 * @property string $description
 * @property integer $type
 * @property string $startdate
 * @property string $enddate
 * @property string $game
 * @property string $partners
 * @property string $facebook
 * @property string $eventpage
 * @property string $liquidpedia
 * @property string $challonge
 * @property integer $status
 * @property integer $category
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Location $location
 * @property User $user
 */
class Events extends ActiveRecord
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

    const TYPE_TOURNAMENT = 0;
    const TYPE_BROADCAST = 1;
    const TYPE_MEETING = 2;
    const TYPE_OTHER = 3;


    /**
     * @var UploadedFile
     */
    public $imageFile;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%events}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'locations_id', 'name', 'type', 'startdate', 'status', 'category'], 'required'],
            [['user_id', 'locations_id', 'tournaments_id', 'type', 'status', 'category'], 'integer'],
            [['description'], 'string'],
            [['startdate', 'enddate'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['name', 'game', 'partners'], 'string', 'max' => 255],
            [['facebook', 'liquidpedia', 'challonge', 'eventpage'], 'url', 'validSchemes' => ['http', 'https']],
            [['locations_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['locations_id' => 'id']],
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
            'user_id' => Yii::t('app', 'Owner'),
            'locations_id' => Yii::t('app', 'Location'),
            'tournaments_id' => Yii::t('app', 'Tournament'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'type' => Yii::t('app', 'Type'),
            'startdate' => Yii::t('app', 'Startdate'),
            'enddate' => Yii::t('app', 'Enddate'),
            'game' => Yii::t('app', 'Game'),
            'partners' => Yii::t('app', 'Partners'),
            'eventpage' => Yii::t('app', 'Event Page'),
            'facebook' => Yii::t('app', 'Facebook'),
            'liquidpedia' => Yii::t('app', 'Liquidpedia'),
            'challonge' => Yii::t('app', 'Challonge'),
            'status' => Yii::t('app', 'Status'),
            'category' => Yii::t('app', 'Category'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    /**
     * Uploads the given ImageFile and save it with a sanitized title
     *
     * @return bool
     */
    public function upload()
    {

        if ($this->imageFile) {
            $path = Url::to('@webroot/images/events/');
            $escapedTitle = $this->sanitize($this->name);
            $filename = $this->created_at.$escapedTitle.'.jpg';
            $this->imageFile->saveAs($path . $filename);
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $oldName
     * @param $newName
     */
    public function rename($oldName, $newName){
        $path = Url::to('@webroot/images/events/');
        $escapedNewName = $this->sanitize($newName);
        $escapedOldName = $this->sanitize($oldName);
        if (file_exists($path . $this->created_at . $escapedOldName . '.jpg')) {
            if (rename($path . $this->created_at . $escapedOldName . '.jpg', $path . $this->created_at . $escapedNewName . '.jpg')) {
                Yii::$app->session->setFlash('success', 'Filename changed to ' . $escapedNewName . '.jpg');
            } else {
                Yii::$app->session->setFlash('error', 'Filename not changed from' . $escapedOldName . '.jpg' . ' to ' . $escapedNewName . '.jpg');
            }
        }
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

    public function deleteImage(){
        $path = Url::to('@webroot/images/events/');
        $escapedTitle = $this->sanitize($this->name);
        $filename = $this->created_at.$escapedTitle.'.jpg';
        if(file_exists($path.$filename)){
            unlink($path.$filename);
        }
    }

    public function getPhotoInfo()
    {
        $path = Url::to('@webroot/images/events/');
        $url = Url::to('@web/images/events/');
        $escapedTitle = $this->sanitize($this->name);
        $filename = $this->created_at.$escapedTitle.'.jpg';
        $alt = $this->name;

        $imageInfo = ['alt'=> $alt];

        if (file_exists($path . $filename)) {
            $imageInfo['url'] = $url.$filename;
        } else {
            $imageInfo['url'] = $url.'default.jpg';
        }

        return $imageInfo;
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


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'locations_id']);
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
     * Returns the article status in nice format.
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
     * Returns the article status in nice format.
     *
     * @param  null|integer $status Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getTypeName($type = null)
    {
        $type = (empty($type)) ? $this->type : $type ;

        if ($type === self::TYPE_TOURNAMENT)
        {
            return Yii::t('app', 'Tournament');
        }
        elseif ($type === self::TYPE_BROADCAST)
        {
            return Yii::t('app', 'Broadcast');
        }
        elseif ($type === self::TYPE_MEETING)
        {
            return Yii::t('app', 'Meeting');
        }
        elseif ($type === self::TYPE_OTHER)
        {
            return Yii::t('app', 'Other');
        }
    }

    /**
     * Returns the array of possible article status values.
     *
     * @return array
     */
    public function getTypeList()
    {
        $typeArray = [
            self::TYPE_TOURNAMENT     => Yii::t('app', 'Tournament'),
            self::TYPE_BROADCAST => Yii::t('app', 'Broadcast'),
            self::TYPE_MEETING => Yii::t('app', 'Meeting'),
            self::TYPE_OTHER => Yii::t('app', 'Other'),
        ];

        return $typeArray;
    }

    /**
     * Returns the article category in nice format.
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


}
