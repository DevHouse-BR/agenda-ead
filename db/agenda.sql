# Script para criação do banco de dados AGENDA

# Tabela Compromissos:
#
# cd = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena um código únicao para cada compromisso. Facilita a localização do registro.
# tipo = até 100 caracteres, não nulo = Tipo do compromisso (Conferência, Video-Conferência, etc).
# nome = até 255 Caracteres, não nulo = Nome do compromisso
# descricao = até 255 caracteres, não nulo = características do compromisso.
# inicio = inteiro, sem sinal = armazena o timestamp (numero de segundos desde 1970 para uma data precisa)
# fim = inteiro, sem sinal = armazena o timestamp (numero de segundos desde 1970 para uma data precisa)
# dia = dois caracteres representando o dia ex: "23"
# mes = dois caracteres representando o mes ex: "08"
# ano = quatro caracteres representando o ano ex: "2003"
# email = um caracter para quardar os valores "s" e "n" = avisar por email?
# wap = um caracter para quardar os valores "s" e "n" = avisar por wap?
# curso = até 255 caracteres para armazenar o nome do curso a que este compromisso está relacionado
# turma = até 255 caracteres para armazenar o nome da turma a que este compromisso está relacionado
# avisar = inteiro, sem sinal = armazena o timestamp da data a ser avisado deste compromisso
# avisado = um caracter para guardar "s" e "n" = já foi avisado?

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
  `email` char(1) NOT NULL default '',
  `wap` char(1) NOT NULL default '',
  `curso` varchar(255) NOT NULL default '',
  `turma` varchar(255) NOT NULL default '',
  `avisar` int(10) unsigned NOT NULL default '0',
  `avisado` char(1) NOT NULL default '',
  PRIMARY KEY  (`cd`)
);

# Tabela Contatos:
#
# cd = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena um código único. Facilita a localização do registro.
# dono = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena o código da pessoa que gravou este contato.
# nome = até 255 Caracteres, não nulo = Nome do contato
# email = até 255 caracteres, não nulo = email do contato.
# obs = blob (binary large object ou grande objeto binario), campos blob servem para armazenar qualquer quantidade de dados = aqui será armazenado um texto de qualquer tamanho como observação do contat0.


CREATE TABLE `contatos` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `dono` int(10) unsigned NOT NULL default '0',
  `nome` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `obs` blob NOT NULL,
  PRIMARY KEY  (`cd`),
  KEY `dono` (`dono`)
);

# Tabela Cursos
#
# cd = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena um código único. Facilita a localização do registro.
# curso = até 255 Caracteres, não nulo, chave única = Nome do curso (não pode ter igual)


CREATE TABLE `cursos` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `curso` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cd`),
  UNIQUE KEY `curso` (`curso`)
);


# Tabela Eventos:
#
# cd = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena um código únicao para cada evento. Facilita a localização do registro.
# tipo = até 100 caracteres, não nulo = Tipo do compromisso (Conferência, Video-Conferência, etc).
# nome = até 255 Caracteres, não nulo = Nome do compromisso
# descricao = até 255 caracteres, não nulo = características do compromisso.
# inicio = inteiro, sem sinal = armazena o timestamp (numero de segundos desde 1970 para uma data precisa)
# fim = inteiro, sem sinal = armazena o timestamp (numero de segundos desde 1970 para uma data precisa)
# dia = dois caracteres representando o dia ex: "23"
# mes = dois caracteres representando o mes ex: "08"
# ano = quatro caracteres representando o ano ex: "2003"
# email = um caracter para quardar os valores "s" e "n" = avisar por email?
# wap = um caracter para quardar os valores "s" e "n" = avisar por wap?
# local= até 255 caracteres para armazenar o local onde será realizado o evento
# avisar = inteiro, sem sinal = armazena o timestamp da data a ser avisado deste compromisso
# avisado = um caracter para guardar "s" e "n" = já foi avisado?


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
  `email` char(1) NOT NULL default '',
  `wap` char(1) NOT NULL default '',
  `avisar` int(10) unsigned NOT NULL default '0',
  `local` varchar(255) NOT NULL default '',
  `avisado` char(1) NOT NULL default '',
  PRIMARY KEY  (`cd`)
);


# Tabela grupos:
#
# cd = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena um código único. Facilita a localização do registro.
# nome = até 255 Caracteres, não nulo, chave única = Nome do grupo
# cd_criador = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena o código do usuário que criou o grupo.
# curso = até 255 caracteres para armazenar o nome do curso a que este grupo está relacionado
# turma = até 255 caracteres para armazenar o nome da turma a que este grupo está relacionado
# professor = até 255 Caracteres, não nulo = professor do grupo


CREATE TABLE `grupos` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(255) NOT NULL default '',
  `cd_criador` int(10) unsigned NOT NULL default '0',
  `curso` varchar(255) NOT NULL default '',
  `turma` varchar(255) NOT NULL default '',
  `professor` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cd`),
  UNIQUE KEY `nome` (`nome`)
);


