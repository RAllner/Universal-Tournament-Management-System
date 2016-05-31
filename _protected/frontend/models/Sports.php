<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sports".
 *
 * @property integer $idsports
 * @property string $name
 * @property string $rules
 *
 * @property SportsHasRulesets[] $sportsHasRulesets
 * @property Rulesets[] $rulesetsIdrulesets
 * @property TeamTournaments[] $teamTournaments
 * @property Tournaments[] $tournaments
 */
class Sports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idsports'], 'required'],
            [['idsports'], 'integer'],
            [['name', 'rules'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idsports' => Yii::t('app', 'Idsports'),
            'name' => Yii::t('app', 'Name'),
            'rules' => Yii::t('app', 'Rules'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSportsHasRulesets()
    {
        return $this->hasMany(SportsHasRulesets::className(), ['sports_idsports' => 'idsports']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRulesetsIdrulesets()
    {
        return $this->hasMany(Rulesets::className(), ['idrulesets' => 'rulesets_idrulesets'])->viaTable('sports_has_rulesets', ['sports_idsports' => 'idsports']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamTournaments()
    {
        return $this->hasMany(TeamTournaments::className(), ['sports_idsports' => 'idsports']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournaments()
    {
        return $this->hasMany(Tournaments::className(), ['sports_idsports' => 'idsports']);
    }
}
