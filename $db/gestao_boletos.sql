-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05-Maio-2018 às 01:48
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestao_boletos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bancos`
--

CREATE TABLE `bancos` (
  `id_banco` int(30) NOT NULL,
  `nome_banco` varchar(200) NOT NULL,
  `carteira` varchar(4) NOT NULL,
  `agencia` int(30) NOT NULL,
  `digito_ag` int(5) NOT NULL,
  `conta` varchar(10) NOT NULL,
  `digito_co` varchar(5) NOT NULL,
  `especie` varchar(2) DEFAULT NULL,
  `nosso_numero` int(20) NOT NULL,
  `tipo_cobranca` varchar(20) NOT NULL,
  `convenio` varchar(30) NOT NULL,
  `contrato` varchar(30) NOT NULL,
  `tipo_carteira` varchar(5) NOT NULL,
  `situacao` int(1) NOT NULL,
  `img` varchar(50) NOT NULL,
  `img2` varchar(200) NOT NULL,
  `link` varchar(60) NOT NULL,
  `increment` int(50) NOT NULL,
  `tokem` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `bancos`
--

INSERT INTO `bancos` (`id_banco`, `nome_banco`, `carteira`, `agencia`, `digito_ag`, `conta`, `digito_co`, `especie`, `nosso_numero`, `tipo_cobranca`, `convenio`, `contrato`, `tipo_carteira`, `situacao`, `img`, `img2`, `link`, `increment`, `tokem`) VALUES
(1, 'BANCO DO BRASIL', '10', 3307, 3, '231', '', '26', 0, '2', '1234567', '', '', 0, 'bb.png', 'bb2.png', 'boleto_bb.php', 100, ''),
(2, 'BRADESCO', '01', 1111, 2, '1111111', '2', '', 0, '', '1111-2', '', 'SR', 1, 'bradesco.png', 'bradesco2.png', 'boleto_bradesco.php', 100, ''),
(3, 'CAIXA ECONOMICA', '02', 3139, 0, '037950', '2', '', 0, '', '379502', '100500', 'SR', 0, 'caixa.png', 'caixa2.png', 'boleto_cef_sigcb.php', 100, ''),
(4, 'ITAU', '200', 256, 0, '77777', '3', '99', 0, '', '', '', '', 0, 'itau.png', 'itau2.png', 'boleto_itau.php', 100, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(30) NOT NULL,
  `id_usuario` int(30) NOT NULL,
  `id_grupo` int(10) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `nascimento` date NOT NULL,
  `cpfcnpj` varchar(18) NOT NULL,
  `rg` varchar(15) NOT NULL,
  `inscricao` varchar(20) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `numero` int(10) NOT NULL,
  `complemento` varchar(200) NOT NULL,
  `bairro` varchar(200) NOT NULL,
  `cidade` varchar(200) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL,
  `bloqueado` varchar(1) NOT NULL,
  `enviado` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `id_usuario`, `id_grupo`, `nome`, `nascimento`, `cpfcnpj`, `rg`, `inscricao`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `pais`, `telefone`, `cep`, `email`, `bloqueado`, `enviado`) VALUES
(9, 0, 4, 'ROBERTO SANTOS', '1992-07-12', '79.787.878/7897-89', 'MG-12413567', '', 'RUA A', 1, 'CASA', 'CENTRO', 'VICOSA', 'MG', '', '(21) 9898-9898', '36570-000', 'roberto@santos.com', 'N', 0),
(14, 0, 5, 'MARIA TERESESA', '2001-01-01', '22.222.222/2222-22', '9999999999', '', 'ZZZZZZZZZZ', 11, '', '', 'ZZZZZZZZZ', 'ZZ', '', '(21) 99999-9999', '99999-999', 'maria@terezaaaaa.com', 'N', 0),
(15, 0, 1, 'MURILO', '1111-11-11', '99.999.999/9999-99', '11111111', '', 'AAAAAAAAAAAA', 11111111, '', '', 'AAAAAAAAAA', 'AA', 'aaaaaaaa', '', '11111-111', 'aaa@aaa.com', 'N', 0),
(18, 0, 1, 'BRUNA', '1111-11-11', '99.999.999/9999-99', '9999999999999', '111111111111', 'AAAAAAAAAAAAAA', 1111, '', '', 'AAAAAAAAA', 'AA', 'aaaaaaaa', '', '11111-111', 'aaa@aaa.com', 'N', 0),
(19, 0, 1, 'ALINE', '1111-11-11', '99.999.999/9999-99', '111111111111111', '', 'AAAAAAAAAAAAAA', 1111111111, '', '', 'AAAAAAAAAAAAA', 'UU', 'aaaaaaa', '', '99999-999', 'aaa@aaaa.com', 'N', 0),
(22, 0, 1, 'JULIETA', '1111-11-11', '99.999.999/9999-99', '111111111111', '', 'AAAAAAAAAAA', 111111111, '', '', 'AAAAAAAAAAAA', 'AA', 'aaaaaaaaaaaa', '', '99999-999', 'julieta@xxxx.com', 'N', 0),
(24, 0, 1, 'BARBARA', '1111-11-11', '99.999.999/9999-99', '111111111', '', 'AAAAAAAAAAAAA', 111, '', '', 'aaaaaaaaaa', 'Aa', 'aaaaa', '', '99999-999', 'barbara@aaa.com', 'N', 0),
(26, 0, 1, 'CAROLINA', '1111-11-11', '11.111.111/1111-11', '11111111', '', 'AAAAAAAAAAAA', 111, '', '', 'AAAAAAAAAA', 'AA', 'aaaaaaaaa', '', '11111-111', 'carolina@aaa.com', 'N', 0),
(27, 0, 1, 'FATIMA', '1111-11-11', '99.999.999/9999-99', '11111111111111', '', 'AAAAAAAAAAAA', 111111, '', '', 'AAAAAAAA', 'AA', 'aaaaaaaaaa', '', '11111-111', 'fatima@aaa.com', 'N', 0),
(29, 0, 1, 'PEDRITA', '1111-11-11', '99.999.999/9999-99', '1111111111111', '', 'AAAAAAAAAA', 11, '', '', 'AAAAAAAA', 'AA', 'aaaaaaaaaa', '', '11111-111', 'pedrita@aaa.com', 'N', 0),
(31, 0, 1, 'DARLENE', '1111-11-11', '99.999.999/9999-99', '11111111111', '', 'AAAAAAAAAA', 111111, '', '', 'AAAAAAAAAAAA', 'UU', 'aaaaaaaaaaaaaa', '', '99999-999', 'darlene@aaaa.com', 'N', 0),
(33, 0, 1, 'JOSI', '1111-11-11', '99.999.999/9999-99', '111111111111111', '', 'AAAAAAAAAAAAAAAAAA', 111, '', '', 'AAAAAAAAAA', 'AA', 'aaaaaaaaaaaa', '', '11111-111', 'josi@aaaa.com', 'N', 0),
(34, 0, 1, 'BEATRIZ', '1111-11-11', '11.111.111/1111-11', '11111111111', '', 'AAAAAAAAAAAAA', 111111, '', '', 'AAAAAAAAAAAAA', 'AA', 'aaaaaaaaaaaa', '', '11111-111', 'beatriz@aaa.com', 'N', 0),
(35, 0, 1, 'ERICA', '1111-11-11', '11.111.111/1111-11', '11111111111111', '', 'AAAAAAAAAAAA', 11111, '', '', 'AAAAAAAAAA', 'AA', 'aaaaaaaaaa', '', '11111-111', 'erica@aa.com', 'N', 0),
(45, 0, 1, 'ANA', '1970-01-01', '99.999.999/9999-99', '111111111111111', '', 'XXXXXXXXXXXXXXXXXXX', 1111111111, '', '', 'SDASDASDASD', 'AA', 'asdsadasdasd', '', '11111-111', 'ana@aaa.com', 'N', 0),
(46, 0, 1, 'KEZIA', '1111-11-11', '99.999.999/9999-99', '12312323123213', '', 'ASDASDASDASD', 1111111, '', '', 'ASDASDSADASD', 'AA', 'asdsadadasd', '', '11111-111', 'kezia@aaa.com', 'N', 0),
(50, 0, 1, 'JOAQUINA', '1111-11-11', '99.999.999/3992-42', '234234234234234', '', 'AAAAAAAAAAAAAA', 11, '', '', 'ASDASD', 'RR', 'asdasdsd', '', '80989-809', 'dfdsfdsf@aaa.com', 'N', 0),
(51, 0, 17, 'TIAGO', '1970-01-01', '33.333.333/3333-33', '333333333333', '', 'ASDASDASDASD', 1, '', '', 'SDASDASDSADSD', 'RS', 'asdsadasd', '', '11111-111', 'tiago@aaa.com', 'N', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `id` int(10) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `fantasia` varchar(200) NOT NULL,
  `url` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `endereco` varchar(250) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `bairro` varchar(150) NOT NULL,
  `cidade` varchar(200) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cep` varchar(20) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `receber` varchar(3) NOT NULL,
  `dias` varchar(2) NOT NULL,
  `multa_atraso` varchar(10) NOT NULL,
  `juro` varchar(50) NOT NULL,
  `protesto` int(1) NOT NULL,
  `demo1` varchar(200) NOT NULL,
  `demo2` varchar(200) NOT NULL,
  `demo3` varchar(200) NOT NULL,
  `demo4` varchar(200) NOT NULL,
  `qnt` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id`, `nome`, `fantasia`, `url`, `email`, `cpf`, `endereco`, `numero`, `bairro`, `cidade`, `uf`, `cep`, `logo`, `receber`, `dias`, `multa_atraso`, `juro`, `protesto`, `demo1`, `demo2`, `demo3`, `demo4`, `qnt`) VALUES
(1, 'PL GOLFE CLUBE', 'PL GOLFE CLUBE', 'http://www.site.com.br/boletos', 'teste@teste.com.br', 'cnpj', 'endereço', 'nro', 'bairro', 'cidade', 'uf', 'cep', '63104a35bbb46f5.png', '3', '5', '0', '0,5', 2, 'Sr. Caixa, cobrar multa de 2% apos o vencimento', 'Receber ate 2 dias apos o vencimento', 'Em caso de dividas entre em contato conosco: ', 'Emitido pelo sistema boleto.ml', '30');

-- --------------------------------------------------------

--
-- Estrutura da tabela `faturas`
--

CREATE TABLE `faturas` (
  `id_venda` bigint(60) NOT NULL,
  `nosso_numero` bigint(60) NOT NULL DEFAULT '0',
  `modulo` varchar(50) DEFAULT NULL,
  `codbanco` varchar(10) DEFAULT NULL,
  `dbaixa` date DEFAULT NULL,
  `banco_receb` varchar(20) DEFAULT NULL,
  `dv_receb` int(2) DEFAULT NULL,
  `banco` varchar(30) DEFAULT NULL,
  `id_cliente` int(30) NOT NULL,
  `grupoCliente` int(30) DEFAULT NULL,
  `nome` varchar(200) NOT NULL,
  `ref` varchar(250) NOT NULL,
  `data` date NOT NULL,
  `data_venci` date NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `valor_recebido` decimal(10,2) DEFAULT NULL,
  `situacao` varchar(1) NOT NULL,
  `condmail` int(1) NOT NULL DEFAULT '0',
  `emailcli` varchar(100) NOT NULL,
  `tipofatura` varchar(20) NOT NULL,
  `remessa` int(1) NOT NULL DEFAULT '0',
  `pedido` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `faturas`
--

INSERT INTO `faturas` (`id_venda`, `nosso_numero`, `modulo`, `codbanco`, `dbaixa`, `banco_receb`, `dv_receb`, `banco`, `id_cliente`, `grupoCliente`, `nome`, `ref`, `data`, `data_venci`, `valor`, `valor_recebido`, `situacao`, `condmail`, `emailcli`, `tipofatura`, `remessa`, `pedido`) VALUES
(1036, 0, NULL, NULL, '2018-02-27', NULL, NULL, NULL, 14, 5, 'MARIA TERESESA', 'aaaaaaaaaa', '2018-02-27', '2018-03-01', '100.00', '100.00', 'B', 1, 'maria@terezaaaaa.com', 'GRUPO', 0, 'b39d11fece9e6ad41d56d82ab57f289b'),
(1057, 0, NULL, NULL, '2018-03-03', NULL, NULL, 'bancoboleto2', 33, 1, 'JOSI', '', '2018-03-03', '2018-03-15', '10.00', '5.00', 'B', 0, 'josi@aaaa.com', 'AVULSO', 0, NULL),
(1058, 0, NULL, NULL, NULL, NULL, NULL, NULL, 9, 6, 'ROBERTO SANTOS', '', '2018-03-03', '2018-03-06', '100.00', NULL, 'V', 1, 'vendasml705@gmail.com', 'GRUPO', 0, '2e1c5073688362a44b9f04edaecb03a5'),
(1059, 0, NULL, NULL, NULL, NULL, NULL, 'gestao_boletos', 19, 1, 'ALINE', '', '2018-05-04', '2018-02-26', '50.00', NULL, 'V', 0, 'aaa@aaaa.com', 'AVULSO', 0, NULL),
(1060, 0, NULL, NULL, NULL, NULL, NULL, NULL, 51, 17, 'TIAGO', '', '2018-05-04', '2018-03-01', '150.00', NULL, 'V', 1, 'tiago@aaa.com', 'GRUPO', 0, 'dc80bec0e252bbbebebf9cfb6ce760bc'),
(1061, 0, NULL, NULL, NULL, NULL, NULL, 'gestao_boletos', 45, 1, 'ANA', '', '2018-05-04', '2019-05-31', '80.00', NULL, 'P', 0, 'ana@aaa.com', 'AVULSO', 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro`
--

