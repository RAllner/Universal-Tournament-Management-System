<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team_matches".
 *
 * @property integer $idteam_matches
 * @property integer $pointsA
 * @property integer $pointsB
 * @property integer $teams_idteamA
 * @property integer $teams_idteamB
 * @property integer $team_tournaments_idtournaments
 *
 * @property TeamTournaments $teamTournamentsIdtournaments
 * @property Teams $teamsIdteamA
 * @property Teams $teamsIdteamB
 */
class TeamMatches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'team_matches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idteam_matches', 'teams_idteamA', 'teams_idteamB', 'team_tournaments_idtournaments'], 'required'],
            [['idteam_matches', 'pointsA', 'pointsB', 'teams_idteamA', 'teams_idteamB', 'team_tournaments_idtournaments'], 'integer'],
            [['team_tournaments_idtournaments'], 'exist', 'skipOnError' => true, 'targetClass' => TeamTournaments::className(), 'targetAttribute' => ['team_tournaments_idtournaments' => 'idtournaments']],
            [['teams_idteamA'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['teams_idteamA' => 'idteams']],
            [['teams_idteamB'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['teams_idteamB' => 'idteams']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idteam_matches' => Yii::t('app', 'Idteam Matches'),
            'pointsA' => Yii::t('app', 'Points A'),
            'pointsB' => Yii::t('app', 'Points B'),
            'teams_idteamA' => Yii::t('app', 'Teams Idteam A'),
            'teams_idteamB' => Yii::t('app', 'Teams Idteam B'),
            'team_tournaments_idtournaments' => Yii::t('app', 'Team Tournaments Idtournaments'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamTournamentsIdtournaments()
    {
        return $this->hasOne(TeamTournaments::className(), ['idtournaments' => 'team_tournaments_idtournaments']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamsIdteamA()
    {
        return $this->hasOne(Teams::className(), ['idteams' => 'teams_idteamA']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamsIdteamB()
    {
        return $this->hasOne(Teams::className(), ['idteams' => 'teams_idteamB']);
    }
}
