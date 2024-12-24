-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2024 às 03:33
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `id` int(11) NOT NULL,
  `cep` varchar(40) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `cidade` varchar(40) NOT NULL,
  `bairro` varchar(40) NOT NULL,
  `rua` varchar(40) NOT NULL,
  `pais` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `endereco`
--

INSERT INTO `endereco` (`id`, `cep`, `estado`, `cidade`, `bairro`, `rua`, `pais`) VALUES
(1, '88806-000', 'Santa Catarina', 'Criciúma', 'Jardim Angélica', 'Rua Rosita Danovith Finster', 'Brasil'),
(2, '88806-000', 'Santa Catarina', 'Criciúma', 'Jardim Angélica', 'Rua Rosita Danovith Finster', 'Brasil'),
(3, '88830-000', 'Santa Catarina', 'Içara', 'Marco Antonio', 'Marco Antonio', 'Brasil'),
(4, '88830-000', 'Santa Catarina', 'Morro da Fumaça', 'Barracão', 'Rua Madre Maria Tereza de Jesus', 'Brasil'),
(5, '88830-000', 'Paraná', 'Apucarana', 'Araucária', 'Aço', 'Brasil'),
(6, '88545-556', 'Santa Catarina', 'Joinvile', 'moraes', 'limões', 'Brasil'),
(7, '64222-235', 'Minas Gerais', 'Ipatinga', 'parros', 'pizos', 'Brasil'),
(8, '34557-689', 'Paraná', 'Curitiba', 'Curitiba', 'Marinheiros', 'Brasil'),
(9, '00096-575', 'São Paulo', 'Montes', 'milão', 'Meroi', 'Brasil'),
(10, '88830-000', 'Santa Catarina', 'Morro da Fumaça', 'Barracão', 'Madre Maria ', 'Brasil'),
(11, '12312-312', 'Ceará', 'Fortaleza', 'Fortaleza', 'campos', 'Brasil'),
(12, '35345-332', 'Goiáis', 'Goiânia', 'Marrom', 'Marcados', 'Brasil');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) NOT NULL,
  `data_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `visualizada` enum('N','S') DEFAULT 'N',
  `id_perfil_recebedor` int(11) NOT NULL,
  `id_perfil_solicitante` int(11) NOT NULL,
  `id_oferta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `categoria` varchar(25) NOT NULL,
  `contato` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `estado` varchar(40) NOT NULL,
  `cidade` varchar(40) NOT NULL,
  `status` enum('A','I') DEFAULT NULL,
  `nome_foto` varchar(40) NOT NULL,
  `id_perfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ofertas`
--

