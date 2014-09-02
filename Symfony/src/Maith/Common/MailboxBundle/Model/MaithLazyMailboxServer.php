<?php

namespace Maith\Common\MailboxBundle\Model;

use Doctrine\DBAL\Connection;
use Fetch\Server as FetchServer;
/**
 * Description of MaithLazyMailboxServer
 *
 * @author Rodrigo Santellan
 */
class MaithLazyMailboxServer extends FetchServer{

  private $uidList = array();
  private $page = 0;
  private $limitSize = 10;
  
  /**
  *
  * @var Connection
  */
  private $connection;  
  
  function __construct(Connection $dbalConnection) {
	$this->connection = $dbalConnection;
  }

  public function setConnectionData($serverPath, $port = 143, $service = 'imap')
  {
		$this->serverPath = $serverPath;

        $this->port = $port;

        switch ($port) {
            case 143:
                $this->setFlag('novalidate-cert');
                break;

            case 993:
                $this->setFlag('ssl');
                break;
        }

        $this->service = $service;
  }
  
  public function getLimitSize()
  {
	return $this->limitSize;
  }

  public function setLimitSize($limitSize)
  {
	$this->limitSize = $limitSize;
  }
  
  
  /**
   * This function returns an array of ImapMessage object for emails that fit the criteria passed. The criteria string
   * should be formatted according to the imap search standard, which can be found on the php "imap_search" page or in
   * section 6.4.4 of RFC 2060
   *
   * @link http://us.php.net/imap_search
   * @link http://www.faqs.org/rfcs/rfc2060
   * @param  string   $criteria
   * @param  null|int $limit
   * @return array    An array of ImapMessage objects
   */
  public function search($criteria = 'ALL', $limit = null)
  {
	  $cacheKey = $this->getServerString().'-'.$criteria;
//	  if ($this->cacheHandler !== null) {
//
//		$results = $this->cacheHandler->getData($cacheKey, 'uidlist');
//		if ($results) {
//		  $this->uidList = $results;
//
//		  return true;
//		}
//	  }

	  if ($results = imap_search($this->getImapStream(), $criteria, SE_UID)) {
		  $this->uidList = $results;
//		  if ($this->cacheHandler !== null) {
//			$this->cacheHandler->saveData($cacheKey, 'uidlist', $results);
//		  }
		  var_dump(count($results));
		  return true;
	  } else {
		  return false;
	  }
  }

  public function retrieveNextMessagesInLine($page = null)
  {
	if($page !== null){
	  $this->page = $page;
	}
	$results = array_slice($this->uidList, $this->page, $this->getLimitSize());
	$messages = array();
	$this->page ++;
	foreach ($results as $messageId) {
	  $cacheKey = $this->getServerString().'-'.$messageId;
	  $inCache = false;
//	  if ($this->cacheHandler !== null) {
//		$message  = $this->cacheHandler->getData($cacheKey, 'messagelist');
//		if ($message) {
//		  $messages[] = $message;
//		  $inCache = true;
//		}
//	  }
	  if (!$inCache) {
		$message = new LazyMessage($messageId, $this);
		$messages[] = $message;
//		if ($this->cacheHandler !== null) {
//		  $this->cacheHandler->saveData($cacheKey, 'messagelist', $message);
//		}
	  }
	}

	return $messages;
  }


  public function retrieveAllMailboxes()
  {
//	if ($this->cacheHandler !== null) {
//	  $folders  = $this->cacheHandler->getData($this->getServerSpecification(), 'folderlist');
//	  if($folders !== null)
//	  {
//		return $folders;
//	  }
//
//	}
	$folders = imap_list($this->getImapStream(), $this->getServerSpecification(), '*');
	$returnFolders = array();
	foreach ($folders as $folder) {
	  $folder = str_replace($this->getServerSpecification(), "", imap_utf7_decode($folder));
	  $returnFolders[] = $folder;
	}
//	var_dump($returnFolders);
//	if ($this->cacheHandler !== null) {
//	  $this->cacheHandler->saveData($this->getServerSpecification(), 'folderlist', $returnFolders);
//	}
	
	return $returnFolders;

  }  
  
  
  protected function getData(){
	switch ($datatype){
        
        case 'uidlist':
          $sqlselect = 'select datakey, data from datacontainer where datakey = :datakey';
          $stmt = $this->dbfile->prepare($sqlselect);
          $stmt->bind(':datakey', $key);
          //$stmt->execute();
          $data = $stmt->fetchAll();
          var_dump($data);
          break;
        
        case 'messagelist':
          $sqlselect = 'select uid, headers, plaintextMessage, htmlMessage, date , subject, size, headerfrom, headerto, headercc, headerbcc, headerreplyTo, hasAttachment, email from messages';
          break;
      }
  }
  
  protected function saveData(){
	switch ($datatype){
        case 'folderlist':
          $sqlinsert = 'INSERT into folderlist (foldername, connectionstring) values (:foldername, :connectionstring)';
          $stmt = $this->db_file->prepare($sqlinsert);
          var_dump($data);
          foreach($data as $folder)
          {
            $stmt->bindParam('foldername', $folder);
            $stmt->bindParam('connectionstring', $key);
            $stmt->execute();
          }
          break;
        
        case 'uidlist':
          $sqlinsert = 'INSERT INTO datacontainer (datakey, data) values (:datakey, :data)';
          $stmt = $this->db_file->prepare($sqlinsert);
          $stmt->bindParam('datakey', $key);
          $stmt->bindParam('data', serialize($data));
          $stmt->execute();
          break;
        
        case 'messagelist':
          $sqlinsert = 'INSERT INTO messages (uid, headers, plaintextMessage, htmlMessage, date , subject, size, headerfrom, headerto, headercc, headerbcc, headerreplyTo, hasAttachment, email) ';
          $sqlinsert .= 'VALUES (:uid, :headers, :plaintextMessage, :htmlMessage, :date , :subject, :size, :from, :to, :cc, :bcc, :replyTo, :hasAttachment, :email)';
          $stmt = $this->db_file->prepare($sqlinsert);
          $stmt->bindParam('uid', $data->getUid());
          $stmt->bindParam('headers', serialize($data->getHeaders()));
          $stmt->bindParam('plaintextMessage', $data->getPlaintextMessage());
          $stmt->bindParam('htmlMessage', $data->getHtmlMessage());
          $stmt->bindParam('date', $data->getDate());
          $stmt->bindParam('subject', $data->getSubject());
          $stmt->bindParam('size', $data->getSize());
          $stmt->bindParam('from', serialize($data->getFrom()));
          $stmt->bindParam('to', serialize($data->getTo()));
          $stmt->bindParam('cc', serialize($data->getCc()));
          $stmt->bindParam('bcc', serialize($data->getBcc()));
          $hasAttachment = 0;
          if($data->getAttachments()){
            $hasAttachment = 1;
          }
          $stmt->bindParam('hasAttachment', $hasAttachment);
          $stmt->execute();
          break;
      }
  }
  
}

