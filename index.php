<?php include 'config.php';?>
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
            <?php
                $provas = $pdo->prepare("SELECT * FROM `provas` WHERE `status` = 1 ORDER BY `id` DESC");
                $provas->execute();

                while ($row = $provas->fetchObject()) {
                    $verificaHistorico = $pdo->prepare("SELECT * FROM `historico` WHERE `id_aluno` = ? AND 
                        `id_prova` = ?");
                    $verificaHistorico->execute([1, $row->id]);
                    if ($verificaHistorico->rowCount() == 0) {
            ?>
                <li class="open-prova prova<?php echo $row->id;?>" data-id="<?php echo $row->id;?>">
                    <a href="#">
                        <?php echo $row->titulo;?>
                    </a>
                </li>
            <?php }}?>
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
        

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/timer.js"></script>
        <script type="text/javascript" src="js/functions.js"></script>
    </body>
</html>