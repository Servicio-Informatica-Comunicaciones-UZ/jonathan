<?php
/**
 * Job to save a page as a PDF file using headless chrome/chromium via Puppeteer.
 *
 * @author  Enrique Matías Sánchez <quique@unizar.es>
 * @license GPL-3.0+
 */

namespace app\jobs;

use Yii;
use yii\base\BaseObject;
use Spatie\Browsershot\Browsershot;

/**
 * This is a background job to be executed by Yii2-queue.
 */
class PrintPdfJob extends BaseObject implements \yii\queue\JobInterface
{
    public $chromePath;
    public $filename;
    public $margins;
    public $outputDirectory;
    public $url;

    public function execute($queue)
    {
        $margins = $this->margins;
        Browsershot::url($this->url)
            ->setNodeModulePath(Yii::getAlias('@vendor/npm-asset'))
            ->setChromePath($this->chromePath)
            ->paperSize(297, 210)
            ->margins($margins[0], $margins[1], $margins[2], $margins[3])  // top, right, bottom, left
            ->save("{$this->outputDirectory}/{$this->filename}");
    }
}
