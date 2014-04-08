<?php
/**
 * Technooze_Tnav extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Technooze
 * @package    Technooze_Tnav
 * @copyright  Copyright (c) 2008 Technooze LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Technooze
 * @package    Technooze_Tnav
 * @author     Damodar Bashyal (http://dltr.org/)
 */
$installer = $this;

$installer->startSetup();

$installer->run("

CREATE TABLE {$this->getTable('technooze_tnav')} (
  `tnav_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `thumbnail` varchar(255) NOT NULL default '',
  `url_key` varchar(255) NOT NULL default '',
  `children_ids` varchar(255) NOT NULL default '',
  `sort_order` int(11) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`tnav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS {$this->getTable('technooze_tnav_categories')} (
  `tnav_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();