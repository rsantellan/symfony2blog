<?php

namespace Maith\Common\MailboxBundle\Model;
use Fetch\Message as FetchMessage;
use Fetch\Attachment as FetchAttachment;
/**
 * Description of LazyMessage
 *
 * @author Rodrigo Santellan
 */
class LazyMessage extends FetchMessage{

    protected $seen = true;
    protected $decodedSubject = '';

	
    /**
     * This constructor takes in the uid for the message and the Imap class representing the mailbox the
     * message should be opened from. This constructor should generally not be called directly, but rather retrieved
     * through the apprioriate Imap functions.
     *
     * @param int    $messageUniqueId
     * @param Server $mailbox
     */
    public function __construct($messageUniqueId, MaithLazyMailboxServer $connection, $cacheData = null)
    {
		if(false && $cacheData)
		{
		  $this->buildFromCache($cacheData);
		}
		else
		{
		  $this->imapConnection = $connection;
		  $this->mailbox        = $connection->getMailBox();
		  $this->uid            = $messageUniqueId;
		  $this->imapStream     = $this->imapConnection->getImapStream();
		  if($this->loadMessage() !== true)
			  throw new \RuntimeException('Message with ID ' . $messageUniqueId . ' not found.');
		}
    }	
	
	private function buildFromCache($cacheData)
	{
	  var_dump(array_keys($cacheData));
	}
	
    /**
     * This function is called when the message class is loaded. It loads general information about the message from the
     * imap server.
     *
     */
    protected function loadMessage($peek = true)
    {

        /* First load the message overview information */

        if(!is_object($messageOverview = $this->getOverview()))
            return false;

        $this->subject = $messageOverview->subject; // 
        $this->date    = strtotime($messageOverview->date);
        $this->size    = $messageOverview->size;

        foreach (self::$flagTypes as $flag)
            $this->status[$flag] = ($messageOverview->$flag == 1);
		//var_dump($messageOverview);
        /* Next load in all of the header information */

        $headers = $this->getHeaders();
        
        $anotherHeader = imap_headerinfo ($this->imapStream, imap_msgno($this->imapStream, $this->uid));
/*
        var_dump($anotherHeader);
        echo '<hr/>';
        var_dump($headers);
        echo '<hr/>';
        echo '<hr/>';
        echo '<hr/>';
*/
//		$ymd = DateTime::createFromFormat('m-d-Y', '10-16-2003')->format('Y-m-d');
        if($anotherHeader->Unseen == "U")
        {
          $this->seen = false;
        }
        // 
        if (isset($headers->to))
            $this->to = $this->processAddressObject($headers->to);

        if (isset($headers->cc))
            $this->cc = $this->processAddressObject($headers->cc);

        if (isset($headers->bcc))
            $this->bcc = $this->processAddressObject($headers->bcc);

        $this->from    = $this->processAddressObject($headers->from);
        $this->replyTo = isset($headers->reply_to) ? $this->processAddressObject($headers->reply_to) : $this->from;

        /* Finally load the structure itself */

        $structure = $this->getStructure();
        //$parameters = FetchMessage::getParametersFromStructure($structure);
		//var_dump($parameters);
		$this->decodedSubject = iconv_mime_decode($this->subject, 0, "UTF8");//utf8_decode(imap_utf8($this->subject));
//		var_dump(iconv_mime_decode($this->subject, 0, "ISO-8859-1"));
//		var_dump(iconv_mime_decode($this->subject, 0, "UTF8"));
//		var_dump(iconv_mime_decode("Subject: =?UTF-8?B?UHLDvGZ1bmcgUHLDvGZ1bmc=?=", 0, "ISO-8859-1"));
        //$this->decodedSubject =  iconv('ISO-8859-1', FetchMessage::$charset, $this->subject);//
        if (!isset($structure->parts)) {
            // not multipart
            $this->processStructure($structure, null, $peek);
        } else {
            // multipart
            foreach ($structure->parts as $id => $part)
                $this->processStructure($part, $id + 1, $peek);
        }
        return true;
    }
	
