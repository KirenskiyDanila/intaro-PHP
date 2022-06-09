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
        <td>Совпадает?</td>
    </tr>
    <?php
    // для каждого файла
    for ($k = 1; $k < 15; $k++):
        $fileNumber = $k;
        if ($k <= 9) {
            $fileNumber = '0' . $k;
        }
        $ansName = "0" . $fileNumber . ".ans";
        $datName = "0" . $fileNumber . ".dat";
        $ans =  htmlentities(file_get_contents("C\\" . $ansName));
        $dat =  htmlentities(file_get_contents("C\\" . $datName));

        $ans = str_replace("\n", "<br>", $ans); // данные из файла ответов
        $dat = str_replace("\n", "<br>", $dat); // данные из файла тестов

        $lines = file("C\\" . $datName, FILE_IGNORE_NEW_LINES);

        $fileResult = "";
        // разбираем каждую строку по отдельности
        foreach ($lines as $line) {
            $pos = strpos($line, "> ");
            $type = $line[$pos + 2];
            $strAndParams = explode("> ", $line);
            $str = str_replace("<", "", $strAndParams[0]);
            switch ($type) {
                case "S":
                    $params = explode(" ", $strAndParams[1]);
                    $n = $params[1];
                    $m = $params[2];
                    if (strlen($str) >= $n && strlen($str) <= $m) {
                        $result = "OK";
                    }
                    else {
                        $result = "FAIL";
                    }
                    $fileResult = $fileResult . $result . "<br>";
                    break;
                case "N" :
                    $params = explode(" ", $strAndParams[1]);
                    $n = $params[1];
                    $m = $params[2];
                    if ($str >= $n && $str <= $m && (preg_match("/^[-]?[0-9]+$/", $str) == 1)) {
                        $result = "OK";
                    }
                    else {
                        $result = "FAIL";
                    }
                    $fileResult = $fileResult . $result . "<br>";

                    break;
                case "P":
                    if (preg_match("/^[+]7 [(][0-9]{3}[)] [0-9]{3}-[0-9]{2}-[0-9]{2}$/", $str) == 1) {
                        $result = "OK";
                    }
                    else {
                        $result = "FAIL";
                    }
                    $fileResult = $fileResult . $result . "<br>";
                    break;
                case "D":
                    $dateAndTime = explode(" ", $str);
                    $date = $dateAndTime[0];

                    $day = explode(".", $date)[0];
                    $month = explode(".", $date)[1];
                    $year = explode(".", $date)[2];

                    $isDateValid = checkdate($month, $day, $year);

                    if (strlen($year) != 4) {
                        $isDateValid = false;
                    }

                    $time = $dateAndTime[1];
                    $hours = explode(":", $time)[0];
                    $minutes = explode(":", $time)[1];



                    if ($hours < 24) {
                        $isHoursValid = true;
                    }
                    else {
                        $isHoursValid = false;
                    }

                    if ($minutes < 60) {
                        $isMinutesValid = true;
                    }
                    else {
                        $isMinutesValid = false;
                    }

                    if ($isDateValid && $isHoursValid && $isMinutesValid) {
                        $result = "OK";
                    }
                    else {
                        $result = "FAIL";
                    }
                    $fileResult = $fileResult . $result . "<br>";
                    break;
                case "E":
                    if (preg_match("/^[a-zA-Z0-9][a-zA-Z0-9_]{3,30}@[a-zA-Z]{2,20}[.][a-z]{2,10}$/", $str) == 1) {
                        $result = "OK";
                    }
                    else {
                        $result = "FAIL";
                    }
                    $fileResult = $fileResult . $result . "<br>";
                    break;
            }
        }
        if ($fileResult == $ans) {
            $check = "Да";
        }
        else {
            $check = "Нет";
        }


        ?>
        <tr>
            <td><?=$dat?></td>
            <td><?=$fileResult?></td>
            <td><?=$ans?></td>
            <td><?=$check?></td>
        </tr>
    <?php endfor;
    ?>
</table>
</body>
</html>