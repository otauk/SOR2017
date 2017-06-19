-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Erstellungszeit: 19. Jun 2017 um 12:01
-- Server Version: 5.5.38
-- PHP-Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `sor2017`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `anmeldungen`
--

DROP TABLE IF EXISTS `anmeldungen`;
CREATE TABLE `anmeldungen` (
`ID` int(11) NOT NULL,
  `klasse` text COLLATE utf8_bin NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `projekt_id` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `anmeldungen`
--

INSERT INTO `anmeldungen` (`ID`, `klasse`, `name`, `projekt_id`) VALUES
(41, '5a', 'Meier, Sabine', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projekte`
--

DROP TABLE IF EXISTS `projekte`;
CREATE TABLE `projekte` (
`ID` int(11) NOT NULL,
  `titel` text COLLATE utf8_bin NOT NULL,
  `lehrer` text COLLATE utf8_bin NOT NULL,
  `maxTN` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `projekte`
--

INSERT INTO `projekte` (`ID`, `titel`, `lehrer`, `maxTN`) VALUES
(1, 'Urban Gardening – Neubeckum wird bunt!', 'Frau Buczka', 30),
(2, 'Experimentieren und bauen zu Klimawandel und Klimaschutz', 'Herr Nübel', 30),
(3, '(Gemeinschafts-) Spiele aus aller Welt', 'Frau Müller', 10),
(4, 'Kunterbunte Sitzgelegenheiten für ein „mobiles Klassenzimmer“ im Grünen gestalten', 'Herr Schmidt', 10),
(5, 'Unser Wunschbaum', '', 15),
(6, 'Theater mit den Vorurteilen', '', 15),
(7, '¡Bailamos! \r\nAlors on danse!\r\nSabes dançar?', '', 16),
(8, 'Bring your song: NO to racism – YES to diversity! \r\n', '', 15),
(9, 'Internationale Sportspiele', '', 30),
(10, 'Die perfekte Welle!', '', 20),
(11, 'SCHULBAND', '', 11),
(12, 'Upcycling', '', 30),
(13, '\r\nAndere Länder – Andere Künstler\r\n', '', 30),
(14, 'Let’s eat British – Eine kulinarische Weltreise\r\n', '', 30),
(15, 'Sport ist bunt – Porträts von Sportstars aus aller Welt\r\n', '', 30),
(16, '„Harry Potter für Arme“ – Brennnesseln im Kochtopf\r\n', '', 30),
(17, '\r\nUnser kunterbuntes Kochbuch\r\n', '', 15),
(18, '\r\nSpiele der Welt\r\n', '', 30),
(19, 'Musical-AG\r\n', '', 11),
(20, '\r\nRegenerative Energien \r\n', '', 15);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schueler`
--

DROP TABLE IF EXISTS `schueler`;
CREATE TABLE `schueler` (
`ID` int(11) NOT NULL,
  `name` text COLLATE utf8_bin NOT NULL,
  `klasse` text COLLATE utf8_bin NOT NULL,
  `angemeldet` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `schueler`
--

INSERT INTO `schueler` (`ID`, `name`, `klasse`, `angemeldet`) VALUES
(1, 'Meier, Sabine', '5a', 1),
(2, 'Müller, Herbert', '6b', 0),
(3, 'Test, Stefan', '5a', 0),
(4, 'Test, Kevon', '5a', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `anmeldungen`
--
ALTER TABLE `anmeldungen`
 ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `projekte`
--
ALTER TABLE `projekte`
 ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `schueler`
--
ALTER TABLE `schueler`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `anmeldungen`
--
ALTER TABLE `anmeldungen`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT für Tabelle `projekte`
--
ALTER TABLE `projekte`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT für Tabelle `schueler`
--
ALTER TABLE `schueler`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
