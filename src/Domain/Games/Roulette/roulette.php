<?php

declare(strict_types=1);

namespace Casino\Domain\Games\Roulette;

require_once(__DIR__ . "/../../../../include.php");

use Casino\Domain\Common;
use Casino\Views;

/**
 * Détermine si le nombre parié est égal au 
 * nombre tiré au sort.
 */
function roulette(int $nombreGagnant, string $nombrePari): bool
{
    $isEven = Common\isEven($nombreGagnant);

    // echo "\nEst-il pair ? " . ($isOdd ? 'Non' : 'Oui');

    // echo "\nPari parité utilisateur : " . $pariPair;

    $gagneNombre = intval($nombrePari) === $nombreGagnant;
    /* 
    // "pair" === 0
    // 1. CAS 1
    $pariPairInt = $pariPair === 'pair' ? 0 : 1;
    $gagneParite = $pariPairInt === $isOdd;

    // 2. CAS 2
    $isOddString = $isOdd === 0 ? 'pair' : 'impair';
    $gagneParite = $pariPair === $isOddString;

    // 3. CAS 3
    $isOddBool = $isOdd === 0 ? false : true;
    $pariPairBool = $pariPair === 'pair' ? false : true;
    $gagneParite = $pariPairBool === $isOddBool;

 */
    // echo "\nUtilisateur a gagné pari 'parité' ? " . ($gagneParite ? "OUI !!!" : "NON BOUH!");

    return $gagneNombre;
}

function generateRandomRouletteNumber(): int
{
    return rand(0, 36);
}

/**
 * @todo namespace Casino\Input\UserInput
 */
function getUserBetInput($inputArgs): string
{
    if (count($inputArgs) < 2) {
        Views\printBetArgError();
        exit(); // Quitte le script sans attendre la fin !!
    }
    $bet = $inputArgs[1];

    return $bet;
}

function getUserParityBetInput($inputArgs): string
{
    // Vérifie que l'input est rempli, et termine
    // le programme si non.
    if (count($inputArgs) < 3) {
        Views\printParityArgError();
        exit();
    }
    return $inputArgs[2];
}

/**
 * 1ère implémentation de la fonction getColor.
 * Cette implémentation n'est pas exacte et devrait FAIRE PLANTER vos tests
 */
function getColorShouldFail(int $number): string
{
    if ($number === 0) return 'aucune'; // attention syntaxe raccourcie du if !

    $numbers = str_split('' . $number); // on découpe le nombre en chiffres (ex: 12 => [1, 2]
    $sum = array_sum($numbers);
    if ($sum > 9) {
        // On continue tant que le résultat n'est pas un nombre à un seul chiffre
        return getColorShouldFail($sum);
    } elseif (Common\isEven($sum)) { // Si la somme des chiffres est paire : noir
        return 'noir';
    } else { // Si la somme des chiffres est impaire : rouge
        return 'rouge';
    }
}

/**
 * Version finale de getColor qui fonctionne.
 * Vos tests devraient passer au vert.
 */
function getColor(int $number): string
{
    if ($number === 0) return 'aucune'; // attention syntaxe raccourcie du if !

    // Gestion des 2 cas particuliers :
    if (in_array($number, [10, 28])) return 'black';
    if ($number === 19) return 'red'; // sa somme fait 10 donc cela poserait pb sans ce cas particulier

    $numbers = str_split('' . $number); // on découpe le nombre en chiffres (ex: 12 => [1, 2]
    $sum = array_sum($numbers);
    if ($sum > 9) {
        // On continue tant que le résultat n'est pas un nombre à un seul chiffre
        return getColor($sum);
    } elseif (Common\isEven($sum)) { // Si la somme des chiffres est paire : noir
        return 'black';
    } else { // Si la somme des chiffres est impaire : rouge
        return 'red';
    }
}


if ($argv[0] === "roulette.php") {
    $nombreAleatoire = generateRandomRouletteNumber();
    $pariUtilisateur = getUserBetInput($argv);

    Views\printUserArgs($nombreAleatoire, $pariUtilisateur);

    if (!empty($pariUtilisateur)) {
        $res = roulette($nombreAleatoire, $pariUtilisateur);
        Views\printBetResult($res);
    }
}
// $pariPair = $argv[2];
