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

    public $uploadErrorMessages = [
        0 => 'There is no error, the file uploaded with success.',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        3 => 'The uploaded file was only partially uploaded.',
        4 => 'No file was uploaded.',
        6 => 'Missing a temporary folder.',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    ];

    public function getErrorMessage()
    {
        return $this->uploadErrorMessages[$this->fichero->error];
    }

    private function return_bytes($val)
    {
        assert('1 === preg_match("/^\d+([kmg])?$/i", $val)');
        static $map = ['k' => 1024, 'm' => 1048576, 'g' => 1073741824];
        return (int)$val * @($map[strtolower(substr($val, -1))] ?: 1);
    }

    public function rules()
    {
        return [
            [
                ['fichero'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'pdf',
                'mimeTypes' => 'application/pdf',
                'maxSize' => $this->return_bytes(ini_get('upload_max_filesize')),
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
