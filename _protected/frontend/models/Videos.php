<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Url;
use common\models\User;

/**
 * This is the model class for table "{{%videos}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $url
 * @property string $title
 * @property integer $status
 * @property integer $category
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Videos extends ActiveRecord
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%videos}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'status', 'url'], 'required'],
            [['user_id', 'status', 'category'], 'integer'],
            [['url'], 'string', 'max' => 512],
            [['title'], 'string', 'max' => 255]
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
            'url' => Yii::t('app', 'Url'),
            'title' => Yii::t('app', 'Title'),
            'status' => Yii::t('app', 'Status'),
            'category' => Yii::t('app', 'Category'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
     * Returns the videos category in nice format.
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
