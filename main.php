<!DOCTYPE html>

<?php 
    session_start();
    include 'make.php';
    //$a = make($a);
    if(!isset($_SESSION['a']))
        make();
    $a = $_SESSION['a'];
?>


<html>
<head>
  <link rel="stylesheet" href="./style/run.css">
    <script 
        type="text/javascript"
        src="jquery-3.6.0.js" >
        
    </script>

</head>




<body>

    <div class="content" id="content">
        <div > 
            <input type="submit" id="reset" value="No move avaible? Suffer!"> </input>
            <input type="submit" id="reload" value="New game"> </input>
            <input type="submit" id="autoWin" value="Win?"> </input>
        </div>
        <div id="nani"> 
        <table id="table_c">
            <?php   //echo $_SESSION['b'];
                global $a;
                $a = $_SESSION['a'];
                for($i = 2; $i < 11; $i++) {      ?>
            <tr>                
                <?php  
                for($j = 2; $j < 18; $j++) {
                    $xx = $a[$i][$j];
                    $link = "./pokemon/$xx.jpg";
                    //echo $link." ";
                    $index = ($i - 1) * 18 + $j;?>

                    <td id="the<?php echo $index; ?>">
                        <input type="checkbox" class="chbox" id="<?php echo $index; ?>" />
                        <label for="<?php echo $index; ?>">
                            <img style="display:block;" src="<?php echo $link;?>" id="img<?php echo $index; ?>"/>
                        </label>
                    </td>
                <?php   if($xx == 0) { ?>
                            <script>
                                document.getElementById("the<?php echo $index; ?>").style.visibility="hidden";
                            </script>
                        <?php }
                }//echo "<br>";
                }?>
            </tr>
    </table>
    <div id="test"> </div>


        </div>
    </div>

    <div id="what">  </div>

</body>
</html>



<script type="text/javascript">

    $(document).ready(function() {
        //$("#nani").load("content.php");

        $("#reset").click(function() {
            //location.reload();
            $.ajax({
                type: "get",
                url: "reset.php",
                async: false,
                data :{ click: 'reset'},
                success: function(data) {
                    //$("#what").html(data);
                    //$("#content").load(location.href+" #content");
                    $("#content").load(location.href+"#content");
                    //location.reload();
                }
            });
        });

        $("#reload").click(function() {
            $.ajax({
                type: "get",
                url: "reset.php",
                async: false,
                data :{ click: 'reload'},
                success: function(data) {
                    location.reload();
                }
            });
            
        });

        $("#autoWin").click(function () {
            $.ajax({
                type: "get",
                url: "reset.php",
                async: false,
                data :{ click: 'autoWin'},
                success: function(data) {
                    alert("Game cleared!");
                    location.reload();
                }
            });
        });
    });
</script>

<script>
        var x;
        var c = 0;
        var a, b;
        $("input:checkbox").change(function () {
            //$(this).css('border-color', 'lime');
            c++;
            if(c == 1) 
                //{
                a = $(this).attr('id');//alert(a);}

            if(c == 2) {
                b = $(this).attr('id');
                //if(a >= 20 && a <= 179) alert(a);
                if(a == b) c = 0;
                else {
                    $.ajax({
                        type : "get",
                        url: "run.php",
                        async: false,
                        data : {
                            c1: a,
                            c2: b
                        },
                        success: function (data) {
                            x = data;
                            $("#test").html(data);
                        }
                    });
                    
                    //alert(x);
                    if(x <= 0) {
                        $("#"+a).prop("checked", false);
                        $("#"+b).prop("checked", false);

                    }
                    else {
                        document.getElementById("the"+a).style.visibility="hidden";
                        document.getElementById("the"+b).style.visibility="hidden";
                        if(x == 2) {
                            alert("Game complete");
                            $.ajax({
                                type: "get",
                                url: "reset.php",
                                async: false,
                                data :{ click: 'reload'},
                                success: function(data) {
                                    location.reload();
                                }
                            });
                        }
                    }
                    c = 0;
                }
            }
        });
</script>