# Tabela grupos:
#
# nome_grupo = até 255 Caracteres, não nulo = Nome do grupo
# cd_integrante = Inteiro, sem sinal, não nulo = Armazena o código de cada integrante do grupo.


CREATE TABLE `grupos_integrantes` (
  `nome_grupo` varchar(255) NOT NULL default '0',
  `cd_integrante` int(10) unsigned NOT NULL default '0'
);


# Tabela links:
#
# cd = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena um código único para cada link. Facilita a localização do registro.
# dono = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena o código da pessoa que gravou este link.
# nome = até 255 Caracteres, não nulo = Nome do link.
# link = até 255 caracteres, não nulo = link em si.
# descricao = blob (binary large object ou grande objeto binario), campos blob servem para armazenar qualquer quantidade de dados = aqui será armazenado um texto de qualquer tamanho como descricao do link.


CREATE TABLE `links` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `dono` int(10) unsigned NOT NULL default '0',
  `nome` varchar(255) NOT NULL default '',
  `descricao` blob NOT NULL,
  `link` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cd`),
  KEY `dono` (`dono`)
);


# Tabela tarefas:
#
# cd = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena um código únicao para cada compromisso. Facilita a localização do registro.
# tipo = até 100 caracteres, não nulo = Tipo do compromisso (Conferência, Video-Conferência, etc).
# nome = até 255 Caracteres, não nulo = Nome do compromisso
# descricao = até 255 caracteres, não nulo = características do compromisso.
# prazo = inteiro, sem sinal = armazena o timestamp (numero de segundos desde 1970 para uma data precisa) = prazo de conclusão da tarefa.
# dia = dois caracteres representando o dia ex: "23"
# mes = dois caracteres representando o mes ex: "08"
# ano = quatro caracteres representando o ano ex: "2003"
# email = um caracter para quardar os valores "s" e "n" = avisar por email?
# wap = um caracter para quardar os valores "s" e "n" = avisar por wap?
# curso = até 255 caracteres para armazenar o nome do curso a que esta tarefa está relacionado
# turma = até 255 caracteres para armazenar o nome da turma a que esta tarefa está relacionado
# avisar = inteiro, sem sinal = armazena o timestamp da data a ser avisado deste compromisso
# avisado = um caracter para guardar "s" e "n" = já foi avisado?
# prioridade = inteiro = armazena a prioridade (1, 2 ou 3);
# opcao = até oito caracteres para dizer a opção selecionada na hora do agendamento da tarefa: (todos, privado, em_grupo)
# desc_opcao = até 255 caracteres para armazenar alguma informação relacionada a opção selecionada: caso seja em grupo armazena o nome do grupo, caso seja privado, armazena o codigo do usuario.

CREATE TABLE `tarefas` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `tipo` varchar(100) NOT NULL default '',
  `nome` varchar(255) NOT NULL default '',
  `descricao` varchar(255) NOT NULL default '',
  `prazo` int(10) unsigned NOT NULL default '0',
  `email` char(1) NOT NULL default '',
  `wap` char(1) NOT NULL default '',
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
);


# Tabela turma_curso
#
# cd = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena um código único para cada turma. Facilita a localização do registro.
# turma = até 255 caracteres, não nulo = nome da turma
# curso = até 255 caracteres, não nulo = nome do curso

CREATE TABLE `turma_curso` (
  `cd` int(10) unsigned NOT NULL auto_increment,
  `turma` varchar(255) NOT NULL default '',
  `curso` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cd`)
);

# Tabela usuarios:
#
# cd = Inteiro, sem sinal, não nulo, auto incrementado, chave primária = Armazena um código único para cada usuario.
# nome = até 255 caracteres, não nulo = nome do usuario
# endereco = até 255 caracteres, não nulo = endereco
# tel_res, tel_com, celular = até 30 caracteres, não nulo = telefones do usuário
# email = até 255 caracteres, não nulo = email
# profissao = até 100 caracteres, não nulo = profissão do usuário
# senha = até 255 caracteres, não nulo, binário = senha do usuario. Como o campo é binário as buscas são case sensitive.
# tipo = até 10 caracteres, não nulo = tipo do usuário: professor ou aluno
# professor = até 255 caracteres, não nulo = nome do professor se for aluno
# turma = até 255 caracteres, não nulo = turma do usuario
# curso = até 255 caracteres, não nulo = curso do curso
# alterar_senha = 1 caracter = armazena "s" para sim e "n" para não


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
  `professor` varchar(255) NOT NULL default '',
  `alterar_senha` char(1) NOT NULL default '',
  `obs` varchar(255) default NULL,
  PRIMARY KEY  (`cd`),
  UNIQUE KEY `email` (`email`),
  KEY `nome` (`nome`)
);