<?php

$target =  mktime(0, 20, 0, 6, 25, 2017) ;

$today = mktime(0, 40, 0, 6, 25, 2017) ;

$difference =($target-$today) ;

$min =(int) ($difference/60) ;

print "Our event will occur in $min ";

?>

<script type="text/javascript">
	var st= <?php $fe->st; ?>

	var et= <?php $fe->tme; ?>

	document.getElementById("demo").innerHTML = st;
</script>



<!DOCTYPE HTML>
<html>
<head>
<style>
p {
  text-align: center;
  font-size: 60px;
}
</style>
</head>
<body>

<p id="demo"></p>
<p id="countdown"></p>

<script>
function countdown(startTime, endTime) {
    const startDate = new Date(startTime).getTime();
    const endDate = new Date(endTime).getTime();
    const distance = endDate - startDate;

    if (distance <= 0) {
        document.getElementById("countdown").innerHTML = "Temps écoulé";
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("countdown").innerHTML =
        `${days}j ${hours}h ${minutes}m ${seconds}s`;
}

// Exemple : appeler la fonction
countdown('2024-12-20T12:00:00', '2024-12-21T15:00:00');
</script>


</body>
</html>

