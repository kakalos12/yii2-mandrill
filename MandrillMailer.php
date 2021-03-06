<?php

namespace kakalos12\mandrill;

class MandrillMailer extends \yii\mail\BaseMailer {

	public $apiKey = null;

	public $messageClass = 'kakalos12\mandrill\Message';

	private $_mailer = null;

	/**
	 * get the Mandrill instance
	 *
	 * @return \Mandrill
	 */
	public function getMailer() {
		if (! is_object ( $this->_mailer ))
			$this->_mailer = new \Mandrill ( $this->apiKey );
		return $this->_mailer;

	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see \yii\mail\BaseMailer::sendMessage()
	 */
	public function sendMessage($message) {
		$result = $this->getMailer ()->messages->send ( $message->getParams () );
		return $result [0] ['status'] == 'sent' || $result [0] ['status'] == 'queued';

	}

}