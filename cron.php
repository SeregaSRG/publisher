<?php
header('Content-type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");
define('HOME_DIR',dirname(__FILE__));
require_once HOME_DIR.'/config.php';
require_once HOME_DIR.'/libraries/database.php';

$pdo = Database::connect();

// Получаем список задач из БД
$getAllDatarQuery = $pdo->prepare(
    "SELECT * FROM `tasks`"
);
$getAllDatarQuery->execute();
$tasks = $getAllDatarQuery->fetchAll(PDO::FETCH_ASSOC);

// Получаем список прокси из БД
$getAllProxy = $pdo->prepare(
    "SELECT * FROM `proxy`"
);
$getAllProxy->execute();
$proxy = $getAllProxy->fetchAll(PDO::FETCH_ASSOC);

foreach ($tasks as $task) {
    $data = getAvito($task);

    echo "________Задача________<br>";

    for ($i=0; $i<count($data['title']); $i++) {

        // var_dump($data);
        $getQuery = $pdo->prepare("
                  SELECT id FROM `avito` WHERE `avito_id` = :id
                ");
        $getQuery->execute(Array(
            ':id' => $data['id'][$i]
        ));

        if ( !$getQuery->rowCount() ) {

            $addQuery = $pdo->prepare("
                      INSERT INTO `avito` SET `avito_id` = :id, `data` = :data
                    ");
            $addQuery->execute(Array(
                ':id' => $data['id'][$i],
                ':data' => "NULL"
            ));

            $ad = parseAd('https://m.avito.ru'.$data['href'][$i], $proxy);
            // var_dump($ad);

            echo "<br>___Данные полученные от AVITO___<br>";
            echo $data['href'][$i]."<br>";
            echo $ad["title"]."<br>";
            // echo $ad["address"]."<br>";
            echo $ad["price"]->title." ".$ad["price"]->value." ".$ad["price"]->metric."<br>";
            echo $ad["text"]."<br>";
            // echo $ad["images"]."<br>";
            echo $ad["telephone"]."<br>";

            echo "____Ответ от ВК____<br>";

            $group_id = '-'.$task['group_id'];
            $token    = $task['token'];
            $attachment = '';

            foreach ($ad["images"] as $image) {
                sleep(8);
                echo "__цикл__<br>";
                // Сохранение фото
                $parsedUrl = explode('/', $image['640x480']);
                $count = count($parsedUrl);
                $ch = curl_init($image['640x480']);
                $fp = fopen(HOME_DIR.'/images/'.$parsedUrl[$count-1], 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);

                // получаем урл для загрузки
                echo "<br>получаем урл для загрузки<br>";
                $url_arr = file_get_contents("https://api.vk.com/method/photos.getWallUploadServer?v=5.78&access_token=".$token);
                $url = json_decode($url_arr)->response->upload_url;
                $user_id = mb_substr( json_decode($url_arr)->response->user_id, 1);
                $album_id = json_decode($url_arr)->response->album_id;
                echo "<br>Url: ".$url;
                echo "<br>User_id: .$user_id";
                echo "<br>Album_id: ".$album_id;

                // Загрузка фото
                echo "<br><br>Загрузка фото<br>";
                $file1 = new CurlFile(HOME_DIR.'/images/'.$parsedUrl[$count-1], 'image/jpg');
                //$file1 = new CurlFile(dirname(__FILE__).'/images/3003052500.jpg', 'image/jpg');
                $post_data = array("file1" => $file1);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                echo "<br>Result: ";
                $result = json_decode(curl_exec($ch),true);
                print_r($result);

                // сохранение фото
                echo "<br><br> сохранение фото<br>";
                $safe = file_get_contents("https://api.vk.com/method/photos.saveWallPhoto?photo=".$result['photo']."&server=".$result['server']."&hash=".$result['hash']."&v=5.78&access_token=".$token);
                $safe = json_decode($safe,true);
                echo "<br>Safe: ";
                print_r($safe);
                echo "<br><br>";
                echo "id: ".$safe['response'][0]['id']."<br>";
                echo "owner_id: ".$safe['response'][0]['owner_id']."<br>";

                $attachment .= "photo".$safe['response'][0]['owner_id']."_".$safe['response'][0]['id'].',';
            }

            if ($attachment != '') {
                // Публикация
                $url = "https://api.vk.com/method/wall.post";

                $post_data = array (
                    "owner_id" => $group_id,
                    "friends_only" => 0,
                    "from_group" => 1,
                    "message" => $ad["title"]."\n".$ad["price"]['title']." ".$ad["price"]['value']." ".$ad["price"]['metric']."\n".$ad["telephone"]."\n\n".$ad["text"],
                    "v" => 5.78,
                    // "attachments" => "https://work-all.ru/send?link=https://www.avito.ru".$data['href'][$i],
                    "attachments" => $attachment,
                    "access_token" => $token
                );

                $agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1';
                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, 'https://api.vk.com/method/wall.post');
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_USERAGENT, $agent);
                curl_setopt($handle, CURLOPT_POST, 1);
                curl_setopt($handle, CURLOPT_HEADER, 0);
                curl_setopt($handle, CURLOPT_POST, 1);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
                $page = curl_exec($handle);
                curl_close($handle);
                echo $page."<br>";
                echo "____конец____<br><br>";
            }
        }
    }
    sleep(1);
}

// Конец скрипта

// clear_dir(dirname(__FILE__).'/images/');


function getAvito($task) {
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, "https://m.avito.ru".$task['category']);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($handle);
    curl_close($handle);
    //echo $html;

    $pattern = "#<article(.*?)data-item-id=\"(?<id>.{7,100})\"(\s*)data-item-premium(.*?)<a itemprop=\"url\" href=\"(?<href>.{7,500})\" class=\"item-link(.*?)<span class=\"header-text\" itemprop=\"name\">(?<title>.{7,200})</span> </h3>(.*?)class=\"item-price-value\">(\s*)(?<price>.{7,100})(\s*)</span> <span itemprop=\"priceCurrency\" content=\"RUB\">#si";
    preg_match_all($pattern, $html, $ads);
    $arr = array(
        'id'    => $ads['id'],
        'href'  => $ads['href'],
        'title' => str_replace("&nbsp;", " ", $ads['title']),
        'price' => str_replace("&nbsp;руб", "₽", $ads['price'])
    );

	return $arr;
}

