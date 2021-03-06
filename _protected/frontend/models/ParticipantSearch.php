<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Participant;

/**
 * ParticipantSearch represents the model behind the search form about `frontend\models\Participant`.
 */
class ParticipantSearch extends Participant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tournament_id', 'signup', 'checked_in', 'seed', 'updated_at', 'created_at', 'rank', 'elo', 'player_id', 'team_id', 'removed', 'on_waiting_list'], 'integer'],
            [['name', 'rank'], 'safe'],
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
     * @param int $tournament_id
     * @param int $standings
     * @return ActiveDataProvider
     */
    public function search($params, $tournament_id, $standings = 0, $notnullValues = true)
    {
        $query = Participant::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['rank' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 100,
            ]
        ]);
        $query->where(['tournament_id' => $tournament_id]);
        $this->load($params);

        if($notnullValues){
            $query->andWhere(['not', ['rank' => null]]);
        } else{
            $query->andWhere(['rank' => null]);
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tournament_id' => $this->tournament_id,
            'signup' => $this->signup,
            'checked_in' => $this->checked_in,
            'seed' => $this->seed,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'rank' => $this->rank,
            'history' => $this->history,
            'elo' => $this->elo,
            'player_id' => $this->player_id,
            'team_id' => $this->team_id,
            'removed' => $this->removed,
            'on_waiting_list' => $this->on_waiting_list,
        ]);
        if ($standings == 1){
            $query->orderBy('rank');
        }
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
