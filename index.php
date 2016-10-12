<?php
//Интерфейс обязательных свойств роботов
interface IRobot {
    function getPower();
    function getOn();
}
//Обобщенный класс для робота
class Robot implements IRobot{
    protected $power = 0;
    protected $on = TRUE;

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

    public function getPower()
    {
        return $this->power;
    }

    public function getOn()
    {
        return $this->on;
    }
}
//Первый робот
class RobotOne extends Robot {
    protected $power = 10;
}
//Второй робот
class RobotTwo extends Robot {
    protected $power = 10;
}
class FactoryBuild {
    protected $robots = array();

    public function make(Robot $robot, $count) {
        if ($count == 0) {
            return 0;
        }

        $robot_power = $robot->getPower();

        for ($i=0; $i < $count; $i++) {
            $robot = new Robot();
            $robot->setPower($robot_power);
            $this->robots[] = $robot;
        }

        return $this->robots;
    }

    public function makeOff(Robot $robot, $off_count) {
        if ($off_count == 0) {
            return 0;
        }

        $robots_count = count($this->robots);
        $new_power = $this->getPower($robot) / ($robots_count - $off_count);

        for ($i=0; $i < $off_count; $i++) {
            $this->robots[$i]->setOff();
        }

        foreach ($this->robots as $factory_robot) {
            if ($factory_robot->getOn()) {
                $factory_robot->setPower($new_power);
            }
        }

        return $this->robots;
    }

    public function getPower(Robot $robot) {
        $factory_power = 0;

        foreach ($this->robots as $robot) {
            $factory_power += ($robot->getOn()) ? $robot->getPower() : 0;
        }

        return $factory_power;
    }
}
$Factory = new FactoryBuild();
$RobotOne = new RobotOne();
$RobotTwo = new RobotTwo();
echo "<pre>";
var_dump($Factory->make($RobotOne, 10));
var_dump($Factory->getPower($RobotOne));
var_dump($Factory->makeOff($RobotOne, 2));
var_dump($Factory->getPower($RobotOne));
var_dump($Factory->make($RobotOne, 5));
var_dump($Factory->getPower($RobotOne));
?>