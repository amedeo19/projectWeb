-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2018 at 11:58 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(40) NOT NULL,
  `e_mail_admin` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `codice` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `admin`
--

INSERT INTO `admin` (`username`, `e_mail_admin`, `password`, `codice`) VALUES
('thomas', 'thomas.angelini@studio.unibo.it', '1926d83f60458ec011277bd77f8025f74b56b4a3da6d560d9470e3e42ab9b201249885d796c6c7c3aa6972ae815ceeb27bce25f5ce090dd084ee0ce41dc5fe30', 'd7e810aad274b6997bb3945b0b273cc7f08faaa8b9c1049ee300edee844f674d2ad4b8911b3c1f3fbfa19320611f9bec4a120f0edc39b1916b107acf9975d7c1'),
('amedeo', 'amedeo.bertuccioli@studio.unibo.it', '5feeae8f76e2e36a85c54caed688074f6d6ffd52aa5ba796fdf1f5469e8a428c5fd7d48656f66cd8a08f4340dadd10f95a4b1ff2605ebf74f44615904cf4a5a8' , '0beada5567b9cfcfd0611dc95f29ff500cd0430e4f3c17b247a9052057f0fcc9f20b18cf71496e0d7d8d6f2721e7b270d4cdf100b8e3a64f41a87661d932fdc1'),
('luca', 'luca.ghigi2@studio.unibo.it', '9726f93c476e6605b7f845a2405af9d2b0f69a948d51b70255ab94447660463ad6763666a80b9899518dd8e5a03c40e7719b87388b70dba717aa832525cd9377' , 'a4598d30fc537c5187137bba60d7102bd226f0e5365bfdcb936a0c67893a123176b93564437cf176f6a601be252dd335cc385f5898ad7887e192cfdf46bd7527');

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `name` char(15) NOT NULL,
  `surname` char(20) NOT NULL,
  `e_mail_cliente` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `citta` varchar(40) NOT NULL,
  `telefono` numeric(10) NOT NULL,
  `fotoProfilo` varchar(30) DEFAULT 'profile.jpg',
  `codice` char(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`name`, `surname`, `e_mail_cliente`, `password`, `citta`, `telefono`, `fotoProfilo`, `codice`) VALUES
('Gigino', 'Tizio', 'gigi.ino@gmail.com', '3a5af989f5427f0780671018b17441f68b4fba761f67c7bcd5dbe5c82b0dbd4dd6c721bb76f7c24844c355986295d6fed7bf87bc766804c2eaeed83bd355ca40', 'Cesenatico', 3345698850, 'profile.jpg', 'f2785edca6d637e5859de0b65b8924268543ba51f4dcba6a0505bd8aef07ec96875f5e844a6b341e920bfeaabd133a0536e01a3bb9cfc281f31e14a66e2f6350'),
('Tom', 'Jerry', 'tom.jerry@gmail.com', '7133692af03b41557a0b08d8cee23e3b49b7de550f435a2a48a601f4551b9f885e8cf7c1b2b2d54379efe5cb10074ca759d618847249139e4201693f3c3f60d5', 'Cesena', 3284575590, 'tom.jpg' ,'a823984b4e8099fa72b3d3a6e454ba3097ede44deb096db6d5214d4682d5e10a5a67993dad7ddbbf36fe4fdc90cf5deef8a768843109ed8ceace8ceb99f0023b'),
('Chris', 'Heria', 'chris.heria@libero.it', '24b9091243404f5fa9741abe76da35ac2916780be538fb75e53a8d24a45039441d8694533ad02edfb99a9489c633d44018778e3ada4b068c5e722695102d2e11', 'Rimini', 3664589560, 'profile.jpg', '0ac6a942a67641766d4dda888a926dfc64e3b9c6d4c4d0e375d63565688b5cad87aaaad3f3aaa3877108208cdccf81083565446b3456a42d31d037baec5175a2');
/*gigino tommy chris*/
-- --------------------------------------------------------

--
-- Table structure for table `fornitore`
--

