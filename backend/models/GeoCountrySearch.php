<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GeoCountry;
use backend\ErpGroupModelSearch;

/**
 * GeoCountrySearch represents the model behind the search form about `backend\models\GeoCountry`.
 */
class GeoCountrySearch extends GeoCountry
{
    use ErpGroupModelSearch;
    public $search = '';
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['geo_macroregion_geo_id', 'geo_macroregion_com_id', 'status', 'group_id', 'is_group'], 'integer'],
            [['title', 'name', 'iso3', 'iso2', 'zip_name'], 'safe'],
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
        $query = GeoCountry::find();

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
        /*$query->andFilterWhere([
            'id' => $this->id,
            'geo_macroregion_geo_id' => $this->geo_macroregion_geo_id,
            'geo_macroregion_com_id' => $this->geo_macroregion_com_id,
            'status' => $this->status,
            'group_id' => $this->group_id,
            'is_group' => $this->is_group,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'iso3', $this->iso3])
            ->andFilterWhere(['like', 'iso2', $this->iso2])
            ->andFilterWhere(['like', 'zip_name', $this->zip_name]);
        */
        if ($this->is_group == 1) {
            $query->andWhere([$this->tableName().'.group_id' => ($this->group_id ? intval($this->group_id) : null)]);
        } else {
            $query->andWhere([$this->tableName().'.is_group' => '0']);
        }

        if (!$this->status)
            $this->status = 1;
        elseif ($this->status == 4) // all
            $this->status = null;

        $query->andFilterWhere([
            $this->tableName().'.status' => $this->status,
        ]);
        
        if (isset($_GET['search']) && strlen($_GET['search'])) {
            $this->search = $_GET['search']{0};
            $query->andWhere(['like', $this->tableName().'.title', $_GET['search']{0}.'%', false]);
        }
        $query->andFilterWhere(['like', $this->tableName().'.title', $this->title]);
        $query->andFilterWhere(['like', $this->tableName().'.name', $this->name]);
        

        return $dataProvider;
    }
}
