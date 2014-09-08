<?php

namespace Maith\Common\MailboxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	protected function getConfiguredMailbox()
	{
	  $mailbox = $this->get('maith_mailbox.server');
	  //var_dump(get_class($mailbox));
	  $mailbox->setConnectionData('imap.gmail.com', 993);
	  $mailbox->setAuthentication('rsantellan@gmail.com', 'XXXXXXXXXXXXXXX');
	  return $mailbox;
	}
  
	public function indexAction()
    {
		$mailbox = $this->getConfiguredMailbox();
		//var_dump($mailbox->numMessages());
		//$mailbox->search('UNSEEN');
		$folders = $mailbox->retrieveAllMailboxes();
		//var_dump($folders);
        //        $mailbox->setLimitSize(1);
		//$messages = $mailbox->retrieveNextMessagesInLine();
                
		//var_dump(count($messages));
        $mailbox->closeImapStream();
        return $this->render('MaithCommonMailboxBundle:Default:index.html.twig', array('folders' => $folders));
    }
	
	public function folderAction($folderId, $page = 0)
	{
      if(!is_int($page))
      {
        $page = 0;
      }
      echo sprintf('Controller start: %s', microtime(true));
      echo '<hr/>';
	  $mailbox = $this->getConfiguredMailbox();
      echo sprintf('Get configured mailbox: %s', microtime(true));
      echo '<hr/>';
	  $folder = $mailbox->getFolderById($folderId);
      echo sprintf('Get folder mailbox: %s', microtime(true));
      echo '<hr/>';
      if(!$folder)
      {
        throw $this->createNotFoundException("No mailbox with id: ".$folderId);
      }
      echo sprintf('Set folder mailbox: %s', microtime(true));
      echo '<hr/>';
	  $mailbox->setMailBox($folder['name']);
      echo sprintf('Set mailbox query: %s', microtime(true));
      echo '<hr/>';
      $mailbox->searchAndReverse();
      //$mailbox->searchAndReverse('SINCE '. date('d-M-Y',strtotime("-1 week")));
      echo sprintf('Retrieve data query: %s', microtime(true));
      echo '<hr/>';
      $messages = $mailbox->retrieveNextMessagesInLine($page);
      echo sprintf('Close Stream query: %s', microtime(true));
      echo '<hr/>';
      $mailbox->closeImapStream();
      return $this->render('MaithCommonMailboxBundle:Default:folder.html.twig', array('folder' => $folder, 'messages' => $messages));
	  //var_dump($folder);
	}
	
	
}
