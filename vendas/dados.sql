-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27-Out-2017 às 22:57
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dados`
--
CREATE DATABASE IF NOT EXISTS `dados` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dados`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avisos`
--

CREATE TABLE `avisos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `mensagem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `avisos`
--

INSERT INTO `avisos` (`id`, `titulo`, `mensagem`) VALUES
(1, '0', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cache`
--

CREATE TABLE `cache` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `NVA_VENDAS` int(11) NOT NULL,
  `MCZ_VENDAS` int(11) NOT NULL,
  `NVA_FAT` int(11) NOT NULL,
  `MCZ_FAT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cache`
--

INSERT INTO `cache` (`ID`, `NVA_VENDAS`, `MCZ_VENDAS`,`NVA_FAT`,`MCZ_FAT`) VALUES
(1, 108, 88,0,0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `hora`
--

CREATE TABLE `hora` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `LAST_HOUR` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `hora`
--

INSERT INTO `hora` (`ID`, `LAST_HOUR`) VALUES
(1, '2017-10-27 20:56:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(50) NOT NULL,
  `hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `logs`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `supervisores`
--

CREATE TABLE `supervisores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(20) NOT NULL,
  `vendas` int(11) NOT NULL,
  `site` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `supervisores`
--

INSERT INTO `supervisores` (`id`, `nome`, `vendas`, `site`) VALUES
(1, 'KELLY', 1, 'MCZ'),
(2, 'TAMIRIS', 2, 'MCZ'),
(3, 'KATILA', 3, 'MCZ'),
(4, 'RAFAEL', 4, 'MCZ'),
(5, 'ALOISIO', 5, 'NVA'),
(6, 'OSMAR', 6, 'NVA'),
(7, 'ALEX', 7, 'NVA'),
(8, 'NATASHA', 8, 'NVA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avisos`
--
ALTER TABLE `avisos`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `hora`
--
ALTER TABLE `hora`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `supervisores`
--
ALTER TABLE `supervisores`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cache`
--
ALTER TABLE `cache`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hora`
--
ALTER TABLE `hora`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `supervisores`
--
ALTER TABLE `supervisores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
