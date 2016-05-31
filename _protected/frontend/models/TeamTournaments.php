<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team_tournaments".
 *
 * @property integer $idtournaments
 * @property integer $user_id
 * @property integer $sports_idsports
 * @property string $name
 * @property string $begin
 * @property string $end
 * @property string $location
 * @property string $description
 * @property string $url
 * @property integer $max_participants
 * @property integer $third_place
 * @property string $format
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TeamMatches[] $teamMatches
 * @property User $user
 * @property Sports $sportsIdsports
 * @property TeamTournamentsHasTeams[] $teamTournamentsHasTeams
 */
class TeamTournaments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'team_tournaments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtournaments', 'user_id', 'sports_idsports'], 'required'],
            [['idtournaments', 'user_id', 'sports_idsports', 'max_participants', 'third_place', 'status', 'created_at', 'updated_at'], 'integer'],
            [['begin', 'end'], 'safe'],
            [['description'], 'string'],
            [['name', 'location', 'format'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 512],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['sports_idsports'], 'exist', 'skipOnError' => true, 'targetClass' => Sports::className(), 'targetAttribute' => ['sports_idsports' => 'idsports']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtournaments' => Yii::t('app', 'Idtournaments'),
            'user_id' => Yii::t('app', 'User ID'),
            'sports_idsports' => Yii::t('app', 'Sports Idsports'),
            'name' => Yii::t('app', 'Name'),
            'begin' => Yii::t('app', 'Begin'),
            'end' => Yii::t('app', 'End'),
            'location' => Yii::t('app', 'Location'),
            'description' => Yii::t('app', 'Description'),
            'url' => Yii::t('app', 'Url'),
            'max_participants' => Yii::t('app', 'Max Participants'),
            'third_place' => Yii::t('app', 'Third Place'),
            'format' => Yii::t('app', 'Format'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamMatches()
    {
        return $this->hasMany(TeamMatches::className(), ['team_tournaments_idtournaments' => 'idtournaments']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSportsIdsports()
    {
        return $this->hasOne(Sports::className(), ['idsports' => 'sports_idsports']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamTournamentsHasTeams()
    {
        return $this->hasMany(TeamTournamentsHasTeams::className(), ['team_tournaments_idtournaments' => 'idtournaments']);
    }
}
