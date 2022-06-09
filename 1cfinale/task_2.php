
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
    include 'Node.php';
    // для каждого файла
    for ($k = 1; $k < 8; $k++):
        $fileNumber = '0' . $k;
        $ansName = "0" . $fileNumber . ".ans";
        $datName = "0" . $fileNumber . ".dat";
        $ans =  htmlentities(file_get_contents("B\\" . $ansName));
        $dat =  htmlentities(file_get_contents("B\\" . $datName));

        $ans = str_replace("\n", "<br>", $ans); // данные из файла ответов
        $dat = str_replace("\n", "<br>", $dat); // данные из файла тестов

        $lines = file("B\\" . $datName, FILE_IGNORE_NEW_LINES);

        $nodes = array();

        // представим дерево как массив объектов
        foreach ($lines as $line) {
            $id = explode(' ', $line)[0];
            $name = explode(' ', $line)[1];
            $leftValue = explode(' ', $line)[2];
            $rightValue = explode(' ', $line)[3];
            $nodes[] = new Node($id, $name, $leftValue, $rightValue);
        }
        // вычислим максимальное значение среди элементов дерева
        $maxValue = count($nodes) * 2;
        $fileResult = "";
        // алгоритм обхода дерева
        $level = 0;
        for ($i = 1; $i <= $maxValue; $i++) {
            foreach ($nodes as $node) {
                if ($node->leftValue == $i) {
                    $level++;
                    // за каждый уровень добавляем -
                    for ($j = 1; $j < $level; $j++) {
                        $fileResult .= "-";
                    }
                    $fileResult .= $node->name . "<br>";
                    break;
                }
                else if ($node->rightValue == $i){
                    $level--;
                    break;
                }
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
