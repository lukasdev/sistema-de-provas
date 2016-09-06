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
            ?>
                <li class="open-prova" data-id="<?php echo $row->id;?>">
                    <a href="prova.php?prova=<?php echo $row->id;?>">
                        <?php echo $row->titulo;?>
                    </a>
                </li>
            <?php }?>
            </ul>


            <section id="wrap-prova">
                <h1>Titulo aleatório</h1>

                <div class="questoes">
                
                </div>

                <button class="button" id="prev">Anterior</button>
                <button class="button" id="next">Próxima</button>
            </section>

            <div style="clear:both;"></div>
        </section>
        

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/functions.js"></script>
    </body>
</html>