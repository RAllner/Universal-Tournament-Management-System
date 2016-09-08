<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Player;

/**
 * PlayersSearch represents the model behind the search form about `frontend\models\Players`.
 */
class PlayerSearch extends Player
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'running_nr', 'created_at', 'updated_at', 'deleted_flag', 'gender'], 'integer'],
            [['name', 'description', 'games', 'website', 'stream','languages', 'nation'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize = 3, $owned, $admin = false)
    {
        $query = Player::find();

        if ($owned === true){
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }
        /** only admins can see deleted player profiles */
        if(!$admin){
            $query->andWhere(['not', ['deleted_flag' => 1]]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);

        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'running_nr' => $this->running_nr,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
