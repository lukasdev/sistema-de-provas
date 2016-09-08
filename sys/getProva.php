<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config.php';

    if(!isset($_POST['prova'])) {
        die(json_encode(['status' => 'no']));
    }

    $id = (int)preg_replace('/[^0-9]/i', '', $_POST['prova']);
    $prova = $pdo->prepare("SELECT * FROM `provas` WHERE `id` = ? AND `status` = 1");
    $prova->execute([$id]);

    if ($prova->rowCount() == 0) {
        die(json_encode(['status' => 'no']));
    }

    $prova = $prova->fetchObject();
    $retorno = array();
    $retorno['status'] = 'ok';
    
    $retorno['titulo'] = $prova->titulo;
    $retorno['tempo'] = $prova->tempo;
    $retorno['questoes'] = array();

    $questoes = $pdo->prepare("SELECT * FROM `questoes` WHERE `id_prova` = ?");
    $questoes->execute([$id]);

    $n = 0;
    while ($questao = $questoes->fetchObject()) {
        $retorno['questoes'][$n] = [
            'id' => $questao->id,
            'questao' => $questao->questao,
            'tipo' => $questao->tipo
        ];

        if ($questao->tipo == 0) {
            $opcoes = $pdo->prepare("SELECT * FROM `opcoes` WHERE `id_questao` = ?");
            $opcoes->execute([$questao->id]);

            $retorno['questoes'][$n]['opcoes'] = array();

            while($opcao = $opcoes->fetchObject()) {
                $retorno['questoes'][$n]['opcoes'][] = [
                    'id' => $opcao->id,
                    'opcao' => $opcao->opcao
                ];
            }
        }

        $n++;
    }

    die(json_encode($retorno));
}
?>