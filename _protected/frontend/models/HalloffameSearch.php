<?php
namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * HalloffameSearch represents the model behind the search form about `app\models\Halloffame`.
 */
class HalloffameSearch extends Halloffame
{
    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'players_id', 'playername', 'achievements','description', 'created_at', 'updated_at'], 'integer'],
            [['playername', 'achievements','description'], 'safe'],
        ];
    }

    /**
     * Returns a list of scenarios and the corresponding active attributes.
     *
     * @return array
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array   $params    The search query params.
     * @param integer $pageSize  The number of results to be displayed per page.
     * @param boolean $published Whether or not articles have to be published.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $pageSize = 3, $published = false)
    {
        $query = Halloffame::find();

        // this means that editor is trying to see articles
        // we will allow him to see published ones and drafts made by him
        if ($published === true) 
        {
            $query->where(['status' => Halloffame::STATUS_PUBLISHED]);
            $query->orWhere(['user_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $pageSize,
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'category' => $this->category,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['like', 'summary', $this->summary])
              ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
