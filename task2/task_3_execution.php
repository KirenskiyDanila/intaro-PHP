<?php
$text = $_POST['text'];
// ищем числовые значения в кавычках и помещаем их в массив
preg_match_all("/['][0-9]+[']/", $text, $group);
$newGroup = array();

// удваиваем числовое значение в кавычках
foreach ($group[0] as $item) {
    $item = trim($item, "'");
    $value = $item * 2;
    $newGroup[] = "'" . $value . "'";
}
// обратный цикл с заменой значений в кавычках
for ($i = count($newGroup) - 1; $i >= 0; $i--) {
    $count = $i + 1;
    $text = preg_replace("/['][0-9]+[']/", $newGroup[$i], $text, $count);
    echo $text . "<br>";
    echo $newGroup[$i] . "<br>";
    echo $count . "<br>";

}
echo $text;
