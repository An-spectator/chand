CREATE TABLE IF NOT EXISTS `zt_ticket` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `product` mediumint(8) unsigned NOT NULL,
  `module` mediumint(8) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` char(30) NOT NULL,
  `openedBuild` varchar(255) NOT NULL,
  `assignedTo` varchar(255) NOT NULL,
  `assignedDate` datetime NOT NULL,
  `realStarted` datetime NOT NULL,
  `deadline` date NOT NULL,
  `source` mediumint(8) unsigned NOT NULL,
  `pri` tinyint unsigned NOT NULL DEFAULT '0',
  `estimate` float unsigned NOT NULL,
  `consumed` float unsigned NOT NULL,
  `left` float unsigned NOT NULL,
  `desc` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `subStatus` varchar(30) NOT NULL default '',
  `openedBy` char(30) NOT NULL,
  `openedDate` datetime NOT NULL,
  `processedBy` char(30) NOT NULL,
  `processedDate` datetime NOT NULL,
  `closedBy` char(30) NOT NULL,
  `closedDate` datetime NOT NULL,
  `closedReason` varchar(30) NOT NULL,
  `editedBy` char(30) NOT NULL,
  `editedDate` datetime NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `mailto` varchar(255) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  key `product` (`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `zt_ticketsource` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ticketId` mediumint(8) unsigned NOT NULL,
  `customer` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `notifyEmail` varchar(100) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  key `ticketId` (`ticketId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;