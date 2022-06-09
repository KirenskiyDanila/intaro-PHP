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
for ($k = 1; $k < 9; $k++):
    $ansName = "00" . $k . ".ans";
    $datName = "00" . $k . ".dat";
    $ans =  htmlentities(file_get_contents("B\\" . $ansName));
    $dat =  htmlentities(file_get_contents("B\\" . $datName));

    $ans = str_replace("\n", "<br>", $ans); // данные из файла ответов
    $dat = str_replace("\n", "<br>", $dat); // данные из файла тестов

    $lines = file("B\\" . $datName, FILE_IGNORE_NEW_LINES);

    $fileResult = "";
    // разбираем каждую строку по отдельности
    foreach ($lines as $line) {
        $result = "";
        // если строка равна ::, то её следует обрабатывать отдельно
        if ($line === "::") {
            $result = "0000:0000:0000:0000:0000:0000:0000:0000";
            continue;
        }
        $pos = strpos($line, "::");
        // если в строке есть ::
        if ($pos !== false) {

            $line = str_replace("::", "POINTER", $line);

            $sides = explode( "POINTER", $line);

            $line = str_replace("POINTER", ":", $line);

            // проверяем наличие символов слева от строки
            if (isset($sides[0])) {
                $chunksBeforeCount = count(explode(":", $sides[0]));
            }
            else {
                $chunksBeforeCount = 0;
            }

            // проверяем наличие символов справа от строки
            if (isset($sides[1])) {
                $chunksAfterCount = count(explode(":", $sides[1]));
            }
            else {
                $chunksAfterCount = 0;
            }

            // проверяем 4-х символьные части
            $chunks = explode(":", $line);
            $fixedChunks = array();
            foreach ($chunks as $chunk) {
                while (strlen($chunk) < 4) {
                    $chunk = '0' . $chunk;
                }
                $fixedChunks[] = $chunk;
            }

            // формируем новую строку
            $replacement = "";
            for ($i = 0; $i < (8 - count($fixedChunks)); $i++) {
                $replacement = $replacement . "0000:";
            }

            for ($i = 0; $i < $chunksBeforeCount; $i++) {
                $result = $result . $fixedChunks[$i] . ":";
            }

            $result = $result . $replacement;

            for ($i = 0; $i < $chunksAfterCount; $i++) {
                $result = $result . $fixedChunks[$i + $chunksBeforeCount] . ":";
            }
        }
        else {

            // проверяем 4-х символьные части
            $chunks = explode(":", $line);
            $fixedChunks = array();
            foreach ($chunks as $chunk) {
                while (strlen($chunk) < 4) {
                    $chunk = '0' . $chunk;
                }
                $fixedChunks[] = $chunk;
            }
            // формируем новую строку
            for ($i = 0; $i < count($fixedChunks); $i++){
                $result = $result . $fixedChunks[$i] . ":";
            }
        }
        $result = rtrim($result, ":");
        $fileResult = $fileResult . $result . "<br/>";
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