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