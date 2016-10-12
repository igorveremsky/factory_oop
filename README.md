# Task
Є роботи яких випускає фабрика. Кожен робот має тип, потужність та активність.
Всі роботи одного типу виконують одну роботу, у випадку якщо інші роботи, які виконують туж роботу зупиняються, то загальная потужність однотипних роботів збільшується, таким чином, щоб потужність системи не зменшилась.
Потрібно спроектувати класи так, щоб можна було моделювати наступну поведінку.
Приклад використання, файл index.php:
$Factory=new FactoryBuild();
$RobotOne=new RobotOne();
$RobotTwo=new RobotTwo();

$Factory>make($RobotOne, 10); Робимо та запускаємо 10 роботів
$Factory>getPower($RobotOne); Виводить 100
$Factory>makeOff($RobotOne, 2); Робимо не активних 2 робота
$Factory>getPower($RobotOne); Виводить 100
$Factory>make($RobotOne, 5); Робимо та запускаємо 5 роботів
$Factory>getPower($RobotOne); Виводить 150
$Factory>makeOff($RobotTwo, 2); Помилка, роботи не запущені
$RobotTwo>setPowerRobot(15); Визначаємо потужність рота
$Factory>make($RobotTwo, 2); Робимо і запускаємо 2 робота типу Two
$Factory>getPower($RobotTwo); Виводить 30
