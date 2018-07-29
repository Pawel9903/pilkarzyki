<?php
session_start();

if(!$_SESSION["idGame"]){header("Location:index.php");}

include "classes/autoloader.php";
include "view/templates/top.php";

$player = new Player();
$game = new Game();
$players = $player->getAllPlayersNickByGame($_SESSION["idGame"]);
$countPlayers = $player->getCountPlayersByGame($_SESSION["idGame"]);
?>

<div class="container">

<form class="my-5" action="addPlayer.php" method="post">
    <div class="form-group">
        <label for="nick">Podaj Nick gracza</label>
        <input class="form-control" placeholder="Nick" name="nick">
    </div>
    <button type="submit" class="btn btn-primary" name="addPlayer">Dodaj</button>
</form>

<h4>Lista graczy</h4>
    <ul>
        <?php
        if($players)
        {
            foreach ($players as $player)
            {
                echo "<li>{$player['nick']}</li>";
                $arrayPlayers[] =  $player["nick"];
            }
        }else
        {
            echo "<p>Nie ma żadnych graczy</p>";
        }

        ?>
    </ul>

    <?php if($countPlayers < 4 || $countPlayers%2 != 0 || $countPlayers == 0):?>
            <h5>ilość graczy musi być parzysta i co najmniej 4</h5>
        <?php else: ?>
            <form method='post'>
            <button class='btn btn-primary' name='start'>Zacznij Gre</button>
            </form>
        <?php endif ?>

    <?php if(isset($_POST["start"] )): ?>
</div>
    <div class="container py-5">

        <h4>Wszystkie kombinacje</h4>
        <?php
            $score = $game->randomScore($arrayPlayers);
            $twoArray = $game->combinations($arrayPlayers);
            $game->showCombinationsAndSaveScore2($twoArray, $score);

        if($players)
        {
            foreach ($players as $player)
            {
                echo "<li>punkty: {$player['score']} nick: {$player['nick']}</li>";
            }
        }
        ?>
    <?php endif; ?>
    </div>




