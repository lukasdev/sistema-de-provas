<?php include 'config.php';?>
<!DOCTYPE HTML>
<html lang="pt-BR">
    <head>
        <meta charset=UTF-8>
        <title>Provas</title>
    </head>

    <body>
        <ul>
        <?php
            $provas = $pdo->prepare("SELECT * FROM `provas` WHERE `status` = 1 ORDER BY `id` DESC");
            $provas->execute();

            while ($row = $provas->fetchObject()) {
        ?>
            <li>
                <a href="prova.php?prova=<?php echo $row->id;?>">
                    <?php echo $row->titulo;?>
                </a>
            </li>
        <?php }?>
        </ul>
    </body>
</html>