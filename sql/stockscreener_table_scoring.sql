
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `scoring`
--

CREATE TABLE `scoring` (
  `id` int(11) NOT NULL DEFAULT 0,
  `ticker` varchar(255) NOT NULL,
  `high` int(5) DEFAULT NULL,
  `chg` int(5) DEFAULT NULL,
  `atr` int(5) DEFAULT NULL,
  `sma20` int(5) DEFAULT NULL,
  `sma50` int(5) DEFAULT NULL,
  `sma200` int(5) DEFAULT NULL,
  `low1m` int(5) DEFAULT NULL,
  `high1m` int(5) DEFAULT NULL,
  `high3m` int(5) DEFAULT NULL,
  `high6m` int(5) DEFAULT NULL,
  `volatilityday` int(5) DEFAULT NULL,
  `volatilityweek` int(5) DEFAULT NULL,
  `date` datetime DEFAULT NULL,

) ENGINE=InnoDB DEFAULT CHARSET=latin1;


