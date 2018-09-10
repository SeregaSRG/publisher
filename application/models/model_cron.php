<?php
class Model_Cron
{
    public function cron()
    {
        global $pdo;

        $getAllDatarQuery = $pdo->prepare(
            "SELECT * FROM `tasks`"
        );
        $getAllDatarQuery->execute();
        $tasks = $getAllDatarQuery->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tasks as $task) {
            sleep(2);
            $data = self::getAvito($task);

            for ($i=0; $i<count($data['title']); $i++) {

                $getQuery = $pdo->prepare("
                  SELECT id FROM `avito` WHERE `avito_id` = :id
                ");
                $getQuery->execute([
                    ':id' => $data[2][$i]
                ]);
                if ( !$getQuery->rowCount() ) {
                    $json = [
                        'id' =>  $data[2][$i],
                        'img' => substr($data[3][$i], 32, 38),
                        'title' => substr($data[4][$i], 27),
                        'city' => strip_tags($data[6][$i]),
                        'time' => $data[7][$i],
                        'price' => $data['price'][$i],
                        'link' => 'https://www.avito.ru/'.$data[8][$i]
                    ];
                    $addQuery = $pdo->prepare("
                      INSERT INTO `avito` SET `avito_id` = :id, `data` = :data
                    ");
                    $addQuery->execute([
                        ':id' => $data[2][$i],
                        ':data' => json_encode($json)
                    ]);

                    $textAndTel = self::getText('https://www.avito.ru/'.$data[8][$i]);
                    $text = strip_tags($textAndTel['text']);
                    $tel = $textAndTel['tel'];
                    $group_id = '-'.$task['group_id'];
                    $token = $task['token'];
                    $url = "https://api.vk.com/method/wall.post";
                    self::phoneDemixer($data[2][$i],$tel);

                    $handle = curl_init();
                    curl_setopt($handle, CURLOPT_URL, 'https://api.vk.com/method/wall.post?owner_id='.$group_id.'&friends_only=0&from_group=0&message='.urlencode($json['title']."\n".$json['city']."\nЗ/П: ".$json['price']."\n".$text).'&&v=5.78&access_token='.$token);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    $page = curl_exec($handle);
                    curl_close($handle);
                    $arr = json_decode($page);
                    echo $page."<br>";
                }
            }
        }
    }

    function getAvito($task) {

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, "https://m.avito.ru".$task['category']);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($handle);
        curl_close($handle);

        $pattern = "'<article.{0,10} class=\"(b-item js-catalog-item-enum |b-item js-catalog-item-enum item-highlight)\".{0,10} data-item-id=\"(?<avito_id>.{7,10})\".{1,1000}<span class=\"pseudo-img\"(?<imgsrc>.*?)<.{1,1000}<h3 class=\"item-header\">(?<title>.*?)</span>.*?</h3>(?<price>.*?)<div class=\"item-info\">(?<details>.*?)<div .*? info-text\">(?<data>.*?)</div>.*?<a href=\"(?<href>.*?)\"'si";
        $titre=preg_match_all($pattern, $html, $ads) ;
        unset($ads[0]);

        $pattern2="' url\((?<imgsrc>.*?)\)'si";

        for ($i=0;$i<count($ads["price"]);$i++)
        {
            $ads["price"][$i]=preg_replace('/[^\d]+/', '',strip_tags($ads["price"][$i]));
            $ads["title"][$i]=trim(strip_tags($ads["title"][$i]));

            preg_match($pattern2, $ads["imgsrc"][$i], $ar) ;
            $ads["imgsrc"][$i]=$ar["imgsrc"];
        }

        return $ads;
    }

    function getText($link) {
        sleep(10);
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $link);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($handle);
        curl_close($handle);

        preg_match_all('#<div class="item-description"> <div class="item-description-text" itemprop="description">
  <p>(.+?)</p>  </div>#is', $html, $arr);
        preg_match_all('#avito.item.phone = \'(.+?)\';#is', $html, $tel);;

        return array(
            'text' => $arr[1][0],
            'tel'  => $tel[1][0]
        );
    }

    function phoneDemixer($id, $key) {
        sleep(6);
        preg_match_all("/[\da-f]+/",$key,$pre);
        $pre = $id%2==0 ? array_reverse($pre[0]) : $pre[0];
        $mixed = join('',$pre);
        $s = strlen($mixed);
        $r='';
        for($k=0; $k < $s; ++$k) {
            if ($k%3==0) {
                $r .= substr($mixed,$k,1);
            }
        }

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, 'https://www.avito.ru/items/phone/'.$id.'?pkey='.$r.'&vsrc=r');
        curl_setopt($handle, CURLOPT_PROXY, "185.17.120.144");
        curl_setopt($handle, CURLOPT_PROXYPORT, "1080");
        curl_setopt($handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($handle, CURLOPT_PROXYUSERPWD, "telegram:telegram");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($handle);
        curl_close($handle);

        // $data = json_decode($html);
        echo $html;

        // echo '<img src="'.$data['image64'].'">';
        return $r;
    }
}