<?php
/**
 * Interface IRobot
 *
 * Интерфейс роботов
 */
interface IRobot {
    function getPower();
    function getOn();
    function getType();
}
/**
 * Class Robot
 *
 * Абстрактный класс для роботов
 */
class Robot implements IRobot{
    protected $power = 0;
    protected $on = TRUE;
    protected $type;

    public function setOn()
    {
        $this->on = TRUE;
    }

    public function setOff()
    {
        $this->on = FALSE;
    }

    /**
     * @param $robot_power
     */
    public function setPower($robot_power)
    {
        $this->power = $robot_power;
    }

    /**
     * @param $robot_type
     */
    public function setType($robot_type)
    {
        $this->type = $robot_type;
    }

    /**
     * @return int
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @return bool
     */
    public function getOn()
    {
        return $this->on;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}
/**
 * Class RobotOne
 *
 * Первый робот
 */
class RobotOne extends Robot {
    protected $power = 10;
    protected $type = 'machinist';
}
/**
 * Class RobotTwo
 *
 * Второй робот
 */
class RobotTwo extends Robot {
    protected $power = 10;
    protected $type = 'supervisor';
}

/**
 * Class FactoryBuild
 */
class FactoryBuild {
    protected $robots = array();

    /**
     * @param Robot $robot
     * @param $count
     * @return array
     */
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

    /**
     * @param Robot $robot
     * @param $to_off_count
     * @return array
     */
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

    /**
     * @param Robot $robot
     * @return int
     */
    public function getFactoryPower(Robot $robot) {
        $factory_power = 0;
        $same_type_on_robots = $this->filterByType($robot, TRUE);

        foreach ($same_type_on_robots as $factory_robot) {
            $factory_power += $factory_robot->getPower();
        }

        return $factory_power;
    }

    /**
     * @param Robot $robot
     * @param bool $only_on
     * @return array
     */
    protected function filterByType(Robot $robot, $only_on = FALSE) {
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