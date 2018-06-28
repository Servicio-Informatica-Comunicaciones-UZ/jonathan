<?php
/**
 * Job to send an e-mail (using the console configuration).
 *
 * @author  Enrique Matías Sánchez <quique@unizar.es>
 * @license GPL-3.0+
 */

namespace app\jobs;

use Yii;
use yii\base\BaseObject;

/**
 * This is a background job to be executed by Yii2-queue.
 */
class SendMailJob extends BaseObject implements \yii\queue\JobInterface
{
    public $attachmentPath;
    public $recipients;
    public $sender;
    public $subject;
    public $view;
    public $viewParams;

    public function execute($queue)
    {
        $message = Yii::$app->mailer
            ->compose($this->view, $this->viewParams)  // By default located at @app/mail
            ->setFrom($this->sender)
            ->setTo($this->recipients)
            ->setSubject($this->subject)
        ;
        $message->attach($this->attachmentPath);
        $message->send();
    }
}
