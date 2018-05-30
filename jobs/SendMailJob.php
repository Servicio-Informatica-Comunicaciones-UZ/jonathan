<?php
/**
 * Job to send an e-mail (using the console configuration)
 *
 * @author  Enrique Matías Sánchez <quique@unizar.es>
 * @license GPL-3.0+
 */

namespace app\jobs;

use Yii;
use yii\base\BaseObject;
use dawood\phpChrome\Chrome;

/**
 * This is a background job to be executed by Yii2-queue.
 */
class SendMailJob extends BaseObject implements \yii\queue\JobInterface
{
    public $attachmentPath;
    public $body;
    public $recipients;
    public $sender;
    public $subject;

    public function execute($queue)
    {
        $message = Yii::$app->mailer
            ->compose()
            ->setFrom($this->sender)
            ->setTo($this->recipients)
            ->setSubject($this->subject)
            ->setTextBody($this->body)
        ;
        $message->attach($this->attachmentPath);
        $message->send();
    }
}
