# Banco de Dados agenda Rodando em localhost 
# phpMyAdmin MySQL-Dump
# version 2.5.0
# http://www.phpmyadmin.net/ (download page)
#
# Servidor: localhost
# Tempo de Generação: Nov 16, 2003 at 11:07 AM
# Versão do Servidor: 4.0.13
# Versão do PHP: 4.3.1
# Banco de Dados : `agenda`
# --------------------------------------------------------

#
# Estrutura da tabela `compromissos`
#
# Creation: Out 26, 2003 at 10:16 PM
# Last update: Nov 05, 2003 at 03:53 PM
#

CREATE TABLE `compromissos` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `tipo` varchar(100) NOT NULL default '',
  `nome` varchar(255) NOT NULL default '',
  `descricao` varchar(255) NOT NULL default '',
  `inicio` int(10) unsigned NOT NULL default '0',
  `fim` int(10) unsigned NOT NULL default '0',
  `dia` char(2) NOT NULL default '',
  `mes` char(2) NOT NULL default '',
  `ano` varchar(4) NOT NULL default '',
  `curso` varchar(255) NOT NULL default '',
  `turma` varchar(255) NOT NULL default '',
  `avisar` int(10) unsigned NOT NULL default '0',
  `avisado` char(1) NOT NULL default '',
  PRIMARY KEY  (`cd`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

#
# Extraindo dados da tabela `compromissos`
#

INSERT INTO `compromissos` VALUES (1, 'Conferência', 'teste', 'fdsafd asfdsafdsaf dsafdsa', 1070262000, 1070265600, '01', '12', '2003', 'teste', 'teste', 1070175600, 'n');
INSERT INTO `compromissos` VALUES (2, 'Conferência', 'fdsafdsafdsa', 'fdsafdsafdsa', 1070280000, 1070283600, '01', '12', '2003', 'teste', 'teste', 1070193600, 'n');
INSERT INTO `compromissos` VALUES (3, 'Conferência', 'fdsafdsafdsa', 'fdsafdsafdsafdsaf', 1070244000, 1070247600, '01', '12', '2003', 'teste', 'teste', 1070157600, 'n');
INSERT INTO `compromissos` VALUES (4, 'Conferência', 'fhds afhds alkjfh', 'fjdsalçkfj dsalçkjfdlks', 1071108000, 1071111600, '11', '12', '2003', 'teste', 'teste', 1071021600, 'n');
# --------------------------------------------------------

#
# Estrutura da tabela `contatos`
#
# Creation: Out 26, 2003 at 10:16 PM
# Last update: Nov 06, 2003 at 06:35 PM
#

CREATE TABLE `contatos` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `dono` int(10) unsigned NOT NULL default '0',
  `nome` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `obs` blob NOT NULL,
  PRIMARY KEY  (`cd`),
  KEY `dono` (`dono`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

#
# Extraindo dados da tabela `contatos`
#

INSERT INTO `contatos` VALUES (2, 2, 'fdsafdsafd', 'safdsaf', 0x64736166647361);
INSERT INTO `contatos` VALUES (3, 2, 'fdsafdsafdsa', 'fdsafds', 0x61666473616664);
INSERT INTO `contatos` VALUES (4, 1, 'gfdsafdsafdsa', 'safdsafdsa', 0x66647361666473616664);
# --------------------------------------------------------

#
# Estrutura da tabela `cursos`
#
# Creation: Out 26, 2003 at 10:15 PM
# Last update: Nov 06, 2003 at 06:35 PM
#

CREATE TABLE `cursos` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `curso` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cd`),
  UNIQUE KEY `curso_2` (`curso`),
  KEY `curso` (`curso`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

#
# Extraindo dados da tabela `cursos`
#

INSERT INTO `cursos` VALUES (1, 'teste');
INSERT INTO `cursos` VALUES (2, '123');
INSERT INTO `cursos` VALUES (3, '456789');
INSERT INTO `cursos` VALUES (4, '');
INSERT INTO `cursos` VALUES (5, 'fdsafdsafdsa');
INSERT INTO `cursos` VALUES (6, 'fdsaf');
# --------------------------------------------------------

#
# Estrutura da tabela `eventos`
#
# Creation: Out 26, 2003 at 10:16 PM
# Last update: Nov 05, 2003 at 03:57 PM
#

CREATE TABLE `eventos` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `tipo` varchar(100) NOT NULL default '',
  `nome` varchar(255) NOT NULL default '',
  `descricao` varchar(255) NOT NULL default '',
  `inicio` int(10) unsigned NOT NULL default '0',
  `fim` int(10) unsigned NOT NULL default '0',
  `dia` char(2) NOT NULL default '',
  `mes` char(2) NOT NULL default '',
  `ano` varchar(4) NOT NULL default '',
  `avisar` int(10) unsigned NOT NULL default '0',
  `local` varchar(255) NOT NULL default '',
  `avisado` char(1) NOT NULL default '',
  PRIMARY KEY  (`cd`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Extraindo dados da tabela `eventos`
#

INSERT INTO `eventos` VALUES (1, 'Palestra', 'fdsafdsafdsaf', 'fdsafdsaf dsafdsafdsa fdsaf dsaf', 1072782000, 1072785600, '30', '12', '2003', 1072695600, 'fdsa fdsaf dsaf dsaf afdsaf d', 'n');
INSERT INTO `eventos` VALUES (2, 'Palestra', 'dfsaf dsaf dsaf dsa', ' fdsa fdasf d', 1072490400, 1072494000, '27', '12', '2003', 1072404000, 'saf dsa fdsa fd', 'n');
# --------------------------------------------------------

#
# Estrutura da tabela `grupos`
#
# Creation: Out 26, 2003 at 10:16 PM
# Last update: Out 26, 2003 at 10:16 PM
#

CREATE TABLE `grupos` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(255) NOT NULL default '',
  `cd_criador` int(10) unsigned NOT NULL default '0',
  `curso` varchar(255) NOT NULL default '',
  `turma` varchar(255) NOT NULL default '',
  `professor` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cd`),
  UNIQUE KEY `nome` (`nome`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Extraindo dados da tabela `grupos`
#

# --------------------------------------------------------

#
# Estrutura da tabela `grupos_integrantes`
#
# Creation: Out 26, 2003 at 10:16 PM
# Last update: Out 26, 2003 at 10:16 PM
#

CREATE TABLE `grupos_integrantes` (
  `nome_grupo` varchar(255) NOT NULL default '0',
  `cd_integrante` int(10) unsigned NOT NULL default '0'
) TYPE=MyISAM;

#
# Extraindo dados da tabela `grupos_integrantes`
#

# --------------------------------------------------------

#
# Estrutura da tabela `links`
#
# Creation: Out 26, 2003 at 10:16 PM
# Last update: Nov 09, 2003 at 11:54 PM
#

CREATE TABLE `links` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `dono` int(10) unsigned NOT NULL default '0',
  `nome` varchar(255) NOT NULL default '',
  `descricao` blob NOT NULL,
  `link` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cd`),
  KEY `dono` (`dono`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

#
# Extraindo dados da tabela `links`
#

INSERT INTO `links` VALUES (5, 1, 'hj jh lkjh  hlkjh lk', 0x68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c68206c6b68206b6c6a20686c6b6a20686c6b6a68206c20686c6b6a20686c6b6a20686c6b6a20686c6b6a68206c6b6a20686c6b6a68206c6b6a68206b6a6c20686c, 'hjk klkh lkjh');
INSERT INTO `links` VALUES (6, 1, 'ssssssssssss', 0x73737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373737373, 'ssssssssssssssssss');
# --------------------------------------------------------

#
# Estrutura da tabela `tarefas`
#
# Creation: Out 26, 2003 at 10:15 PM
# Last update: Nov 05, 2003 at 04:02 PM
#

CREATE TABLE `tarefas` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `tipo` varchar(100) NOT NULL default '',
  `nome` varchar(255) NOT NULL default '',
  `descricao` varchar(255) NOT NULL default '',
  `prazo` int(10) unsigned NOT NULL default '0',
  `avisar` int(10) unsigned NOT NULL default '0',
  `prioridade` int(10) unsigned NOT NULL default '0',
  `curso` varchar(255) NOT NULL default '',
  `turma` varchar(255) NOT NULL default '',
  `opcao` varchar(8) NOT NULL default '',
  `desc_opcao` varchar(255) NOT NULL default '',
  `dia` char(2) NOT NULL default '',
  `mes` char(2) NOT NULL default '',
  `ano` varchar(4) NOT NULL default '',
  `avisado` char(1) NOT NULL default '',
  PRIMARY KEY  (`cd`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

#
# Extraindo dados da tabela `tarefas`
#

INSERT INTO `tarefas` VALUES (1, 'Trabalho', 'fj dsalkjf dlksaj fçdlksaj', ' jfjdklsa jfdsa çjfçlkds afjdlksa fjçlkdsa flkds ajçl', 1072339200, 1072252800, 1, 'teste', 'teste', 'todos', '', '25', '12', '2003', 'n');
INSERT INTO `tarefas` VALUES (2, 'Trabalho', 'fj dsalkjf dlksaj fçdlksaj', ' jfjdklsa jfdsa çjfçlkds afjdlksa fjçlkdsa flkds ajçl', 1072339200, 1072252800, 1, 'teste', 'teste', 'todos', '', '25', '12', '2003', 'n');
INSERT INTO `tarefas` VALUES (3, 'Trabalho', 'fdsa fdsaf dsa fdsa', 'f dsa fdasf dsa fdsa fdsaf dsa fd', 1071108000, 1071021600, 1, 'teste', 'teste', 'todos', '', '11', '12', '2003', 'n');
# --------------------------------------------------------

#
# Estrutura da tabela `turma_curso`
#
# Creation: Out 26, 2003 at 10:15 PM
# Last update: Nov 06, 2003 at 06:35 PM
#

CREATE TABLE `turma_curso` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `turma` varchar(255) NOT NULL default '',
  `curso` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cd`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;

#
# Extraindo dados da tabela `turma_curso`
#

INSERT INTO `turma_curso` VALUES (1, 'teste', 'teste');
INSERT INTO `turma_curso` VALUES (2, 'fdsafdsa', '456789');
INSERT INTO `turma_curso` VALUES (3, 'fdsafdsa', '123');
INSERT INTO `turma_curso` VALUES (4, 'fdsafdsafds', 'fdsaf');
INSERT INTO `turma_curso` VALUES (5, 'fdsafdsafdsaf', '456789');
# --------------------------------------------------------

#
# Estrutura da tabela `usuarios`
#
# Creation: Out 26, 2003 at 10:15 PM
# Last update: Nov 05, 2003 at 03:11 PM
#

CREATE TABLE `usuarios` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(150) NOT NULL default '',
  `endereco` varchar(255) NOT NULL default '',
  `tel_res` varchar(30) NOT NULL default '',
  `tel_com` varchar(30) NOT NULL default '',
  `celular` varchar(30) default NULL,
  `email` varchar(150) binary NOT NULL default '',
  `profissao` varchar(100) NOT NULL default '',
  `senha` varchar(255) binary NOT NULL default '',
  `tipo` varchar(10) NOT NULL default '',
  `turma` varchar(255) NOT NULL default '',
  `curso` varchar(255) NOT NULL default '',
  `professor` varchar(150) NOT NULL default '',
  `alterar_senha` char(1) NOT NULL default '',
  `obs` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cd`),
  UNIQUE KEY `email` (`email`),
  KEY `nome` (`nome`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;

#
# Extraindo dados da tabela `usuarios`
#

INSERT INTO `usuarios` VALUES (1, 'Leonardo lima de vasocncellos', 'fgdsjaçlk fjdsçlkafj çl', 'jj', 'j', 'kjlj', 'leo', 'fdjsalfjdslkaj', '123456', 'professor', 'teste', 'teste', '', 'n', 'jkljlkfdjslkf');
INSERT INTO `usuarios` VALUES (2, 'teste', 'fdsafd', 'fdsafds', 'afdsaf', 'dsa', 'teste', 'fdsafdsaf', '123456', 'professor', 'teste', 'teste', '', 'n', 'dsa');
INSERT INTO `usuarios` VALUES (3, 'blablabla', ' fdsaf dsaf dsa', 'f dsaf dsaf d', 'safdsafdsa fd', 'f dsafdsa', 'blablabla', 'rewqrewqr', 'MzQ5NDE3MTE', 'aluno', 'teste', 'teste', 'teste', 's', '');
INSERT INTO `usuarios` VALUES (4, '123', '123', '123', '123', '123', '123', '123', 'MTQxNzc1NTE', 'aluno', 'teste', 'teste', 'teste', 's', '');
INSERT INTO `usuarios` VALUES (5, '456', '456', '456', '456', '46', '456', '456', 'NjQ4Njg0Njk', 'professor', 'teste', 'teste', '', 's', '456');

    