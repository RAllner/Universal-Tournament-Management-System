<?php
namespace frontend\models;

use common\models\User;
use frontend\models\Player;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Yii;

/**
 * This is the model class for table "{{%halloffame}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $player_id
 * @property string $playername
 * @property string $achievements
 * @property string $description
 * @property integer $status
 * @property integer $category
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property Player $player
 */
class Halloffame extends ActiveRecord
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
    public $imageFile;


    /**
     * Declares the name of the database table associated with this AR class.
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%halloffame}}';
    }

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'playername', 'achievements', 'status'], 'required'],
            [['user_id', 'player_id', 'status', 'category'], 'integer'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['description', 'achievements'], 'string'],
            [['playername'], 'string', 'max' => 255]
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
     * Returns the attribute labels.
     *
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Creator'),
            'player_id' => Yii::t('app', 'Player'),
            'playername' => Yii::t('app', 'Name'),
            'achievements' => Yii::t('app', 'Achievements'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'category' => Yii::t('app', 'Category'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    public function upload()
    {

        if ($this->imageFile) {
            $path = Url::to('@webroot/images/halloffame/');
            $escapedTitle = $this->sanitize($this->playername);
            $filename = $this->created_at . $escapedTitle . '.jpg';
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
    public function rename($oldName, $newName)
    {
        $path = Url::to('@webroot/images/halloffame/');
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
        $status = (empty($status)) ? $this->status : $status;

        if ($status === self::STATUS_DRAFT) {
            return Yii::t('app', 'Draft');
        } else {
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
            self::STATUS_DRAFT => Yii::t('app', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('app', 'Published'),
        ];

        return $statusArray;
    }

    /**
     * Returns the article category in nice format.
     *
     * @param  null|integer $category Category integer value if sent to method.
     * @return string                 Nicely formatted category.
     */
    public function getCategoryName($category = null)
    {
        $category = (empty($category)) ? $this->category : $category;

        if ($category === self::CATEGORY_ESPORT) {
            return Yii::t('app', 'ESport');
        } elseif ($category === self::CATEGORY_GENERAL) {
            return Yii::t('app', 'General');
        } elseif ($category === self::CATEGORY_HEARTHSTONE) {
            return Yii::t('app', 'Hearthstone');
        } elseif ($category === self::CATEGORY_STARCRAFT) {
            return Yii::t('app', 'Starcraft');
        } elseif ($category === self::CATEGORY_WARCRAFT) {
            return Yii::t('app', 'Warcraft');
        } elseif ($category === self::CATEGORY_OVERWATCH) {
            return Yii::t('app', 'Overwatch');
        } elseif ($category === self::CATEGORY_DIABLO) {
            return Yii::t('app', 'Diablo');
        } else {
            return Yii::t('app', 'Other');
        }
    }

    public function getPlayersList()
    {
        $playerArray = null;
        $players = Player::find()->all();
        $playerArray = [];
        foreach ($players as $k => $v) {
            $playerArray = [$v['id'] => $v['name']];
        }

        return $playerArray;
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
            self::CATEGORY_GENERAL => Yii::t('app', 'General'),
            self::CATEGORY_HEARTHSTONE => Yii::t('app', 'Hearthstone'),
            self::CATEGORY_STARCRAFT => Yii::t('app', 'Starcraft'),
            self::CATEGORY_WARCRAFT => Yii::t('app', 'Warcraft'),
            self::CATEGORY_OVERWATCH => Yii::t('app', 'Overwatch'),
            self::CATEGORY_DIABLO => Yii::t('app', 'Diablo'),
            self::CATEGORY_OTHER => Yii::t('app', 'Other'),
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

    public function deleteImage()
    {
        $path = Url::to('@webroot/images/halloffame/');
        $escapedTitle = $this->sanitize($this->playername);
        $filename = $this->created_at . $escapedTitle . '.jpg';
        if (file_exists($path . $filename)) {
            unlink($path . $filename);
        }
    }

    public function getPhotoInfo()
    {
        $path = Url::to('@webroot/images/halloffame/');
        $url = Url::to('@web/images/halloffame/');
        $escapedTitle = $this->sanitize($this->playername);
        $filename = $this->created_at . $escapedTitle . '.jpg';
        $alt = $this->playername;

        $imageInfo = ['alt' => $alt];

        if (file_exists($path . $filename)) {
            $imageInfo['url'] = $url . $filename;
        } else {
            $imageInfo['url'] = $url . 'default.jpg';
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
    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $unwanted_array = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
            'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'Ğ' => 'G', 'İ' => 'I', 'Ş' => 'S', 'ğ' => 'g', 'ı' => 'i', 'ş' => 's', 'ü' => 'u');
        $string = strtr($string, $unwanted_array);
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

}
