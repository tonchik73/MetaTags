<?php

// загружаем страницу как строку
$html = file_get_contents('index.html');

// отмечаем желаемый элемент
$substring = "<meta";


// собираем в вектор индексы начала тега
$lastPos = 0;
$startPositions = array();
$endPositions = array();

while (($lastPos = strpos($html, $substring, $lastPos))!== false) {
    $startPositions[] = $lastPos;
    $lastPos = $lastPos + strlen($substring);
}



// собираем в вектор индексы конца тега
foreach ($startPositions as $value) {
    for ($i = $value; $i < $value+300; $i++) {
        if($html[$i]==='>'){
            array_push($endPositions, $i+1);
            break;
        }
    }

}


// собираем вектор с индексами, которые относятся к тегам
$exclude = array();
for ($i = 0; $i < count($startPositions); $i++){
    for($j=$startPositions[$i];$j<$endPositions[$i];$j++){
        array_push($exclude,$j);
    }
}

// инициализируем новую строку и добавляем все индексы из исходной, которые не попадают в список исключений
$newHtml = "";
for ($i = 0; $i < strlen($html); $i++){
    if(!in_array($i,$exclude)){
        // echo $i;
        $newHtml = $newHtml.$html[$i];
    }
}

// сохраняем новую страницу без тегов
file_put_contents("newHtml.html", $newHtml);
