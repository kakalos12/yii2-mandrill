<?php

namespace kakalos12\mandrill;

use yii\mail\BaseMessage;

class Message extends BaseMessage {

	private $_mandrillMessage = null;

	private $_params = [
		'track_opens' => true,
		'track_click' => true,
		'preserve_recipients' => true
	];

	/**
	 * @inheritdoc
	 */
	public function getCharset() {

	}

	/**
	 * @inheritdoc
	 */
	public function setCharset($charset) {

	}

	/**
	 * @inheritdoc
	 */
	public function getFrom() {
		if (isset ( $this->_params ['from_email'] ))
			return $this->_params ['from_email'];
		return null;

	}

	/**
	 * @inheritdoc
	 */
	public function setFrom($from) {
		$this->_params ['from_email'] = $from;
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function getReplyTo() {
		if (isset ( $this->_params ['headers'] ['Reply-To'] ))
			return $this->_params ['header'];
		return null;

	}

	/**
	 * @inheritdoc
	 */
	public function setReplyTo($replyTo) {
		if (! isset ( $this->_params ['headers'] ))
			$this->_params ['headers'] = [ ];
		$this->_params ['headers'] ['Reply-To'] = $replyTo;
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function getTo() {
		if (isset ( $this->_params ['to'] ))
			return $this->_params ['to'];
		return null;

	}

	/**
	 *
	 * @var array string this may contain
	 *      @inheritdoc
	 */
	public function setTo($to) {
		if (is_array ( $to ))
			$this->_params ['to'] = $to;
		else if (is_string ( $to ))
			$this->_params ['to'] = [
				'email' => $to
			];
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function getCc() {
		return null;

	}

	/**
	 * @inheritdoc
	 */
	public function setCc($cc) {
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function getBcc() {
		return null;

	}

	/**
	 * @inheritdoc
	 */
	public function setBcc($bcc) {
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function getSubject() {
		if (isset ( $this->_params ))
			return $this->_params ['subject'];
		else
			return null;

	}

	/**
	 * @inheritdoc
	 */
	public function setSubject($subject) {
		$this->_params ['subject'] = $subject;
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function setTextBody($text) {
		$this->_params ['text'] = $text;
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function setHtmlBody($html) {
		$this->_params ['html'] = $html;
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function attach($fileName, array $options = []) {
		$attachment = \Swift_Attachment::fromPath ( $fileName );
		if (! empty ( $options ['fileName'] )) {
			$attachment->setFilename ( $options ['fileName'] );
		}
		if (! empty ( $options ['contentType'] )) {
			$attachment->setContentType ( $options ['contentType'] );
		}
		$this->attach ( $attachment );
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function attachContent($content, array $options = []) {
		$attachment = \Swift_Attachment::newInstance ( $content );
		if (! empty ( $options ['fileName'] )) {
			$attachment->setFilename ( $options ['fileName'] );
		}
		if (! empty ( $options ['contentType'] )) {
			$attachment->setContentType ( $options ['contentType'] );
		}
		$this->attach ( $attachment );
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function embed($fileName, array $options = []) {
		$embedFile = \Swift_EmbeddedFile::fromPath ( $fileName );
		if (! empty ( $options ['fileName'] )) {
			$embedFile->setFilename ( $options ['fileName'] );
		}
		if (! empty ( $options ['contentType'] )) {
			$embedFile->setContentType ( $options ['contentType'] );
		}
		return $this->embed ( $embedFile );

	}

	/**
	 * @inheritdoc
	 */
	public function embedContent($content, array $options = []) {
		$embedFile = \Swift_EmbeddedFile::newInstance ( $content );
		if (! empty ( $options ['fileName'] )) {
			$embedFile->setFilename ( $options ['fileName'] );
		}
		if (! empty ( $options ['contentType'] )) {
			$embedFile->setContentType ( $options ['contentType'] );
		}
		return $this->embed ( $embedFile );

	}

	/**
	 * @inheritdoc
	 */
	public function toString() {
		return $this->toString ();

	}

	public function setFromName($name) {
		$this->_params ['from_name'] = $name;
		return $this;

	}

	public function getFromName() {
		if (isset ( $this->_params ['from_name'] ))
			return $this->_params ['from_name'];
		return null;

	}

	public function setHeader($key, $value) {
		$this->_params ['header'] [$key] = $value;
		return $this;

	}

	public function setSubAccount($account) {
		$this->_params ['subaccount'] = $account;
		return $this;

	}

	public function getBody() {
		return '';

	}

}