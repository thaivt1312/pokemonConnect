<?php
    session_start();
    include 'make.php';
    if($_REQUEST['click']) {
        $now = $_REQUEST['click'];
        echo $now."<br>";
        $a = $_SESSION['a'];
        // for($i = 1; $i <= 11; $i++){
        //     for($j = 1; $j <= 18; $j++) {
        //         echo $a[$i][$j]." ";
        //     }echo "<br>";
        // }echo "////////////////////////////////<br>";

        if($now == 'reset') {
            //$a = $_SESSION['a'];
            $a = suffer($a);
            echo "<br>";
            //echo 'reseted!';
            for($i = 2; $i < 11; $i++){
                for($j = 2; $j < 18; $j++) {
                    echo $a[$i][$j]." ";
                }echo "<br>";
            }
            $_SESSION['a'] = $a;
            $_SESSION['b'] = 'yes';
        }
        if($now == 'reload') {
            unset($_SESSION['a']);
        }

        if($now == 'autoWin') {
            for($i = 2; $i < 11; $i++){
                for($j = 2; $j < 18; $j++) {
                    $a[$i][$j] = 0;
                }//echo "<br>";
            }
            unset($_SESSION['a']);
        }
    }
?>