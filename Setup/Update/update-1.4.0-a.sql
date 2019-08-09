-- create notification table
CREATE TABLE `ost_consultant_notifications` (
  `id` int(11) NOT NULL,
  `key` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `ost_consultant_notifications`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ost_consultant_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- default notification data
INSERT INTO `ost_consultant_notifications` (`id`, `key`, `name`) VALUES
(1, 'B', 'Liefer- und Kundenanschrift'),
(2, 'E', 'E-Mail'),
(3, 'L', 'Lieferanschrift'),
(4, 'M', 'Telefonisch Mobilfunk'),
(5, 'N', 'Nicht avisieren'),
(6, 'R', 'Kundenanschrift'),
(7, 'T', 'Telefonisch Festnetz');