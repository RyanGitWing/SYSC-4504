<?php
    /* The CHSBL VM G PZ LSLCLU */
    /* The value of z is eleven */
    $drawer_locker = 0;
    $z = 11;
    for ($x = 0; $x < $z; $x++){
        $y = 1;
        while($y <= $x){
            $drawer_locker = $drawer_locker + ($x * $y);
            $y++;
        }
    }
    echo "<h1>This is Riddle1 </h1>";
    echo "<p>The drawer lock code is 1705</p>";
?>