<?php
/**
 * Controlador para gestionar el plazo de presentación de propuestas
 *
 * @author Enrique Matías Sánchez <quique@unizar.es>
 * @copyright Copyright (c) 2018 Universidad de Zaragoza
 * @license GPL-3.0+
 *
 * @see https://gitlab.unizar.es/titulaciones/jonathan
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Estado;
use app\models\Propuesta;

class PlazoController extends Controller
{
    public function actionCerrar()
    {
        $propuestas = Propuesta::find()->where(['estado_id' => Estado::BORRADOR])->all();

        foreach ($propuestas as $propuesta) {
            $propuesta->estado_id = Estado::FUERA_DE_PLAZO;
            $propuesta->log .= date(DATE_RFC3339) . ' — ' . 'Cierre automático por fin del plazo.' . "\n";
            $propuesta->save();
        }

        Yii::info('Cambio del estado de las propuestas en Borrador a Fuera de plazo.', 'gestion');

        return ExitCode::OK;
    }
}
