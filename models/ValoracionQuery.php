<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Valoracion]].
 *
 * @see Valoracion
 */
class ValoracionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * {@inheritdoc}
     *
     * @return Valoracion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     *
     * @return Valoracion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function delEvaluador($user_id)
    {
        return $this->andWhere(['user_id' => $user_id]);
    }

    public function deLaPropuesta($propuesta_id)
    {
        return $this->andWhere(['propuesta_id' => $propuesta_id]);
    }
}
