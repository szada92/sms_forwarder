-- --------------------------------------------------------

--
-- Table structure for table `plugin_sms_forwarder`
--

CREATE TABLE IF NOT EXISTS `plugin_sms_forwarder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enabled` boolean NOT NULL default 1,
  `trigger_sender_phone_number` text NULL,
  `trigger_sms_contains` text NULL,
  `phonebook_group_id` int(11) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
);