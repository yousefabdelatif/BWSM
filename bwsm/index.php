<?php
 session_start();


require "controller\Appcontroller.php" ;

$_SERVER["REQUEST_METHOD"] = 'POST';
error_reporting(E_ALL ^ E_WARNING); 

 $Appcontroller = new AppController("localhost:3307",'root','');

/*
$query = 'SELECT * FROM bwsm';
$query2 = 'SELECT PASSWORD FROM bwsm WHERE EMAIL = "yousefadbelatif@gmail.com"';

$stmt = $dp->prepare($query);
$stmt2 = $dp->prepare($query2);

$stmt->execute();
$stmt2->execute();
echo "<pre>";
var_dump($stmt->fetchAll(PDO::FETCH_OBJ));
var_dump($stmt2->fetchAll(PDO::FETCH_OBJ));
echo "</pre>";

$passs = "yousefabdeltatif";
$oy = password_hash($passs,PASSWORD_DEFAULT);
$ox = password_verify($_POST['fname'],"$2y$10$8HBB9Xr5jCAwhIDxC7rd5eqr8ChLpRhHcLpmvno23f4QC0teKZy3y");
echo ($oy);
if($ox)
{
  echo ("goooooood");

} else {
  echo "baddd";};
//echo $oy;
*/


$Appcontroller->Run();

