<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sports_has_rulesets".
 *
 * @property integer $sports_idsports
 * @property integer $rulesets_idrulesets
 *
 * @property Rulesets $rulesetsIdrulesets
 * @property Sports $sportsIdsports
 */
class SportsHasRulesets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sports_has_rulesets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sports_idsports', 'rulesets_idrulesets'], 'required'],
            [['sports_idsports', 'rulesets_idrulesets'], 'integer'],
            [['rulesets_idrulesets'], 'exist', 'skipOnError' => true, 'targetClass' => Rulesets::className(), 'targetAttribute' => ['rulesets_idrulesets' => 'idrulesets']],
            [['sports_idsports'], 'exist', 'skipOnError' => true, 'targetClass' => Sports::className(), 'targetAttribute' => ['sports_idsports' => 'idsports']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sports_idsports' => Yii::t('app', 'Sports Idsports'),
            'rulesets_idrulesets' => Yii::t('app', 'Rulesets Idrulesets'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRulesetsIdrulesets()
    {
        return $this->hasOne(Rulesets::className(), ['idrulesets' => 'rulesets_idrulesets']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSportsIdsports()
    {
        return $this->hasOne(Sports::className(), ['idsports' => 'sports_idsports']);
    }
}
