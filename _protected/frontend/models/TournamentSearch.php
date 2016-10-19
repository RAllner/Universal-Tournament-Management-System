<?php

namespace frontend\models;

use Faker\Provider\zh_TW\DateTime;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Tournament;

/**
 * TournamentSearch represents the model behind the search form about `frontend\models\Tournament`.
 */
class TournamentSearch extends Tournament
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'game_id', 'organisation_id', 'hosted_by', 'location', 'max_participants', 'status', 'created_at', 'updated_at', 'has_sets', 'participants_count', 'stage_type', 'fs_format', 'fs_third_place', 'fs_de_grand_finals', 'fs_rr_ranked_by', 'participants_compete', 'participants_advance', 'gs_format', 'gs_rr_ranked_by', 'gs_tie_break1', 'gs_tie_break2', 'quick_advance', 'gs_tie_break3', 'gs_tie_break1_copy1', 'gs_tie_break2_copy1', 'gs_tie_break3_copy1', 'notifications', 'is_team_tournament'], 'integer'],
            [['name', 'begin', 'end', 'description', 'url'], 'safe'],
            [['fs_rr_ppmw', 'fs_rr_ppmt', 'fs_rr_ppgw', 'fs_rr_ppgt', 'fs_s_ppb', 'gs_rr_ppmw', 'gs_rr_ppmt', 'gs_rr_ppgw', 'gs_rr_ppgt'], 'number'],
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
     * @param int $filter
     * @return ActiveDataProvider
     */
    public function search($params, $filter = 0)
    {
        $query = Tournament::find();

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
        $time = new \DateTime('now');
        $today = $time->format('Y-m-d H:i:s');

        if(!Yii::$app->user->can('editor')){
            $query->andFilterWhere(['>=', 'status', Tournament::STATUS_PUBLISHED]);
        }

        //Open
        if ($filter == 0) {
            $query->andFilterWhere(['in', 'status', [2,3,4,5]]);
        //Running
        } else if ($filter == 1) {
            $query->andFilterWhere(['in', 'status', [3,4,5]]);
        //Comming
        } else if($filter == 2) {
            $query->andFilterWhere(['in', 'status', [2]]);
        //Past
        }else if($filter == 3){
            $query->andFilterWhere(['status' => Tournament::STATUS_FINISHED]);
        //All
        } else {

        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'game_id' => $this->game_id,
            'organisation_id' => $this->organisation_id,
            'hosted_by' => $this->hosted_by,
            'begin' => $this->begin,
            'end' => $this->end,
            'location' => $this->location,
            'max_participants' => $this->max_participants,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'has_sets' => $this->has_sets,
            'participants_count' => $this->participants_count,
            'stage_type' => $this->stage_type,
            'fs_format' => $this->fs_format,
            'fs_third_place' => $this->fs_third_place,
            'fs_de_grand_finals' => $this->fs_de_grand_finals,
            'fs_rr_ranked_by' => $this->fs_rr_ranked_by,
            'fs_rr_ppmw' => $this->fs_rr_ppmw,
            'fs_rr_ppmt' => $this->fs_rr_ppmt,
            'fs_rr_ppgw' => $this->fs_rr_ppgw,
            'fs_rr_ppgt' => $this->fs_rr_ppgt,
            'fs_s_ppb' => $this->fs_s_ppb,
            'participants_compete' => $this->participants_compete,
            'participants_advance' => $this->participants_advance,
            'gs_format' => $this->gs_format,
            'gs_rr_ranked_by' => $this->gs_rr_ranked_by,
            'gs_rr_ppmw' => $this->gs_rr_ppmw,
            'gs_rr_ppmt' => $this->gs_rr_ppmt,
            'gs_rr_ppgw' => $this->gs_rr_ppgw,
            'gs_rr_ppgt' => $this->gs_rr_ppgt,
            'gs_tie_break1' => $this->gs_tie_break1,
            'gs_tie_break2' => $this->gs_tie_break2,
            'quick_advance' => $this->quick_advance,
            'gs_tie_break3' => $this->gs_tie_break3,
            'gs_tie_break1_copy1' => $this->gs_tie_break1_copy1,
            'gs_tie_break2_copy1' => $this->gs_tie_break2_copy1,
            'gs_tie_break3_copy1' => $this->gs_tie_break3_copy1,
            'notifications' => $this->notifications,
            'is_team_tournament' => $this->is_team_tournament,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
