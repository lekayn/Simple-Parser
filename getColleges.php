<?php 
require_once('lib/simple_html_dom.php');
require_once('lib/outputHelp.php');


/*Результат работы - массив данных о коледжах в формате:
  Ссылка на картинку | Название Колледжа | Город | Штат, что соотвествует
  массиву с полями:
 [$i] =>[ [collegeImgURL] => value; [collegeName] => value; [collegeCity] => value; [collegeState]..]
*/

$html = file_get_html('https://www.princetonreview.com/college-search?ceid=cp-1022984');

$result1 =  getSimpleCollegesData($html);
$result2 = getFeaturesCollegesData($html);
$result = array_merge($result1, $result2);

printColleges($result);
writeToFileColleges($result);


function getSimpleCollegesData($html){
    $result = [];
    $collegesImg = $html->find('.col-xs-4.col-sm-2.image-col');
    $collegesData = $html->find('.col-xs-8.col-sm-10.school-col');

    //получаем URL изображений колледжей
    $collegeImgArray = [];
    foreach($collegesImg as $collegeImg){
        $collegeImgArray[] = $collegeImg->find('img', 0)->src;
    }
    
    //формируем массив с полной информацией о колледже
    $i=0;
    foreach ($collegesData as $collegeData) {
        $collegeDataArray = [];
        $collegeDataArray["collegeImgURL"] = $collegeImgArray[$i];
        $collegeDataArray["collegeName"] = $collegeData->find('a', 0)->plaintext;;
        $address = explode(",", $collegeData->find('.location', 0)->plaintext);
        $collegeDataArray["collegeCity"] = $address[0];
        $collegeDataArray["collegeState"] = $address[1];
        $result[] = $collegeDataArray;
        
        $i++;
    }

    return $result;
};
function getFeaturesCollegesData($html){
    $result = [];
    $collegesPart1 = $html->find('.col-sm-6.col-sm-height');
    $collegesPart2 = $html->find('.col-xs-12.col-sm-6');

    //добавляем один набор рекомендованных колледжей
    foreach($collegesPart1 as $college){
        $collegeData["collegeImgURL"] = $college->find('img', 0)->src;
        $collegeData["collegeName"] = $college->find('a', 0)->plaintext;
        $address = explode(",", $college->find('.location', 0)->plaintext);
        $collegeData["collegeCity"] = $address[0];
        $collegeData["collegeState"] = $address[1];

        $result[] = $collegeData; 
    }

    //добавляем второй набор рекомменд. колледжей
    $i = 0;
    foreach($collegesPart2 as $college){
        if($i % 2 == 0){
            $collegeData2["collegeImgURL"] = $college->find('img', 0)->src;
            $i++;
            continue;
        }
        
        $collegeData2["collegeName"] = $college->find('a', 0)->plaintext;
        $address = explode(",", $college->find('.location', 0)->plaintext);
        $collegeData2["collegeCity"] = $address[0];
        $collegeData2["collegeState"] = $address[1];

        $result[] = $collegeData2; 

        $i++;
    }
    return $result;
};

