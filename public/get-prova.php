<?php

if (isset($_GET['id_prova']) && is_numeric($_GET['id_prova'])) {
    
    /**
     * Inclui o arquivo de funções
     */
    include __DIR__ . '/../src/functions.php';

    if (! isset($_GET['id_prova'])) {
        responseError('ID da prova não foi passado.');
    }

    /**
     * ID da prova
     * @var integer
     */
    $id_prova = (int) $_GET['id_prova'];

    if (! $prova = getProvaById($id_prova)) {
        responseError('Prova não localizada.');
    }
    
    $retorno = [
        'titulo' => $prova->titulo,
        'tempo' => $prova->tempo,
        'questoes' => [],
    ];

    /**
     * Questoes da prova
     * @var array
     */
    foreach (getQuestoesByProvaId($id_prova) as $n => $questao) {

        $retorno['questoes'][$n] = [
            'id' => $questao->id,
            'questao' => $questao->questao,
            'tipo' => $questao->tipo
        ];

        if ($questao->tipo == 0) {

            /**
             * Opções das questões
             */
            $retorno['questoes'][$n]['opcoes'] = [];

            /**
             * Adicionando as opções das questões
             */
            foreach (getOpcoesByquestaoId($questao->id) as $opcao) {

                $retorno['questoes'][$n]['opcoes'][] = [
                    'id' => $opcao->id,
                    'opcao' => $opcao->opcao
                ];
            }
        }
    }

    responeSuccess($retorno);
}

responseError('Favor passar via query string o \'id_prova\'.');