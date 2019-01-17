<?php
$month = $argv[1];
$year = '2018';

function countOfMonth($year, $month){
    $data = $year."-".$month;
    $unixtime = strtotime($data);
    $countOfMonth = date('t', $unixtime);

    return $countOfMonth;
}

function yearMonth($year, $month){
    $data = $year."-".$month;
    $unixtime = strtotime($data);
    $yearMonth = date("Y-m", $unixtime);

    return $yearMonth;
}
/*
$timestamp = $year."-".$month;
$unixtime = strtotime($timestamp);
$firstDay = date('Y-m-01', $unixtime);
*/

$yearMonth = yearMonth($year, $month);
$monthCount = countOfMonth($year, $month);

for ($i = 1; $i <= $monthCount; $i++){

    if($i <= 9){
        $i = '0'.$i;
    }

    $temp = file_get_contents("https://www.sofascore.com/football//$yearMonth-$i/json");
    $temp = json_decode($temp, true);

    $sportName = $temp['sportItem']['sport']['name'];
    $tournamentsArray = $temp['sportItem']['tournaments'];
    $currentDate = $temp['params']['date'];
    $tournamentInfo = [];

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

    if(file_exists('temp/'.$year)){

        if (!file_exists('temp/'.$year.'/'. date_format($date,'F'))) {

            mkdir('temp/'.$year.'/'. date_format($date,'F'));
        }
        file_put_contents('temp/'.$year.'/' . date_format($date,'F'). '/' . 'day - '.$i.'.txt', $tournamentInfo);

}else{
        mkdir('temp/'.$year);
        if (!file_exists('temp/'.$year.'/'. date_format($date,'F'))) {

            mkdir('temp/'.$year.'/'. date_format($date,'F'));
        }
        file_put_contents('temp/'.$year.'/' . date_format($date,'F'). '/' . 'day - '.$i.'.txt', $tournamentInfo);
    }
}
