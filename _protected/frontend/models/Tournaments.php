<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournaments".
 *
 * @property integer $idtournaments
 * @property string $name
 * @property string $begin
 * @property string $end
 * @property string $location
 * @property integer $sports_idsports
 * @property string $description
 * @property string $url
 * @property string $max_participants
 * @property integer $third_place
 * @property string $format
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $has_sets
 * @property string $tournamentscol
 * @property integer $user_id
 * @property integer $organisation_idorganisation
 *
 * @property Matches[] $matches
 * @property Signups[] $signups
 * @property Organisation $organisationIdorganisation
 * @property Sports $sportsIdsports
 * @property User $user
 * @property TournamentsHasPlayers[] $tournamentsHasPlayers
 * @property Players[] $playersIdplayers
 */
class Tournaments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tournaments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtournaments', 'sports_idsports', 'user_id', 'organisation_idorganisation'], 'required'],
            [['idtournaments', 'sports_idsports', 'third_place', 'status', 'created_at', 'updated_at', 'has_sets', 'user_id', 'organisation_idorganisation'], 'integer'],
            [['begin', 'end'], 'safe'],
            [['description'], 'string'],
            [['name', 'location', 'max_participants', 'format'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 512],
            [['tournamentscol'], 'string', 'max' => 45],
            [['organisation_idorganisation'], 'exist', 'skipOnError' => true, 'targetClass' => Organisation::className(), 'targetAttribute' => ['organisation_idorganisation' => 'idorganisation']],
            [['sports_idsports'], 'exist', 'skipOnError' => true, 'targetClass' => Sports::className(), 'targetAttribute' => ['sports_idsports' => 'idsports']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtournaments' => Yii::t('app', 'Idtournaments'),
            'name' => Yii::t('app', 'Name'),
            'begin' => Yii::t('app', 'Begin'),
            'end' => Yii::t('app', 'End'),
            'location' => Yii::t('app', 'Location'),
            'sports_idsports' => Yii::t('app', 'Sports Idsports'),
            'description' => Yii::t('app', 'Description'),
            'url' => Yii::t('app', 'Url'),
            'max_participants' => Yii::t('app', 'Max Participants'),
            'third_place' => Yii::t('app', 'Third Place'),
            'format' => Yii::t('app', 'Format'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'has_sets' => Yii::t('app', 'Has Sets'),
            'tournamentscol' => Yii::t('app', 'Tournamentscol'),
            'user_id' => Yii::t('app', 'User ID'),
            'organisation_idorganisation' => Yii::t('app', 'Organisation Idorganisation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatches()
    {
        return $this->hasMany(Matches::className(), ['tournaments_idtournaments' => 'idtournaments']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSignups()
    {
        return $this->hasMany(Signups::className(), ['tournaments_idtournaments' => 'idtournaments']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationIdorganisation()
    {
        return $this->hasOne(Organisation::className(), ['idorganisation' => 'organisation_idorganisation']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentsHasPlayers()
    {
        return $this->hasMany(TournamentsHasPlayers::className(), ['tournaments_idtournaments' => 'idtournaments', 'tournaments_user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayersIdplayers()
    {
        return $this->hasMany(Players::className(), ['idplayers' => 'players_idplayers'])->viaTable('tournaments_has_players', ['tournaments_idtournaments' => 'idtournaments', 'tournaments_user_id' => 'user_id']);
    }
}