INSERT INTO `ofertas` (`id`, `nome`, `descricao`, `categoria`, `contato`, `email`, `estado`, `cidade`, `status`, `nome_foto`, `id_perfil`) VALUES
(2, 'Compra de Sementes de Milho', 'Necessitamos de fornecedores de sementes de milho de alta qualidade para plantio . Preferência por volumes acima de 500kg. Entrega em até 30 dias no estado de Goiás.', 'Serviços', '(61) 99888-1234', 'contato@agrocompra.com.br', 'Santa Catarina', 'Içara', 'A', 'milho.jfif', 3),
(3, 'Solicitação de Monitores para Escritório', 'Buscamos empresas que forneçam monitores Full HD de 24 a 27 polegadas para atualização do nosso escritório. Necessitamos de 50 unidades, com possibilidade de parcerias futuras.', '', '(11) 97444-9822', 'suporte@gigatech.com', 'Santa Catarina', 'Morro da Fumaça', 'A', '674681c4788f2.jpg', 4),
(5, 'Pedido de Tecidos para Coleção Inverno', 'Estamos buscando fornecedores de tecidos de lã, algodão e viscose em alta qualidade para a nossa próxima coleção de inverno. Preferência por entrega em 15 dias.', 'Moda e Vestuário', '(21) 99888-5678', 'compras@fashionnow.com', 'Paraná', 'Apucarana', 'A', '674683c14ddf6.jpg', 5),
(6, 'Necessidade de Ração Canina Premium', 'Buscamos parceiros que forneçam ração premium para cães em embalagens de 15kg . Exige mensalmente 500 unidades.', 'Animais e Acessórios', '(47) 98888-7644', 'contato@gopet.com.br', 'Santa Catarina', 'Joinvile', 'A', 'racao.png', 6),
(7, 'Compra de Suplementos Alimentares', ' Necessitamos de suplementos alimentares como whey protein e creatina para venda em academias. Quantidades entre 100 e 500 unidades por produto.', 'Saúde e Bem-estar', '(31) 99555-1122', 'pedidos@healthylife.com', 'Minas Gerais', 'Ipatinga', 'A', 'suplementos.jpg', 7),
(8, 'Venda de Soja em Grãos', 'Soja de alta qualidade para exportação ou mercado interno. Quantidades a partir de 10 toneladas. Envio em até 15 dias após a confirmação do pedido.', 'Alimentos e Bebidas', '(41) 99777-1234', 'vendas@agrosul.com.br', 'Paraná', 'Curitiba', 'A', 'soja.jpg', 8),
(9, 'Computadores Recondicionados para Escritório', 'Computadores de alta performance recondicionados, ideais para uso corporativo. Garantia de 1 ano. Modelos disponíveis com Intel i5 e i7.', 'Tecnologia', '(19) 99988-555', 'contato@techpoint.com', 'São Paulo', 'Montes', 'A', '6741d25be7560.jpg', 9),
(10, 'Venda de Móveis Sustentáveis', 'Ofertas móveis de madeira sustentável para decoração de interiores. Inclui mesas, cadeiras e prateleiras. Produtos artesanais com design moderno.', 'Casa e Decoração', '(48) 98888-9988', 'vendas@greendecor.com', 'Santa Catarina', 'Morro da Fumaça', 'A', 'madeiraDecoracao.jpeg', 10),
(11, 'Brinquedos Educativos Importados', 'Brinquedos educativos de alta qualidade para crianças de 3 a 10 anos. Modelos importados com certificação de segurança internacional.', 'Brinquedos e Jogos', '(85) 99999-2244', 'comercial@brinquemais.com.br', 'Ceará', 'Fortaleza', 'A', 'brinquedo.jfif', 11),
(12, 'Esteiras e Bicicletas Ergométricas', 'Equipamentos de academia com entrega em todo o Brasil. Modelos compactos e ideais para uso residencial ou profissional.', 'Esportes e Lazer', '(62) 97777-332', 'vendas@fitmove.com', 'Goiáis', 'Goiânia', 'A', 'esporteLazer.jpg', 12);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `hora_data` datetime NOT NULL,
  `id_ofertas` int(11) NOT NULL,
  `id_perfil_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE `perfil` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contato` varchar(50) NOT NULL,
  `cpf_cnpj` varchar(50) NOT NULL,
  `data_nasc` varchar(10) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `id_endereco` int(11) DEFAULT NULL,
  `id_usuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perfil`
--

