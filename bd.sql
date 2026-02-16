-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2025 at 08:33 PM
-- Server version: 8.0.42-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clear`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_user`
--

CREATE TABLE `api_user` (
  `id_user` int NOT NULL,
  `user` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `NomeCompleto` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `filialCC` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `tipo` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `userOBS` varchar(500) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `api_user`
--

INSERT INTO `api_user` (`id_user`, `user`, `password`, `NomeCompleto`, `filialCC`, `tipo`, `userOBS`) VALUES
(1, 'Eduardo', '1b62e082y987987979797987', 'Edu webedu', 'SP', 'admin', 'Devops');

-- --------------------------------------------------------

--
-- Table structure for table `entra_sai`
--

CREATE TABLE `entra_sai` (
  `id_ea` int NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `filial` varchar(10) NOT NULL,
  `produto` varchar(200) NOT NULL,
  `tipo_operacao` varchar(20) NOT NULL,
  `quantidade` int NOT NULL,
  `obs` varchar(200) NOT NULL,
  `data_movimentacao` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `entra_sai`
--

INSERT INTO `entra_sai` (`id_ea`, `usuario`, `filial`, `produto`, `tipo_operacao`, `quantidade`, `obs`, `data_movimentacao`) VALUES
(35, 'fabricio', 'CCBRSP', 'PEN DRIVE', 'Entrada', -1, '', '2024-09-24 00:00:00'),
(27, 'webedu', 'CCBRSP', 'Mouse optico', 'Entrada', 5, '', '2024-09-07 00:00:00'),
(19, 'webedu', 'CCBRSP', 'Mouse optico', 'Entrada', 4, '', '2024-09-07 00:00:00'),
(17, 'webedu', 'CCBRSP', 'Mouse optico', 'Entrada', 8, '', '2024-09-07 00:00:00');
-- --------------------------------------------------------

--
-- Table structure for table `estoque`
--

CREATE TABLE `estoque` (
  `id_estoque` int NOT NULL,
  `filial` varchar(255) DEFAULT NULL,
  `produto` varchar(255) DEFAULT NULL,
  `descricao` text,
  `quantidade` int NOT NULL DEFAULT '0',
  `operador` varchar(200) DEFAULT NULL,
  `ultima_atualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `estoque`
--

INSERT INTO `estoque` (`id_estoque`, `filial`, `produto`, `descricao`, `quantidade`, `operador`, `ultima_atualizacao`) VALUES
(26, 'CCBRSP', 'Celular S10', 'celular estoque SP', 2, NULL, '2024-12-02 17:57:09'),
;

-- --------------------------------------------------------

--
-- Table structure for table `filiais`
--

CREATE TABLE `filiais` (
  `id_filial` int NOT NULL,
  `filial` varchar(20) NOT NULL,
  `nome_filial` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `filiais`
--

INSERT INTO `filiais` (`id_filial`, `filial`, `nome_filial`) VALUES
(3, 'RJ', ' RJO'),
(4, 'CB', ' CWB'),
(10, 'BR', 'BSB'),
(11, 'VT', 'CVIT'),
(12, 'PA', 'CPOA'),
(13, 'CX', 'CXS'),
(14, 'TS', 'TST');

-- --------------------------------------------------------

--
-- Table structure for table `movimentacoes`
--

CREATE TABLE `movimentacoes` (
  `id` int NOT NULL,
  `id_produto` int NOT NULL,
  `tipo_movimentacao` enum('entrada','saida') NOT NULL,
  `quantidade` int NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `data_movimentacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_user`
--
ALTER TABLE `api_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `entra_sai`
--
ALTER TABLE `entra_sai`
  ADD PRIMARY KEY (`id_ea`);

--
-- Indexes for table `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_estoque`);

--
-- Indexes for table `filiais`
--
ALTER TABLE `filiais`
  ADD PRIMARY KEY (`id_filial`);

--
-- Indexes for table `movimentacoes`
--
ALTER TABLE `movimentacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produto` (`id_produto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_user`
--
ALTER TABLE `api_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `entra_sai`
--
ALTER TABLE `entra_sai`
  MODIFY `id_ea` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_estoque` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `filiais`
--
ALTER TABLE `filiais`
  MODIFY `id_filial` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `movimentacoes`
--
ALTER TABLE `movimentacoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
