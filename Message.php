<?php

namespace kakalos12\mandrill;

use yii\mail\BaseMessage;

class Message extends BaseMessage {

	private $_mandrillMessage = null;

	private $_params = [ ];

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
		$this->setBody ( $text, 'text/plain' );
		return $this;

	}

	/**
	 * @inheritdoc
	 */
	public function setHtmlBody($html) {
		$this->setBody ( $html, 'text/html' );
		return $this;

	}

	/**
	 * Sets the message body.
	 * If body is already set and its content type matches given one, it will
	 * be overridden, if content type miss match the multipart message will be composed.
	 *
	 * @param string $body
	 *        	body content.
	 * @param string $contentType
	 *        	body content type.
	 */
	protected function setBody($body, $contentType) {
		$message = $this;
		$oldBody = $message->getBody ();
		$charset = $message->getCharset ();
		if (empty ( $oldBody )) {
			$parts = $message->getChildren ();
			$partFound = false;
			foreach ( $parts as $key => $part ) {
				if (! ($part instanceof \Swift_Mime_Attachment)) {
					/* @var \Swift_Mime_MimePart $part */
					if ($part->getContentType () == $contentType) {
						$charset = $part->getCharset ();
						unset ( $parts [$key] );
						$partFound = true;
						break;
					}
				}
			}
			if ($partFound) {
				reset ( $parts );
				$message->setChildren ( $parts );
				$message->addPart ( $body, $contentType, $charset );
			} else {
				$message->setBody ( $body, $contentType );
			}
		} else {
			$oldContentType = $message->getContentType ();
			if ($oldContentType == $contentType) {
				$message->setBody ( $body, $contentType );
			} else {
				$message->setBody ( null );
				$message->setContentType ( null );
				$message->addPart ( $oldBody, $oldContentType, $charset );
				$message->addPart ( $body, $contentType, $charset );
			}
		}

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

	/**
	 * Creates the Swift email message instance.
	 *
	 * @return \Swift_Message email message instance.
	 */
	protected function createSwiftMessage() {
		return new \Swift_Message ();

	}

}