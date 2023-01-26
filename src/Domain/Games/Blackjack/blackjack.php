<?php

namespace Casino\Domain\Games\Blackjack;

$cards = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 'V', 'D', 'R'];

/**
 * Renvoie une carte aléatoire parmi $cards
 */
function drawCard(array $cards) //: int|string
{
    $numberOfCards = count($cards);
    $drawCardIndex = rand(0, $numberOfCards - 1);
    return $cards[$drawCardIndex];
}

$cardPlayer1 = drawCard($cards);
$cardPlayer2 = drawCard($cards);
$cardBank1 = drawCard($cards);
$cardBank2 = drawCard($cards);

echo "Cartes tirées pour le joueur : " . $cardPlayer1 . " + " . $cardPlayer2 . "\n";

/**
 * Renvoie la valeur associée à une carte de black jack
 * 
 * ex: Roi vaut 10
 */
function getCardValue($card): int
{
    return gettype($card) === "string" ? 10 : $card;
}

/**
 * Si la valeur total du tableau est inférieure à 17 alors on rajoute une valeur à la main de la banque
 * 
 */
function completeBankHand(array $bankHand, array $tableCards): array
{
    if (array_sum($bankHand) < 17) { // si la somme du tablea est inférieure à 17.
        $pickCard = getCardValue(drawCard($tableCards));
        array_push($bankHand, $pickCard); // Alors le tableau reçevra un index supplémentaire.
        return completeBankHand($bankHand, $tableCards); // fonction récursive.
    } else {
        return $bankHand;
    }
}

$totalPlayer = getCardValue($cardPlayer1) + getCardValue($cardPlayer2);

echo "Total joueur : " . $totalPlayer . "\n";

echo "Cartes tirées pour la banque : " . $cardBank1 . " + " . $cardBank2 . "\n";

$totalBank = getCardValue($cardBank1) + getCardValue($cardBank2);

echo "Total banque : " . $totalBank . "\n";

echo ($totalBank > $totalPlayer) ? "La banque a gagné.\n" : "Le joueur a gagné.\n";
