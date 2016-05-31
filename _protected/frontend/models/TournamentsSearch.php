<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tournaments;

/**
 * TournamentsSearch represents the model behind the search form about `app\models\Tournaments`.
 */
class TournamentsSearch extends Tournaments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtournaments', 'sports_idsports', 'third_place', 'status', 'created_at', 'updated_at', 'has_sets', 'user_id', 'organisation_idorganisation'], 'integer'],
            [['name', 'begin', 'end', 'location', 'description', 'url', 'max_participants', 'format', 'tournamentscol'], 'safe'],
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
        $query = Tournaments::find();

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
            'idtournaments' => $this->idtournaments,
            'begin' => $this->begin,
            'end' => $this->end,
            'sports_idsports' => $this->sports_idsports,
            'third_place' => $this->third_place,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'has_sets' => $this->has_sets,
            'user_id' => $this->user_id,
            'organisation_idorganisation' => $this->organisation_idorganisation,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'max_participants', $this->max_participants])
            ->andFilterWhere(['like', 'format', $this->format])
            ->andFilterWhere(['like', 'tournamentscol', $this->tournamentscol]);

        return $dataProvider;
    }
}
