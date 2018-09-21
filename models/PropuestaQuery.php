<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Propuesta]].
 *
 * @see Propuesta
 */
class PropuestaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Propuesta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Propuesta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function delAnyo($anyo)
    {
        return $this->andWhere(['anyo' => $anyo]);
    }

    public function delEvaluador($user_id)
    {
        return $this
            ->innerJoinWith(['propuestaEvaluadors pe'], false)
            ->andWhere(['pe.user_id' => $user_id]);
    }

    public function enEstado($estado_id)
    {
        return $this->andWhere(['estado_id' => $estado_id]);
    }
}
