<?php
$text = $_POST['text'];
// подходит ли ссылка под формат
if (!preg_match("/http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent&RN=[0-9-]+&[0-9]+/", $text)) {
    echo "Ошибка! Неверный формат!";
    die();
}
// помещаем числа в массив
preg_match_all("/[0-9-]+/", $text, $lawAndNumber);
// достаем номер закона
$law = $lawAndNumber[0][0];
// создаем новую ссылку
$newLink = "http://sozd.parlament.gov.ru/bill/" . $law;
echo $newLink;
