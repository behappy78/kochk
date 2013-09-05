DROP TABLE IF EXISTS `#__mediamallfactory_admin_messages`;
CREATE TABLE `#__mediamallfactory_admin_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `message` mediumtext NOT NULL,
  `pending` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_comments`;
CREATE TABLE `#__mediamallfactory_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` mediumtext NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `votes_up` int(11) NOT NULL,
  `votes_down` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `media_id` (`media_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_comments_votes`;
CREATE TABLE `#__mediamallfactory_comments_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_credits_bonuses`;
CREATE TABLE `#__mediamallfactory_credits_bonuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `credits` int(11) NOT NULL,
  `bonus` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_invoices`;
CREATE TABLE `#__mediamallfactory_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `params` mediumtext NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `vat_rate` decimal(10,2) NOT NULL,
  `vat_value` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_log_balance`;
CREATE TABLE `#__mediamallfactory_log_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `sign` tinyint(4) NOT NULL,
  `media_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `pending` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `media_id` (`media_id`),
  KEY `purchase_id` (`purchase_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_log_credits`;
CREATE TABLE `#__mediamallfactory_log_credits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `credits` int(11) NOT NULL,
  `sign` tinyint(1) NOT NULL,
  `media_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `pending` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `media_id` (`media_id`),
  KEY `purchase_id` (`purchase_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_media`;
CREATE TABLE `#__mediamallfactory_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `votes` int(11) NOT NULL,
  `cost_media` int(11) NOT NULL,
  `cost_archive` int(11) NOT NULL,
  `details_media` mediumtext NOT NULL,
  `details_archive` mediumtext NOT NULL,
  `filename_media` varchar(255) NOT NULL,
  `filename_archive` varchar(255) NOT NULL,
  `filename_thumbnail` varchar(255) NOT NULL,
  `has_media` tinyint(1) NOT NULL,
  `has_archive` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `downloads` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_media_log`;
CREATE TABLE `#__mediamallfactory_media_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `media_id` (`media_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_notifications`;
CREATE TABLE `#__mediamallfactory_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` mediumtext NOT NULL,
  `lang_code` varchar(10) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_orders`;
CREATE TABLE `#__mediamallfactory_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `gateway` varchar(20) NOT NULL,
  `params` mediumtext NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `payment_id` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `payment_id` (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_payment_gateways`;
CREATE TABLE `#__mediamallfactory_payment_gateways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `element` varchar(50) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `purchase_logo` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL,
  `params` mediumtext NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_payment_requests`;
CREATE TABLE `#__mediamallfactory_payment_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `resolved_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_payments`;
CREATE TABLE `#__mediamallfactory_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `gateway` varchar(20) NOT NULL,
  `refnumber` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `request` mediumtext NOT NULL,
  `errors` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_profiles`;
CREATE TABLE `#__mediamallfactory_profiles` (
  `user_id` int(11) NOT NULL,
  `credits` int(11) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `balance_available` decimal(10,2) NOT NULL,
  `revenue` decimal(10,2) NOT NULL,
  `review_id` tinyint(1) NOT NULL,
  `allow_contact` tinyint(1) NOT NULL,
  `list_limit` tinyint(1) NOT NULL,
  `media_list_limit` tinyint(1) NOT NULL,
  `params` mediumtext NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_purchases`;
CREATE TABLE `#__mediamallfactory_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `views_bought` int(11) NOT NULL,
  `views_seen` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `credits` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `pending_seller` tinyint(1) NOT NULL,
  `pending_buyer` tinyint(1) NOT NULL,
  `last_viewed_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `media_id` (`media_id`),
  KEY `user_id` (`user_id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `#__mediamallfactory_types`;
CREATE TABLE `#__mediamallfactory_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `player` varchar(20) NOT NULL,
  `views` int(11) NOT NULL,
  `cost_media` int(11) NOT NULL,
  `cost_archive` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