    /**
     * This function takes in a structure and identifier and processes that part of the message. If that portion of the
     * message has its own subparts, those are recursively processed using this function.
     *
     * @param \stdClass $structure
     * @param string    $partIdentifier
     * @todoa process attachments.
     */
    protected function processStructure($structure, $partIdentifier = null, $peek = true)
    {
		if(!$peek)
		{
		  return parent::processStructure($structure, $partIdentifier);
		}
        $parameters = self::getParametersFromStructure($structure);

        if (isset($parameters['name']) || isset($parameters['filename'])) {
            $attachment          = new FetchAttachment($this, $structure, $partIdentifier);
            $this->attachments[] = $attachment;
        } elseif ($structure->type == 0 || $structure->type == 1) {
            $messageBody = isset($partIdentifier) ?
                imap_fetchbody($this->imapStream, $this->uid, $partIdentifier, FT_UID | FT_PEEK)
                : imap_body($this->imapStream, $this->uid, FT_UID | FT_PEEK);

            $messageBody = self::decode($messageBody, $structure->encoding);

            if (!empty($parameters['charset']) && $parameters['charset'] !== self::$charset)
                $messageBody = iconv($parameters['charset'], self::$charset, $messageBody);

            if (strtolower($structure->subtype) === 'plain' || ($structure->type == 1 && strtolower($structure->subtype) !== 'alternative')) {
                if (isset($this->plaintextMessage)) {
                    $this->plaintextMessage .= PHP_EOL . PHP_EOL;
                } else {
                    $this->plaintextMessage = '';
                }

                $this->plaintextMessage .= trim($messageBody);
            } else {
                if (isset($this->htmlMessage)) {
                    $this->htmlMessage .= '<br><br>';
                } else {
                    $this->htmlMessage = '';
                }

                $this->htmlMessage .= $messageBody;
            }
        }

        if (isset($structure->parts)) { // multipart: iterate through each part

            foreach ($structure->parts as $partIndex => $part) {
                $partId = $partIndex + 1;

                if (isset($partIdentifier))
                    $partId = $partIdentifier . '.' . $partId;

                $this->processStructure($part, $partId, $peek);
            }
        }
    }	

    public function getStatus() {
      return $this->status;
    }

    public function setStatus($status) {
      $this->status = $status;
    }

    public function getPlaintextMessage() {
      return $this->plaintextMessage;
    }

    public function setPlaintextMessage($plaintextMessage) {
      $this->plaintextMessage = $plaintextMessage;
    }

    public function getHtmlMessage() {
      return $this->htmlMessage;
    }

    public function setHtmlMessage($htmlMessage) {
      $this->htmlMessage = $htmlMessage;
    }

    public function getSize() {
      return $this->size;
    }

    public function setSize($size) {
      $this->size = $size;
    }

    public function getFrom() {
      return $this->from;
    }

    public function setFrom($from) {
      $this->from = $from;
    }

    public function getTo() {
      return $this->to;
    }

    public function setTo($to) {
      $this->to = $to;
    }

    public function getCc() {
      return $this->cc;
    }

    public function setCc($cc) {
      $this->cc = $cc;
    }

    public function getBcc() {
      return $this->bcc;
    }

    public function setBcc($bcc) {
      $this->bcc = $bcc;
    }

    public function getReplyTo() {
      return $this->replyTo;
    }
    
    public function getSeen() {
      return $this->seen;
    }

    public function setSeen($seen) {
      $this->seen = $seen;
    }
    
    public function hasAttachments()
    {
      $quantity = $this->getAttachments();
      if($quantity)
      {
        return true;
      }
      return false;
    }
    
    public function getDecodedSubject() {
      return $this->decodedSubject;
    }

    public function setDecodedSubject($decodedSubject) {
      $this->decodedSubject = $decodedSubject;
    }


}


