<?php

include 'classes/Team.php';
include 'classes/Slot.php';
include 'classes/Match.php';
include 'classes/Round.php';
include 'classes/Tournament.php';

//Generate an array of teams
$bracketStr = file_get_contents('brackets.txt');

$teams = array();
$rawTeams = explode("\n", $bracketStr);
foreach ($rawTeams as $teamStr) {
    list($rank, $name) = explode(",", $teamStr);
    $team = new Team($rank, $name);
    $teams[] =$team;
}

//Create a sample match
$match = new Match();

//Assign teams to the match
$match->getSlot(0)->setTeam($teams[0]);
$match->getSlot(1)->setTeam($teams[1]);

echo "<pre>";
print_r($match);
echo "</pre>";

//Play the match
$winner = $match->play();

//Output the winner
echo "The winner is ".$winner->getName();