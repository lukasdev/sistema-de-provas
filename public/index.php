<?php include __DIR__ . '/../src/functions.php' ?>

<!DOCTYPE HTML>
<html lang="pt-BR">
    <head>
        <meta charset=UTF-8>
        <title>Provas</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <section id="wrap-geral">
            <ul id="prova-lista">
            
                <?php foreach ($provas = getProvasNaoRespondidasByAlunoId(1) as $prova): ?>

                <li class="open-prova prova<?php echo $prova->id ?>" data-id="<?php echo $prova->id ?>">
                    <a href><?php echo $prova->titulo ?></a>
                </li>

                <?php endforeach ?>

                <?php if (! $provas) : ?>
                <li>Não há provas para responder</li>
                <?php endif ?>
            </ul>

            <section id="wrap-prova">
                <div class="begin">
                    <button id="comecar" class="button azul">Iniciar Prova</button>
                </div>

                <div class="sucesso">
                    <p>A prova foi submetida para avaliação!</p>
                </div>

                <h1></h1>

                <div class="questoes">
                
                </div>

                <button class="button" id="prev">Anterior</button>
                <button class="button" id="next">Próxima</button>
            </section>

            <div style="clear:both;"></div>
            <span class="timer">39:59</span>
        </section>
        

        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/timer.js"></script>
        <script type="text/javascript" src="/js/functions.js"></script>
    </body>
</html>