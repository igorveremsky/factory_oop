<?php
//Интерфейс обязательных свойств роботов
interface IRobot {
    function getPower();
}
//Обобщенный класс для робота
class Robot implements IRobot{
    protected $power = 0;

    public function setPower($robot_power)
    {
        $this->power = $robot_power;
    }

    public function getPower()
    {
        return $this->power;
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
    public $power;

    public function createRobotOne($count){
        return $this->createElement('RobotOne', $count);
    }
    public function createRobotTwo($count){
        return $this->createElement('RobotTwo', $count);
    }
    protected function createElement($name, $count){
        $result = [];
        for($i=0; $i<$count; $i++){
            $result[] = new $name;
        }
        return $result;
    }
    public function make(Robot $robot, $count) {
        if ($count == 0) {
            return 0;
        }

        for($i=0; $i<$count; $i++){
            $this->robots[] = $robot;
        }

        foreach ($this->robots as $robot) {
            $this->power = $this->power + $robot->getPower();
        }

        return $this->robots;
    }

    public function makeOff(Robot $robot, $count) {
        if ($count == 0) {
            return 0;
        }

        $robots_count = count($this->robots);

        $robot->setPower($this->power/($robots_count-$count));

        array_splice($this->robots, 0, 2);

        return $this->robots;
    }

    public function getPower(Robot $robot) {
        return $this->power;
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
?>