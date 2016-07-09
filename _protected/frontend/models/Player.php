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
            [['user_id', 'name', 'running_nr'], 'required'],
            [['user_id', 'running_nr'], 'integer'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['name'], 'string', 'max' => 255],
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
        imagejpeg($image ,$path, 80);
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


    public function getNameWithRunningNr(){
        return $this->name.'#'.$this->running_nr;
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