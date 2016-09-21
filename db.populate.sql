INSERT INTO `alunos` (`id`, `nome`) VALUES
(1, 'Lucas Silva');

INSERT INTO `historico` (`id`, `id_aluno`, `id_prova`) VALUES
(1, 1, 2),
(2, 1, 1);

INSERT INTO `opcoes` (`id`, `id_questao`, `opcao`) VALUES
(1, 1, 'NomeDaClasse: codigo endclass;'),
(2, 1, 'NomeDaClasse{ //codigo }'),
(3, 1, 'class NomeDaClasse{ //codigo }'),
(4, 3, 'Pode ser acessado de qualquer local.'),
(5, 3, 'Pode ser acessado pela classe mãe e classes parentes.'),
(6, 3, 'Só pode ser acessado de dentro da classe mãe'),
(7, 4, 'Opção 1'),
(8, 4, 'Opção2'),
(9, 4, 'Opção 3');

INSERT INTO `provas` (`id`, `titulo`, `tempo`, `status`) VALUES
(1, 'Prova sobre PHP Orientado a Objetos', 40, 1),
(2, 'Outra Prova', 15, 1);

INSERT INTO `questoes` (`id`, `id_prova`, `questao`, `tipo`) VALUES
(1, 1, 'Como se define uma classe?', 0),
(2, 1, 'Explique o conceito de herança.', 1),
(3, 1, 'Metodo privado', 0),
(4, 2, 'Questão 1', 0),
(5, 2, 'Questão  2', 1),
(6, 2, 'Questão  3', 1);

INSERT INTO `respostas` (`id`, `id_historico`, `id_questao`, `resposta`) VALUES
(1, 1, 4, '7'),
(2, 1, 5, 'Resposta 1'),
(3, 1, 6, 'Resposta 2'),
(4, 2, 1, '2'),
(5, 2, 2, 'Explicação'),
(6, 2, 3, '6');