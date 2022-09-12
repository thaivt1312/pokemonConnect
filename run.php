<?php
    class point {
        public int $x;
        public int $y;
        public function make($x, $y) {
            $this->x = $x;
            $this->y = $y;
        }
    };
?>

<?php
    session_start();
    //$i = 0;
    if($_REQUEST['c1']) {
        $c1 = $_REQUEST['c1'];
        $i1 = (int)($c1 / 18) + 1;
        $j1 = $c1 % 18;
    }

    if($_REQUEST['c2']) {
        $c2 = $_REQUEST['c2'];
        $i2 = (int)($c2 / 18) + 1;
        $j2 = $c2 % 18;
    }
    if(isset($_SESSION['a'])) {
        $a = $_SESSION['a'];
    }

    if($a[$i1][$j1] == $a[$i2][$j2]) {
        $p1 = new point();
        $p1->make($i1, $j1);
        $p2 = new point();
        $p2->make($i2, $j2);
        if(check($p1, $p2) == true) {
            $a[$i1][$j1] = 0;
            $a[$i2][$j2] = 0;
            echo checkAll();
           // echo 1;
        }
        else
            echo 0;
    }
    else echo -1;
    $_SESSION['a'] = $a;
?>

<?php
    function checkLineX(int $y1, int $y2, int $x) {
        $max = max($y1, $y2);
        $min = min($y1, $y2);
        global $a;
        for($i = $min + 1; $i < $max; $i++) {
            if($a[$x][$i] != 0) {
                return false;
            }
        }
        return true;
    }

    function checkLineY(int $x1, int $x2, int $y) {
        $max = max($x1, $x2);
        $min = min($x1, $x2);
        global $a;
        for($i = $min + 1 ; $i < $max; $i++) {
            if($a[$i][$y] != 0) {
                return false;
            }
        }
        return true;
    }

    function checkRectX(point $p1, point $p2) {
        $min = new point();
        $max = new point();
        if($p1->y > $p2->y) {
            $min = $p2;
            $max = $p1;
        }
        else {
            $min = $p1;
            $max = $p2;
        }
        global $a;
        for($i = $min->y; $i <= $max->y; $i++ ) {
            if($i > $min->y && $a[$min->x][$i] != 0) return false;
            if( $a[$max->x][$i] == 0 && checkLineY($min->x, $max->x, $i) && checkLineX($i, $max->y, $max->x))
                return true;
        }
        return false;
    }

    function checkRectY(point $p1, point $p2) {
        $min = new point();
        $max = new point();
        if($p1->x > $p2->x) {
            $min = $p2;
            $max = $p1;
        }
        else {
            $min = $p1;
            $max = $p2;
        }
        global $a;
        for($i = $min->x; $i <= $max->x; $i++ ) {
            if($i > $min->x && $a[$i][$min->y] != 0) return false;
            if( $a[$i][$max->y] == 0 && checkLineX($min->y, $max->y, $i) && checkLineY($i, $max->x, $max->y))
                return true;
        }
        return false;
    }

    function checkMoreX(point $p1, point $p2, int $type) {
        if($p1->y > $p2->y) {
            $min = $p2;
            $max = $p1;
        }
        else {
            $min = $p1;
            $max = $p2;
        }
        $y = $max->y + $type;
        $row = $min->x;
        $colFin = $max->y;
        if($type == -1) {
            $colFin = $min->y;
            $y = $min->y + $type;
            $row = $max->x;
        }
        global $a;
        if( ($a[$row][$colFin] == 0 || $min->y == $max->y) 
            && checkLineX($min->y, $max->y, $row) ) {
                while($a[$min->x][$y] == 0 && $a[$max->x][$y] == 0) {
                    if(checkLineY($min->x, $max->x, $y))    return true;
                    $y += $type;
                }
            }
        return false;
    }

    function checkMoreY(point $p1, point $p2, int $type) {
        if($p1->x > $p2->x) {
            $min = $p2;
            $max = $p1;
        }
        else {
            $min = $p1;
            $max = $p2;
        }
        $x = $max->x + $type;
        $col = $min->y;
        $rowFin = $max->x;
        if($type == -1) {
            $rowFin = $min->x;
            $x = $min->x + $type;
            $col = $max->y;
        }
        global $a;
        if( ($a[$rowFin][$col] == 0 || $min->x == $max->x) 
            && checkLineY($min->x, $max->x, $col) ) {
                while($a[$x][$min->y] == 0 && $a[$x][$max->y] == 0) {
                    if(checkLineX($min->y, $max->y, $x))    return true;
                    $x += $type;
                }
            }
        return false;
    }

    function check(point $p1, point $p2) {
        $x = $p1->x;
        $y = $p1->y;
        $_x = $p2->x;
        $_y = $p2->y;
        if($x == $_x) {
            $res = checkLineX($y, $_y, $x);
            if($res == true) return true;
        }
        if($y == $_y) {
            $res = checkLineY($x, $_x, $y);
            if($res == true) return true;
        }

        if(checkRectX($p1, $p2))    return true;
        if(checkRectY($p1, $p2))    return true;
        if(checkMoreX($p1, $p2, -1))    return true;
        if(checkMoreX($p1, $p2, 1))    return true;
        if(checkMoreY($p1, $p2, -1))    return true;
        if(checkMoreY($p1, $p2, 1))    return true;
        return false;
    }

    function checkAll() {
        global $a;
        $res = 2;
        for($i = 2; $i < 11; $i++) {
            for($j = 2; $j < 18; $j++) {
                if($a[$i][$j] != 0){ 
                    $res = 1;
                    break;
                }
            }
        }
        return $res;
    }
?>