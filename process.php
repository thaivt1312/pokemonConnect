<?php
    session_start();
    $i = 0;
    if($_REQUEST['c1']) {
        $c1 = $_REQUEST['c1'];
        echo $c1."<br>"."<br>";
        $i1 = (int)($c1 / 18) + 1;
        $j1 = $c1 % 18;
        echo $i1." ".$j1."<br><br>";
        //$i++;
    }

    if($_REQUEST['c2']) {
        $c2 = $_REQUEST['c2'];
        echo $c2."<br>"."<br>";
        $i2 = (int)($c2 / 18) + 1;
        $j2 = $c2 % 18;
        echo $i2." ".$j2."<br><br>";
        //$i++;
    }

    if(isset($_SESSION['a'])) {
        $a = $_SESSION['a'];
        echo $a[$i1][$j1]." ".$a[$i2][$j2]."<br>";
    }
    //$_SESSION['now'];
    //session_unset($_SESSION['now']);
    //unset($_SESSION['now']);
    if(isset($_GET['now'])) unset($_GET['now']);
    $same = 'same';
    $diff = 'diff';
    
    if($a[$i1][$j1] == $a[$i2][$j2]) $_GET['now'] = $same;
    else $_GET['now'] = $diff;
    // json_encode($_SESSION['now']);
    // setcookie($now, "same");

    echo $_GET['now']."<br>";



    ///////////////////////////////////////////////////////////////////////////////

    for($i = 1; $i <= 20; $i++)   //// lập mảng memo
        for($j = 1; $j <= 20; $j++)
            $memo[$i][$j] = -1;

    for($i = 1; $i <= 11; $i++) {   //// in thử mảng a
        for($j = 1; $j <= 18; $j++) {
            echo $a[$i][$j]." ";
        }echo "<br>";
    }echo "///////////////<br>";

    $memo[$i1][$j1] = 0;
    //echo run($i1, $j1, 0, -1)."<br>///<br>";   /// chạy
    //echo "<br>aa".$memo[2][2]."<br>";

    for($i = 1; $i <= 11; $i++) {   /// in kết quả mảng memo
        for($j = 1; $j <= 18; $j++) {
            echo $memo[$i][$j]." ";
        }echo "<br>";
    }

?>


<?php 
    function run(int $s1, int $s2, int $change, int $last){
        global $i2, $j2;
        global $memo;
        if($change > 2) return 0;
        if($s1 == $i2 && $s2 == $j2 && $change < 3) return 1;
        //if($memo[$s1][$s2] != -1) return $memo[$s1][$s2];
        global $a;
        $dx = array(1 => -1, 
                    2 => 0,
                    3 => 1, 
                    4 => 0);
        $dy = array(1 => 0, 
                    2 => -1, 
                    3 => 0, 
                    4 => 1);
        $res = 0;
        for($i = 1; $i <= 4; $i++)        {
            //global $dx, $dy;
            //echo $i."<br>";
            $x = $s1 + $dx[$i];
            $y = $s2 + $dy[$i];
            echo $x." ".$y."<br><br>";
            //$n = $a[$x][$y];
            if($memo[$x][$y] != -1) continue;
            if($x <= 0 || $y <= 0 || $x > 11 || $y > 18 || $a[$x][$y] != 0 || ($a[$x][$y] == $a[$i2][$j2] && $x != $i2 && $y != $j2)  )
                continue;
            //echo $s1." ".$s2."    ".$x." ".$y."<br>";
            $memo[$x][$y] = 0;
            if($last == -1) {
                //global $res1;
                $res = max($res, run($x, $y, 0, $i) );
            }
            else {
                if($i != $last) 
                    $res = max($res, run($x, $y, $change + 1, $i) );
                else 
                    $res = max($res, run($x, $y, $change, $i) );
            }
            return $res;
        }
    }
?>