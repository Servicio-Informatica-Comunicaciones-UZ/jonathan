<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class FicheroPdf extends Model
{
    /**
     * @var UploadedFile
     */
    public $fichero;

    public function rules()
    {
        return [
            [
                ['fichero'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'pdf',
                'mimeTypes' => 'application/pdf'
            ],
        ];
    }

    public function upload($directorio, $nombre)
    {
        if ($this->validate()) {
            $this->fichero->saveAs('pdf/' . $directorio . '/' . $nombre . '.pdf');

            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'fichero' => Yii::t('models', 'Fichero PDF'),
        ];
    }
}
