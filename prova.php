<?php 
    include 'config.php';

    if(!isset($_GET['prova'])) {
        header("Location: index.php");
    }

    $id = (int)preg_replace('/[^0-9]/i', '', $_GET['prova']);
    $prova = $pdo->prepare("SELECT * FROM `provas` WHERE `id` = ? AND `status` = 1");
    $prova->execute([$id]);

    if ($prova->rowCount() == 0) {
        header("Location: index.php");
    }

    $prova = $prova->fetchObject();
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
    <head>
        <meta charset=UTF-8>
        <title><?php echo $prova->titulo;?></title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>

        <section id="wrap-prova">
            <h1><?php echo $prova->titulo;?></h1>

            <div class="questao">
                <h2>Questão de exemplo</h2>
                <p><input type="radio" class="resposta" name="resposta1" value="1"/> Resposta 1</p>
                <p><input type="radio" class="resposta" name="resposta1" value="2"/> Resposta 2</p>
                <p><input type="radio" class="resposta" name="resposta1" value="3"/> Resposta 3</p>
                <p><input type="radio" class="resposta" name="resposta1" value="4"/> Resposta 4</p>
            </div>

            <div class="questao">
                <h2>Questão de exemplo</h2>
                <input type="text" name="resposta1" />
            </div>

            <button class="button" id="prev">Anterior</button>
            <button class="button" id="next">Próxima</button>
        </section>
        

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/functions.js"></script>
    </body>
</html>