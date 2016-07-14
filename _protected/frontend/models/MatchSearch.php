<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Match;

/**
 * MatchSearch represents the model behind the search form about `frontend\models\Match`.
 */
class MatchSearch extends Match
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'participant_id_A', 'participant_id_B', 'winner_id', 'loser_id', 'running', 'updated_at', 'created_at'], 'integer'],
            [['score', 'begin_at', 'finished_at', 'metablob'], 'safe'],
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
    public function search($params)
    {
        $query = Match::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'participant_id_A' => $this->participant_id_A,
            'participant_id_B' => $this->participant_id_B,
            'winner_id' => $this->winner_id,
            'loser_id' => $this->loser_id,
            'running' => $this->running,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'begin_at' => $this->begin_at,
            'finished_at' => $this->finished_at,
        ]);

        $query->andFilterWhere(['like', 'score', $this->score])
            ->andFilterWhere(['like', 'metablob', $this->metablob]);

        return $dataProvider;
    }
}
