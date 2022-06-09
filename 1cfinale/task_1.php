<html>
<head>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<table>
    <tr>
        <td>Выходные данные</td>
        <td>Ответ программы</td>
        <td>Ответ из файла</td>
    </tr>
<?php
// для каждого файла
include 'Advertising.php';
for ($k = 1; $k < 5; $k++):
    $ansName = "00" . $k . ".ans";
    $datName = "00" . $k . ".dat";
    $ans =  htmlentities(file_get_contents("A\\" . $ansName));
    $dat =  htmlentities(file_get_contents("A\\" . $datName));

    $ans = str_replace("\n", "<br>", $ans); // данные из файла ответов
    $dat = str_replace("\n", "<br>", $dat); // данные из файла тестов

    $lines = file("A\\" . $datName, FILE_IGNORE_NEW_LINES);

    $ads = array();
    $i = 0;
    foreach ($lines as $line) {
        // разбиваем строку на уникальный номер и дату
        $name = explode('        ', $line)[0];
        $time = explode('        ', $line)[1];
        $uniqueFlag = true;
        foreach ($ads as $ad) {
            // проверяем, есть ли в массиве элемент с таким номером
            if ($ad->name == $name) {
                $uniqueFlag = false;
                $ad->count++;
                $newDate = date_create($time);
                // проверяем, кто старше
                if($newDate > $ad->time) {
                    $ad->time = $newDate;
                }
                break;
            }
        }
        // если в массиве нет элемента с таким номером - создаем его
        if ($uniqueFlag == true) {
            $ads[] = new Advertising($name, 1, $time);
        }

    }
    $fileResult = "";

    // формируем ответ
    foreach ($ads as $ad) {
        $fileResult .= $ad->count . " " . $ad->name . " " . date_format($ad->time, 'Y-m-d H:i:s') . "<br>";
    }

?>
    <tr>
        <td><?=$dat?></td>
        <td><?=$fileResult?></td>
        <td><?=$ans?></td>
    </tr>
    <?php endfor;
    ?>
</table>
</body>
</html>