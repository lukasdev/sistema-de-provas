<?php

/**
 * @return \PDO
 */
function pdo($params = [])
{
    $p = (object) array_merge([
        'driver' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'provas',
        'username' => 'root',
        'password' => '123'
    ], $params);

    $pdo = new PDO(
        // 'mysql:host=localhost;dbname=provas'
        sprintf('%s:host=%s;dbname=%s', $p->driver, $p->host, $p->dbname), 
        $p->username, 
        $p->password
    );

    $pdo->exec('set names utf8');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

/**
 * Insere no historico do aluno
 * 
 * @param $id_aluno
 * @param $id_prova
 * @return integer ID do historico salvo no banco
 */
function saveHistorico($id_aluno, $id_prova)
{
    $pdo = pdo();
    
    $row = $pdo->prepare('INSERT INTO `historico` SET `id_aluno` = ?, `id_prova` = ?');
    $row->execute([$id_aluno, $id_prova]);

    return $pdo->lastInsertId();
}

/**
 * Insere no historico do aluno
 * 
 * @param $id_aluno
 * @param $id_prova
 * @return integer ID do historico salvo no banco
 */
function saveResposta($id_historico, $id_questao, $resposta)
{   
    $row = pdo()->prepare('INSERT INTO `respostas` SET 
        `id_historico` = ?,
        `id_questao` = ?, 
        `resposta` = ?
    ');

    $row->execute([$id_historico, $id_questao, $resposta]);
}

/**
 * Retorna do banco de dados o registro da prova
 * 
 * @param $id_prova integer
 * @return null      Prova não localizada
 * @return \stdClass Prova
 */ 
function getProvaById($id_prova)
{
    $row = pdo()->prepare('SELECT * FROM `provas` WHERE `id` = ? AND `status` = 1');
    $row->execute([$id_prova]);

    if ($row->rowCount() == 0) {
        return null;
    }

    return $row->fetchObject();
}

/**
 * Retorna todas as provas do banco de dados
 * @return array
 */
function getProvas()
{
    $rows = pdo()->query('SELECT * FROM `provas` WHERE `status` = 1 ORDER BY `id` DESC');
    return $rows->fetchAll(\PDO::FETCH_OBJ);
}

/**
 * Retorna todas as provas do banco de dados
 * @return array
 */
function getProvasNaoRespondidasByAlunoId($id_aluno)
{
    $rows = pdo()->prepare('
        SELECT
        (select count(*) from historico where id_prova = p.id and id_aluno = ?) as tentativas,
        `p`.* FROM `provas` `p` WHERE `p`.`status` = 1
        ORDER BY `p`.`id` DESC
    ');
    
    $rows->execute([$id_aluno]);

    return array_filter($rows->fetchAll(\PDO::FETCH_OBJ), function ($row) {
        return $row->tentativas == 0;
    });
}

/**
 * Retorna do banco de dados todas as questões da prova
 * 
 * @param $id_prova integer
 * @return array
 */
function getQuestoesByProvaId($id_prova)
{
    $rows = pdo()->prepare('SELECT * FROM `questoes` WHERE `id_prova` = ?');
    $rows->execute([$id_prova]);

    return $rows->fetchAll(\PDO::FETCH_OBJ);
}

/**
 * Retorna do banco de dados todas as opções da questão
 * 
 * @param $id_questao integer
 * @return array
 */
function getOpcoesByquestaoId($id_questao)
{
    $rows = pdo()->prepare("SELECT * FROM `opcoes` WHERE `id_questao` = ?");
    $rows->execute([$id_questao]);

    return $rows->fetchAll(\PDO::FETCH_OBJ);
}

/**
 * Responde com JSON
 * 
 * @param $body array
 * @return JSON
 */
function responseJson($body)
{
    header('Content-Type: application/json');
    die(json_encode($body));
}

/**
 * @param $message Mensagem detalhando o erro ao usuário
 * @return JSON
 */
function responseError($message = null)
{
    return responseJson([
        'status' => 'no', 
        'message' => $message
    ]);
}

/**
 * @param $data array
 * @return JSON
 */
function responeSuccess($data = [])
{
    $response = [
        'status' => 'ok'
    ];

    return responseJson(array_merge($response, $data));
}