function parseAd($link, $proxy) {
    $countOfProxy = count($proxy);
    $number = rand(0, $countOfProxy);
    sleep(rand(50, 60));
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $link);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($handle, CURLOPT_PROXY,$proxy[$number]['ip']);
    //curl_setopt($handle, CURLOPT_PROXYUSERPWD,$proxy[$number]['login'].":".$proxy[$number]['password']);

    $html = curl_exec($handle);
    curl_close($handle);

    preg_match_all("#window.__initialData__ = (.+?)\|\| \{\}</script>#is", $html, $initialData );
    preg_match_all('#href="tel:(.+?)" data-marker#is', $html, $telephone);

    $allData = json_decode($initialData[1][0], true);
//    var_dump($allData);
    // echo $html;

    $result = array(
        'text' => $allData['item']['item']['description'],
        'title' => $allData['item']['item']['title'],
        'address' => $allData['item']['item']['address'],
        'price' => $allData['item']['item']['price'],
        'images' => $allData['item']['item']['images'],
        'telephone' => $telephone[1][0],
    );

    return $result;
}
// упрощенная функция scandir
function myscandir($dir)
{
    $list = scandir($dir);
    unset($list[0],$list[1]);
    return array_values($list);
}

// функция очищения папки
function clear_dir($dir)
{
    $list = myscandir($dir);

    foreach ($list as $file)
    {
        if (is_dir($dir.$file))
        {
            clear_dir($dir.$file.'/');
            rmdir($dir.$file);
        }
        else
        {
            unlink($dir.$file);
        }
    }
}