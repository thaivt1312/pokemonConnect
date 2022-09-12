<?php 
    //session_start();
    class Element {
        public int  $value;
        public ?Element $next = null;
        // public function __construct()  {
        //     $this->next = new Element();
        // }
    };

    //

    class vector {
        public int $size;
        public ?Element $first;
        public ?Element $last;

        public function __construct()        {
            $this->size = 0;
            $this->first = new Element();
            $this->last = $this->first;
        }
        
        function push(int $value)
        {
            $now = new Element();
            $now->value = $value;
            //$now->next = null;
            if($this->size == 0)
            {
                $this->first = $now;
                $this->last = $now;
            }
            else
            $this->last->next = $now;
            $this->last = $now;
            $this->size++;
        }

        function findByIndex(int $index) { /// return value in vector[index]
            if($index == 0 || $index > $this->size) return null;
            if($index == 1) return $this->first;
            if($index == $this->size) return $this->last;
            $now = $this->first;
            $count = 1;
            while(1)
            {
                if($count == $index) break;
                $now = $now->next;
                $count++;
            }
            return $now;
        }

        function findByVal($value) { /// return list of index found in vector
            $now = $this->first;
            $res = Array();
            //$count = 1;
            for($count = 1; $count <= $this->size; $count++)
            {
                if($now->value == $value) $res[] = $count;
                $now = $now->next;
            }
            return $res;
        }

        function eraseByVal($value)
        {
            
        }

        function eraseByIndex($index)  {
            if($index == 1)
                {
                    $this->first = $this->first->next;
                    $this->size--;
                    return;
                }
            if($index == $this->size)
                {
                    $now = $this->findByIndex($index - 1);
                    $this->last = $now;
                    $this->size--;
                    return;
                }
            $before = $this->findByIndex($index - 1);
            $now = $before->next;
            $before->next = $now->next;
            $this->size--;
        }
    }
?>



<?php

    function make() {
        $vt = new vector();
        $s = rand(1,35);
        $vt->push($s);
        $vt->push($s);
        $s = rand(1,35);
        $vt->push($s);
        $vt->push($s);
        for($i = 1; $i <= 35; $i++)    {
            for($j = 1; $j <= 4; $j++)
                $vt->push($i);
        }
        //$vt->push(12);
        for($i = 1; $i <= 11; $i++){
            for($j = 1; $j <= 18; $j++) {
                if($i ==1 || $j == 1 || $i == 11 || $j == 18) {$a[$i][$j] = 0; continue;}
                $x = rand(1, $vt->size);
                $now = new Element();
                $now = $vt->findByIndex($x);
                $a[$i][$j] = $now->value;
                $vt->eraseByIndex($x);
            }
        }
        //echo "size: ".$vt->size."<br>";
        return $_SESSION['a'] = $a;
    }

    function suffer($a) {
        $vt = new vector();

        for($i = 2; $i < 11; $i++){
            for($j = 2; $j < 18; $j++) {
                echo $a[$i][$j]." ";
                if($a[$i][$j] == 0) continue;
                $vt->push($a[$i][$j]);
            }echo "<br>";
        }

        for($i = 2; $i < 11; $i++){
            for($j = 2; $j < 18; $j++) {
                if($a[$i][$j] == 0) continue;
                $x = rand(1, $vt->size);
                $now = new Element();
                $now = $vt->findByIndex($x);
                $a[$i][$j] = $now->value;
                $vt->eraseByIndex($x);
            }
        }
        return $_SESSION['a'] = $a;
    }

?>





