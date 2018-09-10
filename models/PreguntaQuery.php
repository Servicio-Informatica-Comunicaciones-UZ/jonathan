<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Pregunta]].
 *
 * @see Pregunta
 */
class PreguntaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Pregunta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Pregunta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function delAnyoYTipo($anyo, $tipo_estudio_id)
    {
        return $this
            ->andWhere(['anyo' => $anyo, 'tipo_estudio_id' => $tipo_estudio_id])
            ->orderBy('orden');
    }
}
