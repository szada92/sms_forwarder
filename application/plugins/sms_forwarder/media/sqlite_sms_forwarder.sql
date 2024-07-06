-- --------------------------------------------------------

--
-- Table structure for table `plugin_sms_forwarder`
--

CREATE TABLE IF NOT EXISTS "plugin_sms_forwarder" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  `enabled` BOOLEAN NOT NULL default 'TRUE',
  "trigger_sender_phone_number" TEXT,
  "trigger_sms_contains" TEXT,
  "phonebook_group_id" INTEGER NOT NULL,
  "reg_date" DATETIME NOT NULL
);