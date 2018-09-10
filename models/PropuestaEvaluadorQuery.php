<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PropuestaEvaluador]].
 *
 * @see PropuestaEvaluador
 */
class PropuestaEvaluadorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return PropuestaEvaluador[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropuestaEvaluador|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function delEvaluador($user_id)
    {
        return $this->andWhere(['user_id' => $user_id]);
    }
}
