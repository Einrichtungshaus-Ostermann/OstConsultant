-- create discount table
CREATE TABLE `ost_consultant_discounts` (
  `id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `type` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `target` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `fixed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `ost_consultant_discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_numbers` (`number`,`company`) USING BTREE;

ALTER TABLE `ost_consultant_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- our discount data
INSERT INTO `ost_consultant_discounts` (`id`, `company`, `number`, `type`, `target`, `name`, `value`, `fixed`) VALUES
(1, 1, 413, 'A', 'P', 'HARDECK MKO-NL-P', 0, 0),
(2, 1, 419, 'A', 'P', 'HÖFFNER MKO-NL-P', 0, 0),
(3, 3, 419, 'A', 'P', 'HÖFFNER MKO-NL-P', 0, 0),
(4, 1, 415, 'A', 'P', 'KRÖGER MKO-NL-P', 0, 0),
(5, 3, 415, 'A', 'P', 'KRÖGER MKO-NL-P', 0, 0),
(6, 1, 175, 'P', 'K', 'Personal-Angehörigennachlass', 6, 1),
(7, 3, 175, 'P', 'K', 'Personal-Nachl. Angehörige', 6, 1),
(8, 1, 150, 'P', 'K', 'Personal- Mitarbeiternachlass', 12, 1),
(9, 3, 150, 'P', 'K', 'Personal-Nachl. Mitarbeiter', 12, 1),
(10, 1, 151, 'P', 'K', 'Personal-Mitarbeiternachlass', 6, 1),
(11, 3, 151, 'P', 'K', 'Personal-Nachl. Mitarbeiter', 6, 1),
(12, 1, 435, 'A', 'P', 'PORTA MKO-NL-P', 0, 0),
(13, 1, 433, 'A', 'P', 'ROLLER MKO-NL-P', 0, 0),
(14, 3, 433, 'A', 'P', 'ROLLER MKO-NL-P', 0, 0),
(15, 1, 417, 'A', 'P', 'RÜCK MKO-NL-P', 0, 0),
(16, 3, 417, 'A', 'P', 'RÜCK MKO-NL-P', 0, 0),
(17, 1, 421, 'A', 'P', 'SCHAFFRATH MKO-NL-P', 0, 0),
(18, 3, 421, 'A', 'P', 'SCHAFFRATH MKO-NL-P', 0, 0),
(19, 1, 441, 'A', 'P', 'SEGMÜLLER MKO-NL-P', 0, 0),
(20, 3, 441, 'A', 'P', 'SEGMÜLLER MKO-NL-P', 0, 0),
(21, 1, 140, 'A', 'K', 'Sondernachlass', 0, 0),
(22, 3, 140, 'A', 'K', 'Sondernachlass', 0, 0),
(23, 1, 643, 'P', 'K', 'Stammkundenrabatt (Kopf)', 10, 1),
(24, 3, 643, 'P', 'K', 'Stammkundenrabatt (Kopf)', 20, 1),
(25, 1, 644, 'A', 'P', 'Stammkundenrabatt (Position)', 19.49, 0),
(26, 3, 644, 'P', 'P', 'Stammkundenrabatt (Position)', 20, 1),
(27, 1, 423, 'A', 'P', 'VONNAHME MKO-NL-P', 0, 0),
(28, 3, 423, 'A', 'P', 'VONNAHME MKO-NL-P', 0, 0),
(29, 1, 141, 'A', 'K', 'Nachlass Werbung', 0, 0),
(30, 3, 141, 'A', 'K', 'Nachlass Werbung', 0, 0),
(31, 1, 411, 'A', 'P', 'ZURBRÜGGEN MKO-NL-P', 0, 0),
(32, 3, 411, 'A', 'P', 'ZURBRÜGGEN MKO-NL-P', 0, 0);