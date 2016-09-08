<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%player}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $running_nr
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_flag
 * @property string $description
 * @property string $games
 * @property string $website
 * @property string $stream
 * @property integer $gender
 * @property string $languages
 * @property integer $birthday
 * @property string $nation
 *
 *
 * @property Halloffame[] $halloffames
 * @property User $user
 */
class Player extends ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $imageFile;

    const GENDER_MALE = 2;
    const GENDER_FEMALE = 1;
    const GENDER_OTHER = 0;

    const DE = 1;
    const GB = 2;
    const RU = 3;
    const FR = 4;
    const DK = 5;
    const AT = 6;
    const CH = 7;
    const ES = 8;
    const PL = 9;
    const EU = 10;
    const UK = 11;
    const SE = 12;
    const SI = 13;
    const BE = 14;
    const NL = 15;
    const US = 16;
    const NONATION = 0;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%player}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'running_nr','nation'], 'required'],
            [['user_id', 'running_nr', 'gender'], 'integer'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['name'], 'string', 'max' => 255],
            [['description', 'games', 'languages', 'stream', 'nation'], 'string'],
            [['birthday'], 'safe'],
            [['website'], 'url', 'validSchemes' => ['http', 'https']],
            [['deleted_flag'], 'integer', 'max' => 1],
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
            'name' => Yii::t('app', 'Name'),
            'running_nr' => Yii::t('app', 'Running Nr'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_flag' => Yii::t('app', 'Deleted'),
            'description' => Yii::t('app', 'Description'),
            'games' => Yii::t('app', 'Games'),
            'website' => Yii::t('app', 'Website'),
            'stream' => Yii::t('app', 'Twitch Channel Name'),
            'gender' => Yii::t('app', 'Gender'),
            'languages' => Yii::t('app', 'Languages'),
            'birthday' => Yii::t('app', 'Age'),
            'nation' => Yii::t('app', 'Nationality'),
        ];
    }


    public function upload()
    {

        if ($this->imageFile) {
            $path = Url::to('@webroot/images/players/');
            $escapedTitle = $this->sanitize($this->name);
            $filename = $this->created_at . $escapedTitle . '.jpg';
            $this->imageFile->saveAs($path . $filename);
            $this->makeRect($path . $filename);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $path
     */
    public function makeRect($path)
    {
        //getting the image dimensions
        list($width, $height) = getimagesize($path);

        //saving the image into memory (for manipulation with GD Library)
        $myImage = imagecreatefromjpeg($path);

        // calculating the part of the image to use for thumbnail
        if ($width > $height) {
            $y = 0;
            $x = ($width - $height) / 2;
            $smallestSide = $height;
        } else {
            $x = 0;
            $y = ($height - $width) / 2;
            $smallestSide = $width;
        }

        $imageSize = 250;
        $image = imagecreatetruecolor($imageSize, $imageSize);
        imagecopyresampled($image, $myImage, 0, 0, $x, $y, $imageSize, $imageSize, $smallestSide, $smallestSide);

        //final output
        header('Content-type: image/jpeg');
        imagejpeg($image, $path, 80);
    }

    /**
     * @param $oldName
     * @param $newName
     */
    public function rename($oldName, $newName)
    {
        $path = Url::to('@webroot/images/players/');
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
     * Returns the nation of the player in nice format.
     *
     * @param  null|integer $nation Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getNationName($nation = null)
    {
        $nation = (empty($nation)) ? $this->nation : $nation;

        if ($nation === self::DE) {
            return Yii::t('app', 'German');
        } elseif ($nation === self::GB) {
            return Yii::t('app', 'British');
        } elseif ($nation === self::RU) {
            return Yii::t('app', 'Russian');
        } elseif ($nation === self::FR) {
            return Yii::t('app', 'French');
        } elseif ($nation === self::DK) {
            return Yii::t('app', 'Danish');
        } elseif ($nation === self::AT) {
            return Yii::t('app', 'Austrian');
        } elseif ($nation === self::CH) {
            return Yii::t('app', 'Swiss');
        } elseif ($nation === self::ES) {
            return Yii::t('app', 'Spanish');
        } elseif ($nation === self::PL) {
            return Yii::t('app', 'Polish');
        } elseif ($nation === self::EU) {
            return Yii::t('app', 'European');
        } elseif ($nation === self::SE) {
            return Yii::t('app', 'Swedish');
        } elseif ($nation === self::SI) {
            return Yii::t('app', 'Sloven');
        } elseif ($nation === self::BE) {
            return Yii::t('app', 'Belgian');
        } elseif ($nation === self::NL) {
            return Yii::t('app', 'Dutch');
        } elseif ($nation === self::US) {
            return Yii::t('app', 'American');
        } else {
            return Yii::t('app', 'Undefined');
        }
    }

    /**
     * Returns the nation of the player in nice format.
     *
     * @param  null|integer $gender Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getGenderName($gender = null)
    {
        $gender = (empty($gender)) ? $this->gender : $gender;

        if ($gender === self::GENDER_FEMALE) {
            return Yii::t('app', 'Female');
        } else if ($gender === self::GENDER_OTHER) {
            return Yii::t('app', 'Other');
        } else {
            return Yii::t('app', 'Male');
        }
    }


    /**
     * Returns the nation of the player in nice format.
     *
     * @param  null|integer $nation Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getNationShort($nation = null)
    {
        $nation = (empty($nation)) ? $this->nation : $nation;

        if ($nation === self::DE) {
            return Yii::t('app', 'de');
        } elseif ($nation === self::GB) {
            return Yii::t('app', 'gb');
        } elseif ($nation === self::RU) {
            return Yii::t('app', 'ru');
        } elseif ($nation === self::FR) {
            return Yii::t('app', 'fr');
        } elseif ($nation === self::DK) {
            return Yii::t('app', 'dk');
        } elseif ($nation === self::AT) {
            return Yii::t('app', 'at');
        } elseif ($nation === self::CH) {
            return Yii::t('app', 'ch');
        } elseif ($nation === self::ES) {
            return Yii::t('app', 'es');
        } elseif ($nation === self::PL) {
            return Yii::t('app', 'pl');
        } elseif ($nation === self::EU) {
            return Yii::t('app', 'eu');
        } elseif ($nation === self::SE) {
            return Yii::t('app', 'se');
        } elseif ($nation === self::SI) {
            return Yii::t('app', 'si');
        } elseif ($nation === self::BE) {
            return Yii::t('app', 'be');
        } elseif ($nation === self::NL) {
            return Yii::t('app', 'nl');
        } elseif ($nation === self::US) {
            return Yii::t('app', 'us');
        } else {
            return Yii::t('app', 'WO');
        }
    }

    /**
     * Returns the array of possible article status values.
     *
     * @return array
     */
    public function getNationList()
    {
        $nationArray = [
            self::DE => Yii::t('app', 'German'),
            self::GB => Yii::t('app', 'British'),
            self::RU => Yii::t('app', 'Russian'),
            self::FR => Yii::t('app', 'French'),
            self::DK => Yii::t('app', 'Danish'),
            self::AT => Yii::t('app', 'Austrian'),
            self::CH => Yii::t('app', 'Swiss'),
            self::ES => Yii::t('app', 'Spanish'),
            self::PL => Yii::t('app', 'Polish'),
            self::EU => Yii::t('app', 'European'),
            self::SE => Yii::t('app', 'Swedish'),
            self::SI => Yii::t('app', 'Sloven'),
            self::BE => Yii::t('app', 'Belgian'),
            self::NL => Yii::t('app', 'Dutch'),
            self::US => Yii::t('app', 'American'),
            self::NONATION => Yii::t('app', 'No nationality'),
        ];

        return $nationArray;
    }


    public function getAge(){

        if(!is_null($this->birthday)){
            //date in mm/dd/yyyy format; or it can be in other formats as well
            //explode the date to get month, day and year
            $birthDate = explode("-", $this->birthday);
            //get age from date or birthdate
            return (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[0], $birthDate[1]))) > date("md")
                ? ((date("Y") - $birthDate[0]) - 1)
                : (date("Y") - $birthDate[0]));

        } else return "";

    }


    public function getNameWithRunningNr()
    {
        return $this->name . '#' . $this->running_nr;
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
        $path = Url::to('@webroot/images/players/');
        $escapedTitle = $this->sanitize($this->name);
        $filename = $this->created_at . $escapedTitle . '.jpg';
        if (file_exists($path . $filename)) {
            unlink($path . $filename);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHalloffames()
    {
        return $this->hasMany(Halloffame::className(), ['player_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams()
    {
        return $this->hasMany(Team::className(), ['id' => 'team_id'])->viaTable('{{%team_member}}', ['player_id' => 'id']);
    }

    public function getTeamAdmins()
    {
        return $this->hasMany(Team::className(), ['id' => 'team_id'])->viaTable('{{%team_member}}', ['player_id' => 'id', 'admin' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamMembers()
    {
        return $this->hasMany(TeamMember::className(), ['player_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamMemberFrom($team_id)
    {
        return TeamMember::find()->where(['player_id' => $this->id, 'team_id' => $team_id])->one();
    }


    public function getPhotoInfo()
    {
        $path = Url::to('@webroot/images/players/');
        $url = Url::to('@web/images/players/');
        $escapedTitle = $this->sanitize($this->name);
        $filename = $this->created_at . $escapedTitle . '.jpg';
        $alt = $this->name;

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
