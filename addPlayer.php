<?php
session_start();
include "classes/autoloader.php";


if(isset($_POST["addPlayer"]))
{
    $player = new Player();
    $player->savePlayer($_SESSION["idGame"],$_POST["nick"]);
    header("Location:game.php");
}