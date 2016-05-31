<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rulesets".
 *
 * @property integer $idrulesets
 * @property string $rules
 *
 * @property SportsHasRulesets[] $sportsHasRulesets
 * @property Sports[] $sportsIdsports
 */
class Rulesets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rulesets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idrulesets'], 'required'],
            [['idrulesets'], 'integer'],
            [['rules'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idrulesets' => Yii::t('app', 'Idrulesets'),
            'rules' => Yii::t('app', 'Rules'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSportsHasRulesets()
    {
        return $this->hasMany(SportsHasRulesets::className(), ['rulesets_idrulesets' => 'idrulesets']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSportsIdsports()
    {
        return $this->hasMany(Sports::className(), ['idsports' => 'sports_idsports'])->viaTable('sports_has_rulesets', ['rulesets_idrulesets' => 'idrulesets']);
    }
}
