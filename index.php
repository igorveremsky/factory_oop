<?php
//Интерфейс обязательных свойств роботов
interface IRobot {
    function getPower();
    function getOn();
    function getType();
}
//Обобщенный класс для робота
class Robot implements IRobot{
    public $power = 0;
    public $on = TRUE;
    public $type;

    public function setOn()
    {
        $this->on = TRUE;
    }

    public function setOff()
    {
        $this->on = FALSE;
    }

    public function setPower($robot_power)
    {
        $this->power = $robot_power;
    }

    public function setType($robot_type)
    {
        $this->type = $robot_type;
    }

    public function getPower()
    {
        return $this->power;
    }

    public function getOn()
    {
        return $this->on;
    }

    public function getType()
    {
        return $this->type;
    }
}
//Первый робот
class RobotOne extends Robot {
    public $power = 10;
    public $type = 'machinist';
}
//Второй робот
class RobotTwo extends Robot {
    public $power = 10;
    public $type = 'supervisor';
}
class FactoryBuild {
    protected $robots = array();

    public function make(Robot $robot, $count) {
        if ($count == 0) {
            return 0;
        }

        $robot_power = $robot->getPower();
        $robot_type = $robot->getType();

        for ($i = 0; $i < $count; $i++) {
            $robot = new Robot();
            $robot->setPower($robot_power);
            $robot->setType($robot_type);
            $this->robots[] = $robot;
        }

        return $this->robots;
    }

    public function makeOff(Robot $robot, $to_off_count) {
        if ($to_off_count == 0) {
            return 0;
        }

        $same_type_on_robots = $this->filterByType($robot, TRUE);

        if (empty($same_type_on_robots)) {
            return 'No ON robots with this type';
        }

        $same_type_robots = $this->filterByType($robot);

        $off_count = count($same_type_robots) - count($same_type_on_robots);
        $new_power = $this->getFactoryPower($robot) / (count($same_type_on_robots) - $to_off_count);

        for ($i = $off_count; $i < $off_count + $to_off_count; $i++) {
            $same_type_on_robots[$i]->setOff();
        }

        $on_robots_after_off = $this->filterByType($robot, TRUE);

        foreach ($on_robots_after_off as $factory_robot) {
            $factory_robot->setPower($new_power);
        }

        return $this->robots;
    }

    public function getFactoryPower(Robot $robot) {
        $factory_power = 0;
        $same_type_on_robots = $this->filterByType($robot, TRUE);

        foreach ($same_type_on_robots as $factory_robot) {
            $factory_power += $factory_robot->getPower();
        }

        return $factory_power;
    }

    protected function filterByType(Robot $robot, $only_on = false) {
        $robot_type = $robot->getType();
        $filter_robots = array();

        foreach ($this->robots as $factory_robot) {
            if ($only_on && !$factory_robot->getOn()) continue;
            if ($factory_robot->getType() == $robot_type) {
                $filter_robots[] = $factory_robot;
            }
        }

        return $filter_robots;
    }
}
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
echo '<br/>Unable 2 robots with RobotsTwo type<br/><br/>';
var_dump($Factory->makeOff($RobotTwo, 2));
echo '<br/>Change power to 15 for robots with RobotsTwo type<br/>';
$RobotTwo->setPower(15);
echo '<br/>Enable 2 robots with RobotsTwo type<br/><br/>';
var_dump($Factory->make($RobotTwo, 2));
echo '<br/>Power of robots with RobotsTwo type<br/><br/>';
var_dump($Factory->getFactoryPower($RobotTwo));
?>