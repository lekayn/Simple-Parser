<?php 
require_once('lib/simple_html_dom.php');
require_once('lib/outputHelp.php');


/*Результат работы - массив данных о коледжах в формате:
 Название Колледжа | Адрес | Телефон | Сайт   , что соотвествует
  массиву с полями:
 [$i] =>[ [collegeName] => value; [collegeAddress] => value; [collegePhone] => value; [collegeWebsite]..]
*/

$html = file_get_html('https://www.princetonreview.com/college/harvard-college-1022984?ceid=cp-1022984');

$result = getCollegeData($html);
// printCollege($result);
writeToFileCollege($result);

function getCollegeData($html){
    $parseCollegeName = $html->find('.school-hero-section');
    $parseCollegeWebsite = $html->find('.school-headline-address');
    $parseCollegePhone = $html->find('.school-contacts.collapse');


    foreach ($parseCollegeName as $value) {
        $name = $value->find('.school-headline',0)->plaintext;
        $name = trim($name);
        $college["collegeName"] = $name;
    }
    
    foreach ($parseCollegePhone as $value) {
        $address = $value->find('.col-xs-6', 1)->plaintext;
        $address = preg_replace('/\s+/', ' ', $address);
        $college["collegeAddress"] = $address;
        
        $phone = $value->find('.col-xs-6', 3)->plaintext;
        $phone = preg_replace('/\s+/', ' ', $phone);
        $college["collegePhone"] = $phone;
    }
    foreach ($parseCollegeWebsite as $value) {
        $college["collegeWebsite"] = $value->find('a',0)->href;  
        //$college["collegeAddress"] = $value->find('span',0)->plaintext;  
    }
   
    return $college;
}