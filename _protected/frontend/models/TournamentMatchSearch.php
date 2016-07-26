<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\TournamentMatch;
use yii\data\Sort;

/**
 * TournamentMatchSearch represents the model behind the search form about `frontend\models\TournamentMatch`.
 */
class TournamentMatchSearch extends TournamentMatch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tournament_id', 'stage', 'groupID', 'round', 'participant_id_A', 'participant_score_A', 'seed_A', 'participant_id_B', 'participant_score_B', 'seed_B',  'winner_id', 'loser_id', 'updated_at', 'created_at', 'state', 'losers_round'], 'integer'],
            [['matchID', 'begin_at', 'finished_at', 'metablob', 'follow_winner_and_loser_match_ids', 'qualification_match_ids'], 'safe'],
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
    public function search($params, $tournament_id, $stage)
    {
        $query = TournamentMatch::find();

        // add conditions that should always apply here
        $query->where(['tournament_id' => $tournament_id]);
        $query->where(['stage' => $stage]);
        $query->where(['not',['and',['seed_A' => null],['seed_B' => null]]]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['state' => SORT_DESC, 'matchID' => SORT_ASC,'round' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 100,
            ]
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
            'tournament_id' => $this->tournament_id,
            'stage' => $this->stage,
            'groupID' => $this->groupID,
            'round' => $this->round,
            'participant_id_A' => $this->participant_id_A,
            'participant_score_A' => $this->participant_score_A,
            'seed_A' => $this->seed_A,
            'participant_id_B' => $this->participant_id_B,
            'participant_score_B' => $this->participant_score_B,
            'seed_B' => $this->seed_A,
            'winner_id' => $this->winner_id,
            'loser_id' => $this->loser_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'begin_at' => $this->begin_at,
            'finished_at' => $this->finished_at,
            'state' => $this->state,
            'losers_round' => $this->losers_round,
        ]);

        $query->andFilterWhere(['like', 'matchID', $this->matchID])
            ->andFilterWhere(['like', 'metablob', $this->metablob])
            ->andFilterWhere(['like', 'follow_winner_and_loser_match_ids', $this->follow_winner_and_loser_match_ids])
            ->andFilterWhere(['like', 'qualification_match_ids', $this->qualification_match_ids]);

        return $dataProvider;
    }
}
