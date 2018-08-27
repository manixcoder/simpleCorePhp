 <?php
include('config/config.php');

$result = mysqli_query($con, "SELECT * FROM nationality limit 0,5 ") or die('Could not query');
$emparray = array();
while ($row = mysqli_fetch_assoc($result)) {
    echo $emparray[] = $row['id'] . " " . $row['name'];
    echo "<br>";
}
// paging


$result1 = mysqli_query($con, "SELECT * FROM nationality") or die('Could not query');
$cou = mysqli_num_rows($result1);
$a   = $cou / 5;
echo $a = ceil($a);
echo "<br> <br>";
for ($b = 1; $b <= $a; $b++) {
?><a href="nationality_paging.php?page=<?php
    echo $b;
?>"><?php
    echo $b;
?></a><?php
}





?> 