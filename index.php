<?php
include_once('CRobot.php');
include_once('CFactoryBuild.php');

$Factory = new FactoryBuild();
$RobotOne = new RobotOne();
$RobotTwo = new RobotTwo();

echo "<pre>";
echo 'Enable 10 robots with RobotsOne type<br/><br/>';
var_dump($Factory->make($RobotOne, 10));
echo '<br/>Power of robots with RobotsOne type<br/><br/>';
var_dump($Factory->getFactoryPower($RobotOne));
echo '<br/>Unable 2 robots with RobotsOne type<br/><br/>';
var_dump($Factory->makeOff($RobotOne, 2));
echo 'Enable 5 robots with RobotsOne type<br/><br/>';
var_dump($Factory->make($RobotOne, 5));
echo '<br/>Power of robots with RobotsOne type<br/><br/>';
var_dump($Factory->getFactoryPower($RobotOne));
echo '<br/>Unable 2 robots with RobotsTwo type<br/><br/>';
var_dump($Factory->makeOff($RobotTwo, 2));
echo '<br/>Change power to 15 for robots with RobotsTwo type<br/>';
$RobotTwo->setPower(15);
echo '<br/>Enable 2 robots with RobotsTwo type<br/><br/>';
var_dump($Factory->make($RobotTwo, 2));
echo '<br/>Power of robots with RobotsTwo type<br/><br/>';
var_dump($Factory->getFactoryPower($RobotTwo));
?>