CREATE TABLE `financeiro` (
  `id` int(10) NOT NULL,
  `banco` varchar(50) NOT NULL,
  `ag_receb` varchar(200) NOT NULL,
  `dv_receb` varchar(200) NOT NULL,
  `nosso_numero` bigint(30) NOT NULL,
  `vencimento` varchar(50) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `flux_entrada`
--

CREATE TABLE `flux_entrada` (
  `id_entrada` int(50) NOT NULL,
  `tipo` varchar(2) CHARACTER SET utf8 NOT NULL,
  `data` date NOT NULL,
  `id_plano` int(50) NOT NULL,
  `descricao` varchar(200) CHARACTER SET utf8 NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `flux_entrada`
--

INSERT INTO `flux_entrada` (`id_entrada`, `tipo`, `data`, `id_plano`, `descricao`, `valor`) VALUES
(1, 'R', '2017-07-15', 1, '1234123', '23423.42'),
(2, 'D', '2017-07-12', 0, '1234', '2.34'),
(3, '', '2018-03-02', 3, 'ok', '10.00'),
(4, 'R', '2018-03-02', 3, 'aaaaaaaaa', '10.00'),
(5, 'D', '2018-03-02', 3, 'bbbbb', '2.00'),
(6, 'D', '2018-05-01', 0, 'testeeee', '100.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `flux_fixas`
--

CREATE TABLE `flux_fixas` (
  `id_fixa` int(20) NOT NULL,
  `descricao_fixa` varchar(200) NOT NULL,
  `dia_vencimento` varchar(2) NOT NULL,
  `valor_fixa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `flux_fixas`
--

INSERT INTO `flux_fixas` (`id_fixa`, `descricao_fixa`, `dia_vencimento`, `valor_fixa`) VALUES
(1, 'testeeee', '1', '100.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `flux_planos`
--

CREATE TABLE `flux_planos` (
  `id_plano` int(50) NOT NULL,
  `descricao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `flux_planos`
--

INSERT INTO `flux_planos` (`id_plano`, `descricao`) VALUES
(1, 'Entrada'),
(2, 'Saida'),
(3, 'teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE `grupo` (
  `id_grupo` int(10) NOT NULL,
  `nomegrupo` varchar(200) NOT NULL,
  `meses` int(3) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `nomegrupo`, `meses`, `valor`) VALUES
(1, 'AVULSO', 0, '0.00'),
(4, 'grupo_teste', 1, '110.00'),
(17, 'grupo_teste2', 2, '150.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `maile`
--

CREATE TABLE `maile` (
  `id` int(10) NOT NULL,
  `empresa` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `porta` varchar(20) NOT NULL,
  `endereco` varchar(250) NOT NULL,
  `limitemail` varchar(30) NOT NULL,
  `aviso` varchar(250) NOT NULL,
  `avisofataberto` varchar(250) NOT NULL,
  `avisoaniversario` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `text1` longtext NOT NULL,
  `text2` longtext NOT NULL,
  `text3` longtext NOT NULL,
  `text4` longtext NOT NULL,
  `ativo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `maile`
--

INSERT INTO `maile` (`id`, `empresa`, `url`, `porta`, `endereco`, `limitemail`, `aviso`, `avisofataberto`, `avisoaniversario`, `email`, `senha`, `text1`, `text2`, `text3`, `text4`, `ativo`) VALUES
(1, 'PLGC', 'smtp.plgc.com.br', '587', 'http://plgc.com.br/boletos/', '250', 'Aviso de Fatura gerada', 'Reaviso de cobrança', 'Feliz aniversário', 'teste@plgc.com.br', 'Pladmin2016', '<h2>BOLETO PLGC</h2>\r\n<hr />\r\n<p><strong>Ol&aacute; [NomedoCliente],</strong></p>\r\n<p><strong><span style=\"color: #008000;\">Voc&ecirc; tem uma nova fatura.</span><br /></strong></p>\r\n<ul>\r\n<li><strong>Valor:</strong> [valor]</li>\r\n<li><strong>Vencimento:</strong> [vencimento]</li>\r\n<li><strong>N&ordm; da Fatura: </strong>[numeroFatura]</li>\r\n</ul>\r\n<p><strong>Refer&ecirc;nte a:</strong> [Descricaodafatura]</p>\r\n<p><strong>Para efetuar o pagamento, clique no bot&atilde;o abaixo \"Realizar Pagamento\"</strong></p>\r\n<p>[link]</p>\r\n<p>- Central de atendimento no e-mail: teste@plgc.com.br<br /> - 2&ordm; Via do Boleto, solicite no e-mail:&nbsp;teste@plgc.com.br</p>\r\n<hr />\r\n<p><strong>AVISO LEGAL</strong>: Esta mensagem &eacute; destinada exclusivamente para a(s) pessoa(s) a quem &eacute; dirigida, podendo conter informa&ccedil;&atilde;o confidencial e/ou legalmente privilegiada. Se voc&ecirc; n&atilde;o for destinat&aacute;rio desta mensagem, desde j&aacute; fica notificado de abster-se a divulgar, copiar, distribuir, examinar ou, de qualquer forma, utilizar a informa&ccedil;&atilde;o contida nesta mensagem, por ser ilegal. Caso voc&ecirc; tenha recebido esta mensagem por engano, pedimos que nos retorne este E-Mail, promovendo, desde logo, a elimina&ccedil;&atilde;o do seu conte&uacute;do em sua base de dados, registros ou sistema de controle. Fica desprovida de efic&aacute;cia e validade a mensagem que contiver v&iacute;nculos obr</p>', '<h2>BOLETO PLGC</h2>\r\n<hr />\r\n<p><strong>Ol&aacute; [NomedoCliente],</strong></p>\r\n<p><strong>Ainda n&atilde;o identificamos o pagamento da fatura descrita a baixo:</strong></p>\r\n<ul>\r\n<li><strong>Valor:</strong> [valor]</li>\r\n<li><strong>Vencimento:</strong> [vencimento]</li>\r\n</ul>\r\n<p><strong>Refer&ecirc;nte a:</strong> [Descricaodafatura]</p>\r\n\n<p><strong>&nbsp; &nbsp; &nbsp; Caso tenha alguma dúvida, por favor entre em contato conosco.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<hr />\r\n<p><strong>AVISO LEGAL</strong>: Esta mensagem &eacute; destinada exclusivamente para a(s) pessoa(s) a quem &eacute; dirigida, podendo conter informa&ccedil;&atilde;o confidencial e/ou legalmente privilegiada. Se voc&ecirc; n&atilde;o for destinat&aacute;rio desta mensagem, desde j&aacute; fica notificado de abster-se a divulgar, copiar, distribuir, examinar ou, de qualquer forma, utilizar a informa&ccedil;&atilde;o contida nesta mensagem, por ser ilegal. Caso voc&ecirc; tenha recebido esta mensagem por engano, pedimos que nos retorne este E-Mail, promovendo, desde logo, a elimina&ccedil;&atilde;o do seu conte&uacute;do em sua base de dados, registros ou sistema de controle. Fica desprovida de efic&aacute;cia e validade a mensagem que contiver v&iacute;nculos obrigacionais, expedida por quem n&atilde;o detenha poderes de representa&ccedil;&atilde;o. asdf</p>', '<p>Seu cadastro foi efetuado com sucesso em nosso sistema.</p><p>Segue seus dados de acesso: testesasdf</p>', '<h2>BOLETO PLGC</h2>\r\n<hr />\r\n<p><strong>Ol&aacute; [NomedoCliente],</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Gostariamos de parabeniza-lo pelos seus <strong>[idade]</strong> anos.</p>\r\n<p><img src=\"http://1.bp.blogspot.com/-GjOHJP7Xrtw/UkXL_WYRqPI/AAAAAAAAI1U/K0lTSla30iw/s1600/mensagens-aniversario-frases-parabens.jpg\" alt=\"\" width=\"400\" height=\"225\" /></p>\r\n<hr />\r\n<p><strong>AVISO LEGAL</strong>: Esta mensagem &eacute; destinada exclusivamente para a(s) pessoa(s) a quem &eacute; dirigida, podendo conter informa&ccedil;&atilde;o confidencial e/ou legalmente privilegiada. Se voc&ecirc; n&atilde;o for destinat&aacute;rio desta mensagem, desde j&aacute; fica notificado de abster-se a divulgar, copiar, distribuir, examinar ou, de qualquer forma, utilizar a informa&ccedil;&atilde;o contida nesta mensagem, por ser ilegal. Caso voc&ecirc; tenha recebido esta mensagem por engano, pedimos que nos retorne este E-Mail, promovendo, desde logo, a elimina&ccedil;&atilde;o do seu conte&uacute;do em sua base de dados, registros ou sistema de controle. Fica desprovida de efic&aacute;cia e validade a mensagem que contiver v&iacute;nculos obrigacionais, expedida por quem n&atilde;o detenha poderes de representa&ccedil;&atilde;o. asdf</p>', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pag_extra`
--

CREATE TABLE `pag_extra` (
  `id` int(10) NOT NULL,
  `user` varchar(100) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `assinatura` varchar(200) DEFAULT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `ativo` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `remessas`
--

CREATE TABLE `remessas` (
  `id` int(50) NOT NULL,
  `data` datetime NOT NULL,
  `nome` varchar(20) NOT NULL,
  `grupo` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `remessas`
--

INSERT INTO `remessas` (`id`, `data`, `nome`, `grupo`) VALUES
(3, '2018-02-27 14:19:03', '1tWxFKiu.REM', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sequencial`
--

CREATE TABLE `sequencial` (
  `id` int(20) NOT NULL,
  `arquivo` varchar(20) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sequencial`
--

INSERT INTO `sequencial` (`id`, `arquivo`, `data`) VALUES
(1, 'CB060717.REM', '2017-07-06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(30) NOT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `usuario`, `senha`) VALUES
(1, 'Administrador', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`id_banco`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_grupo` (`id_grupo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faturas`
--
ALTER TABLE `faturas`
  ADD PRIMARY KEY (`id_venda`),
  ADD UNIQUE KEY `id_venda` (`id_venda`),
  ADD KEY `id_venda_2` (`id_venda`),
  ADD KEY `idx_1` (`situacao`);

--
-- Indexes for table `financeiro`
--
ALTER TABLE `financeiro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nosso_numero_2` (`nosso_numero`),
  ADD KEY `nosso_numero` (`nosso_numero`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `flux_entrada`
--
ALTER TABLE `flux_entrada`
  ADD PRIMARY KEY (`id_entrada`);

--
-- Indexes for table `flux_fixas`
--
ALTER TABLE `flux_fixas`
  ADD PRIMARY KEY (`id_fixa`);

--
-- Indexes for table `flux_planos`
--
ALTER TABLE `flux_planos`
  ADD PRIMARY KEY (`id_plano`);

--
-- Indexes for table `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indexes for table `maile`
--
ALTER TABLE `maile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pag_extra`
--
ALTER TABLE `pag_extra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remessas`
--
ALTER TABLE `remessas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sequencial`
--
ALTER TABLE `sequencial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bancos`
--
ALTER TABLE `bancos`
  MODIFY `id_banco` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `faturas`
--
ALTER TABLE `faturas`
  MODIFY `id_venda` bigint(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1062;
--
-- AUTO_INCREMENT for table `financeiro`
--
ALTER TABLE `financeiro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `flux_entrada`
--
ALTER TABLE `flux_entrada`
  MODIFY `id_entrada` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `flux_fixas`
--
ALTER TABLE `flux_fixas`
  MODIFY `id_fixa` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `flux_planos`
--
ALTER TABLE `flux_planos`
  MODIFY `id_plano` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `maile`
--
ALTER TABLE `maile`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pag_extra`
--
ALTER TABLE `pag_extra`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `remessas`
--
ALTER TABLE `remessas`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sequencial`
--
ALTER TABLE `sequencial`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
