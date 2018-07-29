<?php

class Player
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Db::getInstance()->getDb();
    }

    public function getAllPlayersNickByGame(int $id_game)
    {
        $query = $this->pdo->query("SELECT * FROM user WHERE id_game ={$id_game} ORDER BY score DESC ")->fetchAll(PDO::FETCH_ASSOC);
        return $query;
    }

    public function getCountPlayersByGame(int $id_game)
    {
        $query = $this->pdo->query("SELECT count(*) FROM user WHERE id_game ={$id_game}")->fetchColumn();
        return intval($query);
    }

    public function savePlayer(int $id_game, string $nick)
    {
        $query = $this->pdo->prepare("INSERT INTO user (nick, id_game) VALUES (:nick, :id_game)");
        $query->bindParam(":nick", $nick);
        $query->bindParam(":id_game",$id_game);
        $query->execute();
    }

}