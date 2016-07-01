<?php

namespace frontend\models;

use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Yii;

/**
 * This is the model class for table "{{%team}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $website
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $description
 *
 * @property User $user
 * @property TeamMember[] $teamMembers
 * @property Player[] $players
 */
class Team extends \yii\db\ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $imageFile;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['description'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['name'], 'string', 'max' => 255],
            [['website'], 'url'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'website' => Yii::t('app', 'Website'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function upload()
    {

        if ($this->imageFile) {
            $path = Url::to('@webroot/images/teams/');
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
        $path = Url::to('@webroot/images/teams/');
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
     * @return \yii\db\ActiveQuery
     */
    public function getTeamMembers()
    {
        return $this->hasMany(TeamMember::className(), ['team_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayers()
    {
        return $this->hasMany(Player::className(), ['id' => 'player_id'])->viaTable('{{%team_member}}', ['team_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmins()
    {
        return $this->hasMany(Player::className(), ['id' => 'player_id'])->viaTable('{{%team_member}}', ['team_id' => 'id', 'admin' => 1]);
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
        $path = Url::to('@webroot/images/teams/');
        $escapedTitle = $this->sanitize($this->name);
        $filename = $this->created_at.$escapedTitle.'.jpg';
        if(file_exists($path.$filename)){
            unlink($path.$filename);
        }
    }

    public function getPhotoInfo()
    {
        $path = Url::to('@webroot/images/teams/');
        $url = Url::to('@web/images/teams/');
        $escapedTitle = $this->sanitize($this->name);
        $filename = $this->created_at.$escapedTitle.'.jpg';
        $alt = $this->name;

        $imageInfo = ['alt'=> $alt];

        if (file_exists($path . $filename)) {
            $imageInfo['url'] = $url.$filename;
        } else {
            $imageInfo['url'] = $url.'default.png';
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

    public function isUsersPlayerAdmin()
    {
        $isAdmin = false;
        $teamMembers = $this->teamMembers;
        foreach ($teamMembers as $member) {
            if ($member->admin == 1) {
                $player = Player::find()
                    ->where(['id' => $member->player_id])
                    ->one();
                if ($player->user_id == Yii::$app->user->id) {
                    $isAdmin = true;
                }
            }
        }
        return $isAdmin;
    }
}
