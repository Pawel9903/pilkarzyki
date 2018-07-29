<?php
session_start();
include "classes/autoloader.php";

if(!isset($_POST['newGame']))
{
    header("Location:index.php");
}else{
    $game = new Game();
    $game->newGame();
    $gameId = $game->getIdNewGame();
    $_SESSION["idGame"] = intval($gameId["id_game"]);
    header("Location:game.php");
}