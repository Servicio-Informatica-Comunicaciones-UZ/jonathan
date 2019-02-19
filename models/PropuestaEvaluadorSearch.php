<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PropuestaEvaluador;

/**
 * PropuestaEvaluadorSearch represents the model behind the search form about `app\models\PropuestaEvaluador`.
 */
class PropuestaEvaluadorSearch extends PropuestaEvaluador
{
    // Atributos calculados o de tablas relacionadas
    public $anyo;
    public $nombreEvaluador;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'propuesta_id', 'user_id', 'estado_id', 'fase'], 'integer'],
            // Reglas para los atributos calculados/referenciados
            [['anyo', 'nombreEvaluador'], 'safe'],
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
        $query = PropuestaEvaluador::find()
            ->innerJoinWith('propuesta')
            ->where(['propuesta.anyo' => $this->anyo]);

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => false,
            ]
        );

        /**
         * Setup our sorting attributes
         * Note: This is setup before the $this->load($params) statement below
         */
        $dataProvider->setSort(
            [
                'attributes' => [
                    'estado_id',
                    'fase',
                    'nombreEvaluador' => [
                        'asc' => ['profile.name' => SORT_ASC],
                        'desc' => ['profile.name' => SORT_DESC],
                        // 'label' => 'Nombre del evaluador'
                        'default' => SORT_ASC,
                    ],
                    'propuesta.denominacion',
                ],
                'defaultOrder' => ['fase' => SORT_ASC, 'estado_id' => SORT_ASC, 'propuesta.denominacion' => SORT_ASC],
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'propuesta_id' => $this->propuesta_id,
                'user_id' => $this->user_id,
                'propuesta_evaluador.estado_id' => $this->estado_id,
                'fase' => $this->fase,
            ]
        );

        // filter by profile name
        $query->joinWith(
            ['profile' => function ($q) {
                // $q->where(['LIKE', 'profile.name', $this->nombreEvaluador ?: '']);
                $q->where("profile.name LIKE '%{$this->nombreEvaluador}%'");
            }]
        );

        return $dataProvider;
    }
}
