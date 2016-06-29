<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Events;

/**
 * EventsSearch represents the model behind the search form about `frontend\models\Events`.
 */
class EventsSearch extends Events
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'locations_id', 'tournaments_id', 'type', 'status', 'category', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'startdate', 'enddate', 'game', 'partners', 'facebook', 'liquidpedia', 'challonge'], 'safe'],
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
    public function search($params, $pageSize = 3, $published = false)
    {
        $query = Events::find();

        // add conditions that should always apply here

        if ($published === true)
        {
            $query->where(['status' => Article::STATUS_PUBLISHED]);
            $query->orWhere(['user_id' => Yii::$app->user->id]);
        }

        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['startdate' => SORT_ASC]],
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'locations_id' => $this->locations_id,
            'tournaments_id' => $this->tournaments_id,
            'type' => $this->type,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'status' => $this->status,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'game', $this->game])
            ->andFilterWhere(['like', 'partners', $this->partners])
            ->andFilterWhere(['like', 'facebook', $this->facebook])
            ->andFilterWhere(['like', 'liquidpedia', $this->liquidpedia])
            ->andFilterWhere(['like', 'challonge', $this->challonge]);

        return $dataProvider;
    }
}