<?php

namespace Maith\Common\MailboxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
		$mailbox = $this->get('maith_mailbox.server');
		var_dump(get_class($mailbox));
		$mailbox->setConnectionData('imap.gmail.com', 993);
		$mailbox->setAuthentication('rsantellan@gmail.com', 'XXXXXXXXXXXXXX');
		var_dump($mailbox->numMessages());
		$mailbox->search();
		$folders = $mailbox->retrieveAllMailboxes();
		var_dump($folders);
                $mailbox->setLimitSize(1);
		$messages = $mailbox->retrieveNextMessagesInLine();
                
		var_dump(count($messages));
                
        return $this->render('MaithCommonMailboxBundle:Default:index.html.twig', array('name' => $name));
    }
}
