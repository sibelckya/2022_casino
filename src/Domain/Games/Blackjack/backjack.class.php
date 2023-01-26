<?php

namespace Casino\Domain\Games\Blackjack;

class Blackjack{

    private $players;

    public function play()
    {
        print_r($this->players);
    }
}

//processeur d'instanciation
//$blackjack est une instance de blackjack

$blackjack = new Blackjack();