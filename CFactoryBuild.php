<?php
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