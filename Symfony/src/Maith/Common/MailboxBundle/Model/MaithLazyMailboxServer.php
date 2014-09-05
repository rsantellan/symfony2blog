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

  const FOLDERSKEY = 'folders';
  
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
	  if ($results = imap_search($this->getImapStream(), $criteria, SE_UID)) {
		  $this->uidList = $results;
		  return true;
	  } else {
		  return false;
	  }
  }
  
  public function searchAndReverse($criteria = 'ALL'){
	if($this->search($criteria))
	{
	  $this->uidList = array_reverse($this->uidList);
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
	  $message = new LazyMessage($messageId, $this);
	  $messages[] = $message;
	}
	return $messages;
  }
  
  public function getFolderById($folderId)
  {
	$retrieveSql = 'select id, name from mailboxfolders where connectionstring = :connectionstring and user = :user and id = :id';
	$stmt = $this->connection->prepare($retrieveSql);
	$stmt->bindValue('connectionstring', $this->getServerSpecification());
	$stmt->bindValue('user', $this->username);
	$stmt->bindValue('id', $folderId);
	$stmt->execute();
	return $stmt->fetch();
  }


  public function retrieveAllMailboxes()
  {
	$lastupdated = $this->retrieveLastUpdated(self::FOLDERSKEY);
    $updateFolders = false;
    if($lastupdated < strtotime("-1 week"))
    {
      $updateFolders = true;
    }
    $returnFolders = $this->retrieveDbMailboxFolders(); 
    if(count($returnFolders) > 0 && !$updateFolders)
    {
      return $returnFolders;
    }
	$folders = imap_list($this->getImapStream(), $this->getServerSpecification(), '*');
	
	foreach ($folders as $folder) {
	  $folder = str_replace($this->getServerSpecification(), "", imap_utf7_decode($folder));
	  $returnFolders[] = $folder;
	}
    
    $this->saveLastUpdated(self::FOLDERSKEY);
    if(!$updateFolders)
    {
      return $this->saveImapFolderToDb($folders);
    }
    else
    {
      return $this->updateImapFolderToDb($folders, $returnFolders);
    }
	
  }  
  
  private function updateImapFolderToDb($folders, $returnFolders)
  {
    
    $insertsql = 'INSERT INTO mailboxfolders (  name  ,  connectionstring  ,  user  ) VALUES ( :name, :connectionstring, :user )';
    $stmtinsert = $this->connection->prepare($insertsql);
    foreach($folders as $folder)
	{
	  $folder = str_replace($this->getServerSpecification(), "", imap_utf7_decode($folder));
      if(!in_array($folder, $returnFolders))
      {
        $stmtinsert->bindValue('name', $folder);
        $stmtinsert->bindValue('connectionstring', $this->getServerSpecification());
        $stmtinsert->bindValue('user', $this->username);
        $stmtinsert->execute();
        $returnFolders[$this->connection->lastInsertId()] = $folder;
      }
    }
    //Missing the folder deletion on server.
    //TODO
    return $returnFolders;
  }
  
  private function saveImapFolderToDb($folders)
  {
    $returnFolders = array();
    $insertsql = 'INSERT INTO mailboxfolders (  name  ,  connectionstring  ,  user  ) VALUES ( :name, :connectionstring, :user )';
	$stmtinsert = $this->connection->prepare($insertsql);
	foreach($folders as $folder)
	{
	  $folder = str_replace($this->getServerSpecification(), "", imap_utf7_decode($folder));
	  $stmtinsert->bindValue('name', $folder);
	  $stmtinsert->bindValue('connectionstring', $this->getServerSpecification());
	  $stmtinsert->bindValue('user', $this->username);
	  $stmtinsert->execute();
	  $returnFolders[$this->connection->lastInsertId()] = $folder;
	}
    return $returnFolders;
  }

  
  private function retrieveDbMailboxFolders()
  {
    $retrieveSql = 'select id, name from mailboxfolders where connectionstring = :connectionstring and user = :user';
	$stmt = $this->connection->prepare($retrieveSql);
	$stmt->bindValue('connectionstring', $this->getServerSpecification());
	$stmt->bindValue('user', $this->username);
	$stmt->execute();
	$dbfolders = $stmt->fetchAll();
	$returnFolders = array();
	if(count($dbfolders) > 0)
	{
	  foreach($dbfolders as $folder)
	  {
		$returnFolders[$folder['id']] = $folder['name'];
	  }
	}
    return $returnFolders;
  }
  
  private function saveLastUpdated($key)
  {
    $insertSql = 'insert into mailboxupdated (lastupdated, connectionstring, user, updatedkey) values ( now(), :connectionstring, :user, :updatedkey) ';
    $insertSql .= ' on duplicate key update lastupdated = now()';
    $stmtLastUpdated = $this->connection->prepare($insertSql);
	$stmtLastUpdated->bindValue('updatedkey', $key);
	$stmtLastUpdated->bindValue('connectionstring', $this->getServerSpecification());
	$stmtLastUpdated->bindValue('user', $this->username);
	$stmtLastUpdated->execute();
  }
  
  private function retrieveLastUpdated($key)
  {
    $lastupdatesql = 'select UNIX_TIMESTAMP(lastupdated) as lastupdated from mailboxupdated where connectionstring = :connectionstring and user = :user and updatedkey = :updatedkey';
	$stmtLastUpdated = $this->connection->prepare($lastupdatesql);
	$stmtLastUpdated->bindValue('updatedkey', $key);
	$stmtLastUpdated->bindValue('connectionstring', $this->getServerSpecification());
	$stmtLastUpdated->bindValue('user', $this->username);
	$stmtLastUpdated->execute();
	$lastupdated = $stmtLastUpdated->fetch();
	if($lastupdated)
	{
	  $lastupdated = $lastupdated['lastupdated'];
	}
    return $lastupdated;
  }
  
  protected function getData(){
    switch ($datatype){
        case 'uidlist':
          $sqlselect = 'select datakey, data from datacontainer where datakey = :datakey';
          $stmt = $this->dbfile->prepare($sqlselect);
          $stmt->bind(':datakey', $key);
          //$stmt->execute();
          $data = $stmt->fetchAll();
          //var_dump($data);
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

