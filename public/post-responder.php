<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    /**
     * Inclui o arquivo de funções
     */
    include __DIR__ . '/../src/functions.php';

    try {
        
        $historico_id = saveHistorico(1, (int) $_POST['id_prova']);

        foreach ($_POST['respostas'] as $questao_id => $resposta) {

            if ($resposta != '') {
                saveResposta($historico_id, $questao_id, $resposta);
            }
        }

        responeSuccess();

    } catch (\Exception $e) {
        responseError($e->getMessage());
    }
}

responseError('Favor enviar a resposta via post.');