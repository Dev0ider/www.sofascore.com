<?php

$month = $argv[1];

if ($month <= 9 ){
    $month = "0".$month;
}

$day = 86400;

for ($i = 1; $i <= 31; $i++){

    if($i <= 9){
        $i = '0'.$i;
    }

$temp = file_get_contents("https://www.sofascore.com/football//2018-$month-$i/json");
$temp = json_decode($temp, true);

$sportName = $temp['sportItem']['sport']['name'];
$tournamentsArray = $temp['sportItem']['tournaments'];
/*
$currentMonth = $temp['params']['date'];
$currentMonth = explode('-', $currentMonth);
$currentMonth = $currentMonth[1];
*/
$tournamentInfo = [];

    $currentDate = $temp['params']['date'];
    foreach ($tournamentsArray as $tournament) {
        $tournamentName = $tournament['tournament']['name'];
        $homeTeam = $tournament['events'][0]['homeTeam']['name'];
        $awayTeam = $tournament['events'][0]['awayTeam']['name'];
        $tournamentInfo[] = "
            'Date' => $currentDate,
            'tournamentName' => $tournamentName,
            'homeTeam' => $homeTeam,
            'awayTeam' => $awayTeam
        ";
    }

    $date = date_create('2018-'.$month.'-'.$i.'.');

    if (!file_exists('temp/' . date_format($date,'F'))) {
        mkdir('temp/' . date_format($date,'F'));
    }

    file_put_contents('temp/' . date_format($date,'F'). '/' . 'day - '.$i.'.txt', $tournamentInfo);


    //file_put_contents('temp/'.$month.'-'.$i.'.txt', $tournamentInfo);

}
