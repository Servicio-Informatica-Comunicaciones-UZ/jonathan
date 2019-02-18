<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Propuesta;

/**
 * PropuestaSearch represents the model behind the search form about `app\models\Propuesta`.
 */
class PropuestaSearch extends Propuesta
{
    // Atributos calculados o de tablas relacionadas
    public $nombreProponente;

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['id', 'anyo', 'user_id', 'orientacion_id', 'creditos', 'duracion', 'modalidad_id', 'plazas', 'tipo_estudio_id'], 'integer'],
            [['denominacion', 'log', 'estado_id'], 'safe'],
            [['creditos_practicas'], 'number'],
            // Reglas para los atributos calculados/referenciados
            [['nombreProponente'], 'safe']
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
        $query = Propuesta::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'anyo',
                    'denominacion',
                    'estado_id',
                    // Setup our sorting attributes
                    'nombreProponente' => [
                        'asc' => ['profile.name' => SORT_ASC],
                        'desc' => ['profile.name' => SORT_DESC],
                        // 'label' => 'Nombre del responsable'
                        'default' => SORT_ASC,
                    ],
                ],
                'defaultOrder' => ['anyo' => SORT_DESC, 'denominacion' => SORT_ASC],
            ],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'anyo' => $this->anyo,
            'propuesta.user_id' => $this->user_id,
            'orientacion_id' => $this->orientacion_id,
            'creditos' => $this->creditos,
            'duracion' => $this->duracion,
            'modalidad_id' => $this->modalidad_id,
            'plazas' => $this->plazas,
            'creditos_practicas' => $this->creditos_practicas,
            'tipo_estudio_id' => $this->tipo_estudio_id,
            'estado_id' => $this->estado_id,
        ]);

        $query->andFilterWhere(['like', 'denominacion', $this->denominacion])
            ->andFilterWhere(['like', 'log', $this->log]);

        // filter by profile name
        $query->joinWith(['profile' => function ($q) {
            // $q->where(['LIKE', 'profile.name', $this->nombreProponente ?: '']);
            $q->where("profile.name LIKE '%{$this->nombreProponente}%'");
        }]);

        return $dataProvider;
    }
}