INSERT INTO `perfil` (`id`, `nome`, `sobrenome`, `email`, `contato`, `cpf_cnpj`, `data_nasc`, `avatar`, `id_endereco`, `id_usuarios`) VALUES
(1, 'Eduardo', '0', 'edu@gmail.com', '(48) 98853-0659', '115.539.059-83', '2206-12-16', 'robux.jfif', 1, 1),
(2, 'Joao', '0', 'joao@gmail.com', '(48) 98853-1690', '115.897.456-48', '2006-12-16', 'robux.jfif', 2, 2),
(3, 'AgroCompra Coletiva', '', 'contato@agrocompra.com.br', '(61) 99888-1234', '323.423.423-42', '1999-02-04', 'user.png', 3, 3),
(4, 'GigaTech Supplies', '', 'suporte@gigatech.com', '(11) 97444-9822', '234.267.678-97', '2013-03-04', 'user.png', 4, 4),
(5, 'FashionNow ', 'Distribuidora', 'compras@fashionnow.com', '(21) 99888-5678', '245.467.897-89', '2003-04-09', 'user.png', 5, 5),
(6, 'GoPet ', 'Serviços', 'contato@gopet.com.br', '(47) 98888-7644', '65.437.687-56', '2017-05-07', 'user.png', 6, 6),
(7, 'HealthyLife ', 'Distribuidora', 'pedidos@healthylife.com', '(31) 99555-1122', '657.866.645-77', '1979-04-14', 'user.png', 7, 7),
(8, 'AgroSul ', 'Produções', 'vendas@agrosul.com.br', '(41) 99777-1234', '132.454.578-89', '1997-02-04', 'user.png', 8, 8),
(9, 'TechPoint ', 'Soluções', 'contato@techpoint.com', '(19) 99988-555', '756.854.456-46', '2013-04-25', 'user.png', 9, 9),
(10, 'GreenDecor Móveis', '', 'vendas@greendecor.com', '(48) 98888-9988', '234.658.765-67', '2020-03-06', 'user.png', 10, 10),
(11, 'BrinqueMais ', 'Importados', 'comercial@brinquemais.com.br', '(85) 99999-2244', '767.867.867-86', '1999-04-07', 'user.png', 11, 11),
(12, 'FitMove', ' Equipamentos', 'vendas@fitmove.com', '(62) 97777-332', '421.231.231-23', '2011-06-09', 'user.png', 12, 12);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tokens_recuperacao`
--

CREATE TABLE `tokens_recuperacao` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expira_em` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `avatar` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `nome`, `sobrenome`, `email`, `senha`, `avatar`) VALUES
(1, 'edu', 'Eduardo', '', 'eduardogoulart935@gmail.com', '$2y$10$bzqvhYXnxeo4g0rZ1w14W.j9vPcu4pJjAwSkv.F6.1cV6ITwSr07K', 'https://lh3.googleusercontent.com/a/ACg8ocJudN2-gEOksRacJgfROEsavTD3ZDGvnBRgL4x43N_9oiSlJQ=s96-c'),
(2, 'joao', 'Joao', '', 'marketplacetcc2024@gmail.com', '$2y$10$A0GPjGqFGtt0kZt6ENQZbOXGzvmgsH926D92ZHsZ2iFjDTUYK8ar6', 'user.png'),
(3, 'AgroCompra', 'AgroCompra Coletiva', '', 'contato@agrocompra.com.br', '$2y$10$FkGPnH0byMcoy4F0hBY1VOSEg4SDxgAae.eJPwigB6P6wJOFb.f9G', ''),
(4, 'Giga', 'GigaTech Supplies', '', 'suporte@gigatech.com', '$2y$10$hVIkWqJumx.4Hnw2epcN1.I9XV4t9PpDVQ/cWNH0.gJsvXiVYwQuS', ''),
(5, 'Fashion', 'FashionNow ', 'Distribuidora', 'compras@fashionnow.com', '$2y$10$qSWYb/dj2YC.52mq8t76GeTPGs9Se75YUbAxCJJdmpc2k8MfNjuUG', ''),
(6, 'gopet', 'GoPet ', 'Serviços', 'contato@gopet.com.br', '$2y$10$zzwenzV.Nqi845paveYj5O48qiNemCaqtu9WfH.UXugbkY0TFQwRm', ''),
(7, 'heal', 'HealthyLife ', 'Distribuidora', 'pedidos@healthylife.com', '$2y$10$EGmpmOkHC9qeKnyNSzXi7O0Uu1ZtMBWRpcOBlMGx3t24deV7A0CEO', ''),
(8, 'agrosul', 'AgroSul ', 'Produções', 'vendas@agrosul.com.br', '$2y$10$02WwQJewszyGq1q1Txl.Y.9gUgyd1xAkNBTzonHK5J.RJ8sD0MOXC', ''),
(9, 'tech', 'TechPoint ', 'Soluções', 'contato@techpoint.com', '$2y$10$Vy662tysMETDgLy4n51wyutjchCefg.kLhaBukL3poPz3M0AxktSm', ''),
(10, 'green', 'GreenDecor Móveis', '', 'vendas@greendecor.com', '$2y$10$XXhCX6d.v0CX5PQh/q81KOuqrODgdJqEcjKRRQqDpJ2RAatxnsmm.', ''),
(11, 'brinque', 'BrinqueMais ', 'Importados', 'comercial@brinquemais.com.br', '$2y$10$ZCCvHM1hIJeaMirIuDwlD.UvcvRC.MWtcl.zMQVAmDMs7wTG17qsC', ''),
(12, 'fitmove', 'FitMove', ' Equipamentos', 'vendas@fitmove.com', '$2y$10$bnmcTpQyLKL/huO3b7cV1Oui3RhnNH04Qb3lP/pTdSOKz43ZB8h8a', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perfil_recebedor` (`id_perfil_recebedor`),
  ADD KEY `id_perfil_solicitante` (`id_perfil_solicitante`),
  ADD KEY `id_oferta` (`id_oferta`);

--
-- Índices de tabela `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ofertas` (`id_ofertas`),
  ADD KEY `id_perfil_pedido` (`id_perfil_pedido`);

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_endereco` (`id_endereco`),
  ADD KEY `id_usuarios` (`id_usuarios`);

--
-- Índices de tabela `tokens_recuperacao`
--
ALTER TABLE `tokens_recuperacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tokens_recuperacao`
--
ALTER TABLE `tokens_recuperacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`id_perfil_recebedor`) REFERENCES `perfil` (`id`),
  ADD CONSTRAINT `notificacoes_ibfk_2` FOREIGN KEY (`id_perfil_solicitante`) REFERENCES `perfil` (`id`),
  ADD CONSTRAINT `notificacoes_ibfk_3` FOREIGN KEY (`id_oferta`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `ofertas_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id`);

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_ofertas`) REFERENCES `ofertas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `perfil_pedido_ibfk_1` FOREIGN KEY (`id_perfil_pedido`) REFERENCES `perfil` (`id`);

--
-- Restrições para tabelas `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `id_usuarios` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `perfil_ibfk_1` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
