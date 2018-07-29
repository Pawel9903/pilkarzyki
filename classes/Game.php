<?php
/**
 * Created by PhpStorm.
 * User: pawel9903
 * Date: 26.07.18
 * Time: 11:30
 */

class Game
{
    private $pdo;


    public function __construct()
    {
        $this->pdo = Db::getInstance()->getDb();
    }

    public function newGame()
    {
        $datetime = new DateTime("now");
        $nowDate = $datetime->format('Y-m-d');
        $query = $this->pdo->prepare("INSERT INTO game (dateTime) VALUES (:dateTime)");
        $query->bindParam(':dateTime',$nowDate);
        $query->execute();
    }
    public function getIdNewGame()
    {
        $query = $this->pdo->query("SELECT * FROM game ORDER BY id_game DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        return $query;
    }

    public function combinations(array $array, array $returnArray = null)
    {
        $size = sizeof($array);

        for($i=0; $i < $size; $i++)
        {

            for ($j = 0; $j < $size; $j++)
            {
                if($i != $j && !array_search("{$array[$j]}+{$array[$i]}", $returnArray) && !array_search("{$array[$i]}+{$array[$j]}", $returnArray))
                {
                    $returnArray[] = "{$array[$i]}+{$array[$j]}";
                };
            }
        }
        return $returnArray;
    }

    public function showCombinations(array $array)
    {
        $max = sizeof($array) - 1;
        for ($i = 0; $i < $max; $i++ )
        {
            for($j = 0; $j < $max; $j++)
            {
                $firstTwo = explode("+", $array[$i]);
                $secondTwo = explode("+", $array[$j]);

                if($firstTwo[0] != $secondTwo[0] && $firstTwo[0] != $secondTwo[1] && $firstTwo[1] != $secondTwo[0] && $firstTwo[1] != $secondTwo[1])
                {
                    echo "<p>{$array[$i]} vs {$array[$j]}</p>";
                }
            }
            echo "<br>";
        }
    }

    public function showCombinationsAndSaveScore2(array $array, array $score)
    {
        $max = sizeof($array)-1;

        $min = 0;

        while ($array[$max] != $array[$min] )
        {
            $firstTwo = explode("+", $array[$min]);
            $secondTwo = explode("+", $array[$max]);

            $scoreSame = explode("-", $score[$min]);

            echo "<p>{$array[$min]} vs {$array[$max]} | $score[$min] - $score[$max]</p>";

            if(intval($scoreSame[0]) > intval($scoreSame[1]))
            {
                $winner = $firstTwo[0];
                $winner2 = $firstTwo[1];
            }else{
                $winner = $secondTwo[0];
                $winner2 = $secondTwo[1];
            }

            $this->updateScore($winner,$winner2);

            $max --;
            $min ++;
        }

    }

    public function randomScore(array $array)
    {
        $match = [];
        $size = sizeof($array);
        for ($i = 0; $i < $size; $i++)
        {

            do{
                $left = rand(0,10);
                $right = rand(0,10);
            }while($left == $right);

            $match[$i] = "{$left}-{$right}";
        }
        return $match;
    }

    public function updateScore(string $winner, string $winner2)
    {
        $query = $this->pdo->prepare("UPDATE user SET score = score+1 WHERE 'id_game' = :id_game AND nick = :nick OR  nick = :nick2");
        $query->bindParam(":id_game", $_SESSION['idGame']);
        $query->bindParam(":nick", $winner);
        $query->bindParam(":nick2", $winner2);
        $query->execute();
    }

}