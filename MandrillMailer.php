<?php

namespace kakalos12\mandrill;

class MandrillMailer extends \yii\mail\BaseMailer {

	public $apiKey = null;

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

	public function createSubAccount() {

	}

}