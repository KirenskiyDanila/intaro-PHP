
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
    include 'Banner.php';
    // для каждого файла
    for ($k = 1; $k < 7; $k++):
        $fileNumber = '0' . $k;
        $ansName = "0" . $fileNumber . ".ans";
        $datName = "0" . $fileNumber . ".dat";
        $ans =  htmlentities(file_get_contents("C\\" . $ansName));
        $dat =  htmlentities(file_get_contents("C\\" . $datName));

        $ans = str_replace("\n", "<br>", $ans); // данные из файла ответов
        $dat = str_replace("\n", "<br>", $dat); // данные из файла тестов

        $lines = file("C\\" . $datName, FILE_IGNORE_NEW_LINES);

        $banners = array();

        $fileResult = "";
        // добавляем баннеры в массив
        foreach ($lines as $line) {
            $name = explode(' ', $line)[0];
            $count = explode(' ', $line)[1];

            $banners[] = new Banner($name, $count);
        }

        $count = 0;
        // считаем их
        foreach ($banners as $banner) {
            $count += $banner->count;
        }
        // вычисляем пропорции для каждого баннера
        foreach ($banners as $banner) {
            $banner->proportion = 1.0 / ($count / $banner->count);
            $fileResult .= $banner->name . " " . round($banner->proportion, 6) . "<br>";
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
