<?php

namespace Maith\Common\MailboxBundle\Model;
use Fetch\Message as FetchMessage;
/**
 * Description of LazyMessage
 *
 * @author Rodrigo Santellan
 */
class LazyMessage extends FetchMessage{


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

        $this->subject = $messageOverview->subject;
        $this->date    = strtotime($messageOverview->date);
        $this->size    = $messageOverview->size;

        foreach (self::$flagTypes as $flag)
            $this->status[$flag] = ($messageOverview->$flag == 1);
		//var_dump($messageOverview);
        /* Next load in all of the header information */

        $headers = $this->getHeaders();
		//var_dump($headers);
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
            $attachment          = new Attachment($this, $structure, $partIdentifier);
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
  
}


