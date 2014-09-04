CREATE TABLE IF NOT EXISTS `mailboxfolders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `connectionstring` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=162 ;

-- --------------------------------------------------------

--
-- Table structure for table `mailboxupdated`
--

CREATE TABLE IF NOT EXISTS `mailboxupdated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastupdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `connectionstring` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `updatedkey` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
SET FOREIGN_KEY_CHECKS=1;
