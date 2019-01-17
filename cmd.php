<?php
for ($i = 1; $i <= 12; $i++ ){

    $cmd = "php data2.php $i";

    bgExec($cmd);
}

function bgExec($cmd) {
    if(substr(php_uname(), 0, 7) == "Windows"){
        pclose(popen("start ". $cmd, "r"));
    }else {
        exec($cmd . " > /dev/null &");
    }
}