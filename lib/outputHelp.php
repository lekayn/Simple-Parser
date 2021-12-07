<?php 

function printColleges($colleges){
    foreach ($colleges as $index => $college) {
        foreach ($college as $key => $value) {
            echo $value. " ";
        }
        echo '<br>';
    }

}


function writeToFileColleges($colleges){
    $fd = fopen("colleges.txt", 'w') or die("не удалось создать файл");

    $collegeData = str_pad("Ссылка на картинку", 106);
    $collegeData .= str_pad("Название Колледжа", 66);
    $collegeData .= str_pad("Город", 26);
    $collegeData .= str_pad("Штат\n", 5);

    foreach($colleges as $college){
        $collegeData .= str_pad($college["collegeImgURL"], 90);
        $collegeData .= str_pad($college["collegeName"], 50);
        $collegeData .= str_pad($college["collegeCity"], 20);
        $collegeData .= str_pad($college["collegeState"], 5);
        $collegeData.="\n";
    }
    fwrite($fd, $collegeData);
    
    fclose($fd);
}

function printCollege($college){
    foreach ($college as $key => $value) {
            echo $key. "->". $value;
        }
}

function writeToFileCollege($college){
    $fd = fopen("college.txt", 'w') or die("не удалось создать файл");

    $collegeData = str_pad("Название", 29);
    $collegeData .= str_pad("Адрес", 71);
    $collegeData .= str_pad("Телефон", 20);
    $collegeData .= "Вебсайт\n";

    $collegeData .= str_pad($college["collegeName"], 20);
    $collegeData .= str_pad($college["collegeAddress"], 62);
    $collegeData .= str_pad($college["collegePhone"], 11);
    $collegeData .= str_pad($college["collegeWebsite"], 40);
    $collegeData.="\n";

    fwrite($fd, $collegeData);
    
    fclose($fd);
}