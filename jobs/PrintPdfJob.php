<?php
/**
 * Job to save a page as a PDF file using headless chrome/chromium.
 *
 * @author  Enrique Matías Sánchez <quique@unizar.es>
 * @license GPL-3.0+
 */

namespace app\jobs;

use yii\base\BaseObject;
use dawood\phpChrome\Chrome;

/**
 * This is a background job to be executed by Yii2-queue.
 */
class PrintPdfJob extends BaseObject implements \yii\queue\JobInterface
{
    public $chromePath;
    public $filename;
    public $outputDirectory;
    public $url;

    public function execute($queue)
    {
        $chrome = new Chrome($this->url, $this->chromePath);
        $chrome->setOutputDirectory($this->outputDirectory);
        // Not necessary to set window size
        // $chrome->setWindowSize($width = 1280, $height = 768);
        $chrome->getPdf("{$this->outputDirectory}/{$this->filename}");
    }
}
