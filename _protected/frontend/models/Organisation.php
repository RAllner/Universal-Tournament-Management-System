<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%organisation}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property OrganisationHasUser[] $organisationHasUsers
 * @property User[] $users
 */
class Organisation extends ActiveRecord
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
        return '{{%organisation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'message' => 'This name has already been taken.'],
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
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    public function upload()
    {

        if ($this->imageFile) {
            $path = Url::to('@webroot/images/organisations/');
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
        $path = Url::to('@webroot/images/organisations/');
        $escapedNewName = $this->sanitize($newName);
        $escapedOldName = $this->sanitize($oldName);
        if(rename($path.$this->created_at.$escapedOldName.'.jpg', $path.$this->created_at.$escapedNewName.'.jpg')){
            Yii::$app->session->setFlash('success', 'Filename changed to '.$escapedNewName.'.jpg');
        } else {
            Yii::$app->session->setFlash('error', 'Filename not changed from'.$escapedOldName.'.jpg'.' to '.$escapedNewName.'.jpg' );
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
    public function getOrganisationHasUsers()
    {
        return $this->hasMany(OrganisationHasUser::className(), ['organisation_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('organisation_has_user', ['organisation_id' => 'id']);
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
        $path = Url::to('@webroot/images/organisations/');
        $escapedTitle = $this->sanitize($this->name);
        $filename = $this->created_at.$escapedTitle.'.jpg';
        if(file_exists($path.$filename)){
            unlink($path.$filename);
        }
    }


    public function getPhotoInfo()
    {
        $path = Url::to('@webroot/images/organisations/');
        $url = Url::to('@web/images/organisations/');
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


}
