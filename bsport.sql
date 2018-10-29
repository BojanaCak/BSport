-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2017 at 11:13 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsport`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikli`
--

CREATE TABLE `artikli` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `kratakopis` varchar(255) NOT NULL,
  `opis` text NOT NULL,
  `stanje` int(11) NOT NULL,
  `kategorijaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artikli`
--

INSERT INTO `artikli` (`id`, `naziv`, `cena`, `kratakopis`, `opis`, `stanje`, `kategorijaid`) VALUES
(1, 'Coverse patike', '7900.00', 'Zenske patike,Converse All star ', 'Donec hendrerit massa metus, a ultrices elit iaculis eu. Pellentesque ullamcorper augue lacus. Phasellus et est quis diam iaculis fringilla id nec sapien. \r\n', 30, 1),
(2, 'Converse bela majica', '1200.00', 'Converse All Star majica bele boje', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse mattis, nulla id pretium malesuada, dui est laoreet risus.', 26, 2),
(3, 'Coverse plava majica', '1200.00', 'Converse All Star majica tamno plave boje', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse mattis, nulla id pretium malesuada, dui est laoreet risus.', 64, 2),
(4, 'Adidas crna majica', '1500.00', 'Addidas zenska majica crne boje', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse mattis, nulla id pretium malesuada, dui est laoreet risus, ac rhoncus eros diam id odio.', 58, 2),
(5, 'Adidas ranac', '6700.00', 'Addidas ranac crne boje', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse mattis, nulla id pretium malesuada, dui est laoreet risus, ac rhoncus eros diam id odio.', 28, 3),
(6, 'Nike ranac', '6000.00', 'Plavi Nike ranac', 'Vivamus eget purus at quam fermentum eleifend. Praesent id vehicula risus. Nulla facilisi. Nunc elit est, tincidunt id augue at, vehicula interdum ipsum. Sed eget scelerisque nibh, at aliquet diam.', 12, 3),
(8, 'Patike', '8000.00', 'Crne Nike patike', 'Donec placerat cursus rhoncus. Nam feugiat nec metus sit amet scelerisque. Nullam quis tempor ligula, sit amet cursus risus. Suspendisse id tellus purus.', 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE `kategorija` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`id`, `naziv`) VALUES
(1, 'Obuca'),
(2, 'Odeca'),
(3, 'Ostalo');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `imeprezime` varchar(255) NOT NULL,
  `adresa` varchar(255) NOT NULL,
  `brojtelefona` varchar(50) NOT NULL,
  `ulogaid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `email`, `password`, `imeprezime`, `adresa`, `brojtelefona`, `ulogaid`) VALUES
(7, 'boki@gmail.com', '$2y$10$zEO/aFb9wvrFj8ANz2zL9uY9YF4wuazjd.b20HWVeo3xx1lOKAwca', 'Boki Kibo', 'Mitropolita Pavla 3', '065555444', 1),
(8, 'admin@shop.rs', '$2y$10$QhXPA.6GQvih/nMn/mfYKufIrka7FWw.CfRKX2.dCj.851CsjV3yC', 'admin a', 'Mitropolita Pavla 1', '555 333', 2),
(9, 'boja@gmail.com', '$2y$10$ZWKMSU9DN2IXRyCDkCPuQuhxRchLQSvUo78tFYUc2GtsDwdSN9Gt2', 'Boja Cakmak', 'Dimitrija Marinkovica 19', '0601122233', 1);

-- --------------------------------------------------------

--
-- Table structure for table `porudzbina`
--

CREATE TABLE `porudzbina` (
  `id` int(11) NOT NULL,
  `korisnikid` int(11) NOT NULL,
  `vreme` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `porudzbina`
--

INSERT INTO `porudzbina` (`id`, `korisnikid`, `vreme`) VALUES
(5, 7, '2017-09-29 00:30:14'),
(6, 7, '2017-09-29 00:32:44'),
(7, 8, '2017-09-29 10:59:29'),
(8, 8, '2017-09-29 11:02:46');

-- --------------------------------------------------------

--
-- Table structure for table `stavka`
--

CREATE TABLE `stavka` (
  `id` int(11) NOT NULL,
  `porudzbinaid` int(11) NOT NULL,
  `artikalid` int(11) NOT NULL,
  `kolicina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stavka`
--

INSERT INTO `stavka` (`id`, `porudzbinaid`, `artikalid`, `kolicina`) VALUES
(6, 5, 3, 1),
(7, 5, 1, 1),
(8, 6, 8, 1),
(9, 7, 2, 1),
(10, 8, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `uloge`
--

CREATE TABLE `uloge` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uloge`
--

INSERT INTO `uloge` (`id`, `naziv`) VALUES
(1, 'admin'),
(2, 'kupac');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikli`
--
ALTER TABLE `artikli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategorijaid` (`kategorijaid`);

--
-- Indexes for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ulogaid` (`ulogaid`);

--
-- Indexes for table `porudzbina`
--
ALTER TABLE `porudzbina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `korisnikid` (`korisnikid`);

--
-- Indexes for table `stavka`
--
ALTER TABLE `stavka`
  ADD PRIMARY KEY (`id`,`porudzbinaid`),
  ADD KEY `artikalid` (`artikalid`),
  ADD KEY `stavka_ibfk_1` (`porudzbinaid`);

--
-- Indexes for table `uloge`
--
ALTER TABLE `uloge`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikli`
--
ALTER TABLE `artikli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `kategorija`
--
ALTER TABLE `kategorija`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `porudzbina`
--
ALTER TABLE `porudzbina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `stavka`
--
ALTER TABLE `stavka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `uloge`
--
ALTER TABLE `uloge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikli`
--
ALTER TABLE `artikli`
  ADD CONSTRAINT `artikli_ibfk_1` FOREIGN KEY (`kategorijaid`) REFERENCES `kategorija` (`id`);

--
-- Constraints for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD CONSTRAINT `korisnici_ibfk_1` FOREIGN KEY (`ulogaid`) REFERENCES `uloge` (`id`);

--
-- Constraints for table `porudzbina`
--
ALTER TABLE `porudzbina`
  ADD CONSTRAINT `porudzbina_ibfk_1` FOREIGN KEY (`korisnikid`) REFERENCES `korisnici` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stavka`
--
ALTER TABLE `stavka`
  ADD CONSTRAINT `stavka_ibfk_1` FOREIGN KEY (`porudzbinaid`) REFERENCES `porudzbina` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stavka_ibfk_2` FOREIGN KEY (`artikalid`) REFERENCES `artikli` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