CREATE TABLE `fornitore` (
  `name` varchar(40) NOT NULL,
  `categoria` varchar(40) NOT NULL,
  `e_mail_fornitore` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `citta` varchar(40) NOT NULL,
  `indirizzo` varchar(60) NOT NULL,
  `desc1` varchar(300) NOT NULL,
  `desc2` varchar(300) NOT NULL,
  `img1` varchar(50) DEFAULT NULL COMMENT 'percorso immagine',
  `img2` varchar(50) DEFAULT NULL COMMENT 'percorso immagine',
  `img3` varchar(50) DEFAULT NULL COMMENT 'percorso immagine',
  `telefono` numeric(10) NOT NULL,
  `codice` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `fornitore`
--

INSERT INTO `fornitore` (`name`, `categoria`, `e_mail_fornitore`, `password`, `citta`, `indirizzo`, `desc1`, `desc2`, `img1`, `img2`, `img3`, `telefono`,`codice`) VALUES
('Languorino', 'pizzeria', 'lan.guo@gmail.com', '4a18f011d6df0cc0ac063203935a5fbf0333a339cd348d42de943ec3475811528a944600a07a7a39a820749358af8e388eacd011a804b3eabaed3e7aceb0543c', 'Cesena', 'via Brombeis 5', 'Il languorino e` una fantastica pizzeria stile rock dove si possono gustare delle
  raffinate pizze con 12 ore di lievitazione e cotte in un forno a legna coibentato con terracotta del Nilo.', 'Pizzerie situata nel centro di Cesena ha ubicazione in via Brombeis 22', 'languorino1.jpg', 'languorino2.jpg', 'languorino3.jpg', 0547665422 ,'6e7a2f44536bd4580346f73627c2f7a2385cd1e90b7045d9498258d5ff055107c0e6a5b3a48a00f8ed218d52f358b801d85e2c60d920b799a3ebf43da141f59b'), /*languorino*/
('Bio`s Kitchen', 'ristorante', 'bio.kitchen@yahoo.com', 'fa344fc4efd1f85b323effbc4d745f9e0e0c9659042b36a853b505cae011f8e39029a96a329abd230844f94b62c3b306488448daa66c4758996b31e23b6b1abe', 'Cesena', 'via Della Fiera 69', 'Genuino e prelibato e` il nostro principio per la preparazione e la cottura nei
  nostri piatti tipici.', 'Ristorante situato vicino al centro storico di Cesena in Via Della Fiera 69.', 'bio1.png', 'bio2.jpg', 'bio3.jpg', 0541789254 ,'43d24d2223ef0cb6af4215375e8d3c0578fdf29a7ee51b575f37a0ccaebe09342abdfcfc736f9bab0873c1e896263c7ef0aa212f737661b5608942f8b578dab0'), /* biokitchen*/
('McDonald`s', 'fast food', 'mc.donalds@gmail.com', '578c77bf16996fee6bbea8d11957ac9b440ee4694593760095a796fcbf4ed191dcbfc5a88b8141027d8173451812d95bbd220db030457cc6dda3d9370937e761', 'Cesena', 'via Banane 454', 'I McBurger sono la nostra specialita`, vieni a trovarci in negozio e verrai assistito dai migliori
  laureati di tutto il mondo a cui potrai fare tra le piu` svariate richieste, anche di raccontarti la storia di come venne inventato il McDonald`s.', 'Tutti i McMenu che desideri possono essere tuoi in via Banane 454.', 'Mc1.jpg', 'Mc2.jpg', 'Mc3.jpg', 0547551442 ,'74354e34388550397bd30a57c4fb53070645a3b5e256a8b7a6c013472fc84519e81912e6e8b47305f95eac1503fc34e4163b1eb8983e3374b58bf3bec5806c66');/*mcdonald*/

-- --------------------------------------------------------

--
-- Table structure for table `prodotto`
--

CREATE TABLE `prodotto` (
  `e_mail_fornitore` varchar(40) NOT NULL,
  `nomeProdotto` varchar(30) NOT NULL,
  `prezzo` Float NOT NULL,
  `descrizione` varchar(100) NOT NULL,
  `img` varchar(50) DEFAULT NULL COMMENT 'percorso immagine'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`e_mail_fornitore`, `nomeProdotto`, `prezzo`, `descrizione`, `img`) VALUES
('lan.guo@gmail.com', 'Pizza margherita', 4.50, 'pizza con pomodoro, mozzarella e origano fresco', 'Pizza.jpg'),
('lan.guo@gmail.com', 'Pizza funghi freschi', 6.50, 'pizza base margherita con ottimi funghi freschi', 'pizza-bianca-ai-funghi.jpg'),
('lan.guo@gmail.com', 'Pizza wurstel e patatine', 5.50, 'pizza pomodoro e mozzarella con wurstel tedeschi e patatine fritte', 'pizza-wurstel-patatine-pomodoro.jpg'),
('bio.kitchen@yahoo.com', 'Strozzapreti', 10.00, 'fantastici strozzapreti integrali bio ai funghi porcini delle nostre campagne', 'strozzapreti.jpg'),
('mc.donalds@gmail.com', 'McBurger classico', 4.00, 'Un classico hamburger ripieno con cheddar, pomodoro e cipolla adatto a tutti i gusti', 'burger.jpg'),
('mc.donalds@gmail.com', 'McBurger double', 6.50, 'Un hamburger dobbio composto da 300gr di pura carne bovina, roasty di patate e bacon', 'double_hamburger.jpg');


-- --------------------------------------------------------

--
-- Table structure for table `cartacredito`
--

CREATE TABLE `cartacredito` (
  `numero` numeric(16) NOT NULL,
  `proprietario` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `cartacredito`
--

INSERT INTO `cartacredito` (`numero`, `proprietario`) VALUES
(1234, 'gigi.ino@gmail.com'),
(1235, 'lan.guo@gmail.com'),
(1236, 'bio.kitchen@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `puntoconsegna`
--

CREATE TABLE `puntoconsegna` (
  `luogo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `puntoconsegna`
--

INSERT INTO `puntoconsegna` (`luogo`) VALUES
('aula a14'),
('ingresso est'),
('ingresso nord');

-- --------------------------------------------------------

--
-- Table structure for table `ordine`
--

CREATE TABLE `ordine` (
  `e_mail_cliente` varchar(40) NOT NULL,
  `e_mail_fornitore` varchar(40) NOT NULL,
  `quantita` int(20) NOT NULL,
  `nomeProdotto` varchar(50) NOT NULL,
  `stato` int(5) DEFAULT 0,
  `data` date DEFAULT NULL,
  `ora` time(0) DEFAULT NULL,
  `luogo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `ordine` (`e_mail_cliente`, `e_mail_fornitore`, `quantita`, `nomeProdotto`, `stato`, `data`, `ora`, `luogo`) VALUES
('gigi.ino@gmail.com', 'lan.guo@gmail.com', 2, 'Pizza funghi freschi', 0, NULL, NULL, NULL),
('gigi.ino@gmail.com', 'mc.donalds@gmail.com', 2, 'McBurger double', 1, '2019-10-20', '14:54', 'ingresso est'),
('tom.jerry@gmail.com', 'lan.guo@gmail.com', 1, 'Pizza wurstel e patatine', 0, NULL, NULL, NULL),
('tom.jerry@gmail.com', 'lan.guo@gmail.com', 3, 'Pizza wurstel e patatine', 1, '2019-10-20', '14:54', 'ingresso est');

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`nome`) VALUES
('Ristorante'),
('Pizzeria'),
('Piada e cassoni'),
('Altro');

-- --------------------------------------------------------

CREATE TABLE `tentativologin` (
  `e_mail_admin` varchar(50) DEFAULT NULL,
  `e_mail_cliente` varchar(50) DEFAULT NULL,
  `e_mail_fornitore` varchar(50) DEFAULT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------


CREATE TABLE `notifica` (
  `id` int(11) NOT NULL,
  `destinatario` varchar(128) NOT NULL,    -- e_mail fornitore/ cliente/ admin
  `messaggio` varchar(255) NOT NULL,
  `visto` tinyint(1) NOT NULL,
  `mittente` varchar(128) NOT NULL        -- e_mail fornitore/ cliente/ admin
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




INSERT INTO `notifica` (`id`,`destinatario`,`messaggio`,`visto`,`mittente`) VALUES
(0,'lan.guo@gmail.com', 'Prodotto ordinato', 0, 'gigi.ino@gmail.com'),
(1,'gigi.ino@gmail.com', 'Ordine preso in consegna', 0, 'lan.guo@gmail.com');


--
-- Indexes for table `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `notifica`
--
ALTER TABLE `notifica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


-- --------------------------------------------------------

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admin`
--

ALTER TABLE `admin`
  ADD PRIMARY KEY (`e_mail_admin`);

ALTER TABLE `cliente`
  ADD PRIMARY KEY (`e_mail_cliente`);

ALTER TABLE `fornitore`
  ADD PRIMARY KEY (`e_mail_fornitore`);

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
