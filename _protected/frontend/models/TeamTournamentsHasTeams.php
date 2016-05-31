<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team_tournaments_has_teams".
 *
 * @property integer $team_tournaments_idtournaments
 * @property integer $team_tournaments_owner
 * @property integer $team_tournaments_owner_group
 * @property integer $teams_idteams
 *
 * @property TeamTournaments $teamTournamentsIdtournaments
 * @property Teams $teamsIdteams
 */
class TeamTournamentsHasTeams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'team_tournaments_has_teams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_tournaments_idtournaments', 'team_tournaments_owner', 'team_tournaments_owner_group', 'teams_idteams'], 'required'],
            [['team_tournaments_idtournaments', 'team_tournaments_owner', 'team_tournaments_owner_group', 'teams_idteams'], 'integer'],
            [['team_tournaments_idtournaments'], 'exist', 'skipOnError' => true, 'targetClass' => TeamTournaments::className(), 'targetAttribute' => ['team_tournaments_idtournaments' => 'idtournaments']],
            [['teams_idteams'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['teams_idteams' => 'idteams']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'team_tournaments_idtournaments' => Yii::t('app', 'Team Tournaments Idtournaments'),
            'team_tournaments_owner' => Yii::t('app', 'Team Tournaments Owner'),
            'team_tournaments_owner_group' => Yii::t('app', 'Team Tournaments Owner Group'),
            'teams_idteams' => Yii::t('app', 'Teams Idteams'),
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
    public function getTeamsIdteams()
    {
        return $this->hasOne(Teams::className(), ['idteams' => 'teams_idteams']);
    }
}
