CREATE TABLE IF NOT EXISTS `mailboxfolders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `connectionstring` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mailboxupdated`
--

CREATE TABLE `mailboxupdated` (
  `lastupdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `connectionstring` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `updatedkey` varchar(255) NOT NULL,
  PRIMARY KEY (`connectionstring`,`user`,`updatedkey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `mailboxmessages` (
  `uid` int(11) NOT NULL,
  `headers` blob NOT NULL,
  `plainMessage` text,
  `htmlMessage` text,
  `messageDate` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `decodedSubject` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `hasAttachment` tinyint(1) NOT NULL DEFAULT '0',
  `readed` tinyint(1) NOT NULL DEFAULT '0',
  `headerFrom` blob NOT NULL,
  `headerTo` blob NOT NULL,
  `headerCc` blob NOT NULL,
  `headerBcc` blob NOT NULL,
  `headerReplyTo` blob NOT NULL,
  `connectionstring` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`,`connectionstring`,`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


SET FOREIGN_KEY_CHECKS=1;
