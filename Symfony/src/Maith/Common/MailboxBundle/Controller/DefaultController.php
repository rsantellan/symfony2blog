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
        return $this->render('MaithCommonMailboxBundle:Default:index.html.twig', array('folders' => $folders));
    }
	
	public function folderAction($folderId)
	{
	  $mailbox = $this->getConfiguredMailbox();
	  $folder = $mailbox->getFolderById($folderId);
      if(!$folder)
      {
        throw $this->createNotFoundException("No mailbox with id: ".$folderId);
      }
	  $mailbox->setMailBox($folder['name']);
      $mailbox->searchAndReverse();
      $messages = $mailbox->retrieveNextMessagesInLine();
      return $this->render('MaithCommonMailboxBundle:Default:folder.html.twig', array('folder' => $folder, 'messages' => $messages));
	  //var_dump($folder);
	}
	
	
}
