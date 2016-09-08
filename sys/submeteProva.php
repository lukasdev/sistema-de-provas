<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config.php';

    $provaId = (int)$_POST['prova'];
    $respostas = $_POST['respostas'];

    $insereHistorico = $pdo->prepare("INSERT INTO `historico` SET `id_aluno` = ?, `id_prova` = ?");
    $insereHistorico->execute([
        1,
        $provaId
    ]);
    $lastId = $pdo->lastInsertId();

    foreach ($respostas as $idQuestao => $resposta) {
        if ($resposta != '') {
            $insert = [$lastId, $idQuestao, $resposta];
            $insertRespostas = $pdo->prepare("INSERT INTO `respostas` SET `id_historico` = ?,
                `id_questao` = ?, `resposta` = ?");
            $insertRespostas->execute($insert);
        }
    }
}