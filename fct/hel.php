<html>
<head>
<title>福岡の天気予報</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
     $xml = simplexml_load_file('http://www.data.jma.go.jp/developer/xml/feed/regular_l.xml');
     $i=0;
     $n=0;
     foreach($xml as $x){//府県天気概況
          if(($x->author->name == "福岡管区気象台") &&($i < 25) && ($x->title =="府県天気予報（Ｒ１）")){
               echo $i." ".$x->title.":".$x->author->name.":".$x->link->attributes()->href;
               $xml_forcast = simplexml_load_file($x->link->attributes()->href);
               $i++;
               $n++;
               if($n >=2){
                    break;
               }
        }
     }
     echo $xml_forcast->Head->ReportDateTime."発表の天気予報<br>";

     //今日　今夜　などtimedifを抽出
     $timedif = $xml_forcast->Body->MeteorologicalInfos->TimeSeriesInfo->TimeDefines->TimeDefine;
     foreach($timedif as $tdif){
          $out_timedif[] =  (string)$tdif->Name;//今日・明日・明後日
     }

     //地域名と明後日迄の予報
     $item = $xml_forcast->Body->MeteorologicalInfos->TimeSeriesInfo->Item;
     foreach($item as $fc){
          $aera = (string)$fc->Area->Name;//○○地方など、1次細分
          $out_aera[] = $aera ;
          echo $aera."<br>" ;
          $dtfct = $fc->Kind->Property->DetailForecast->WeatherForecastPart;//予報詳細部分;
          foreach($dtfct as $fc){
               $out_fct[$aera][] = (string)$fc->Sentence;//今日・明日の予報
          }
     }

     //時系列予報データ(区域予報)
     //確率時刻
     //echo "<br>-------確率(時刻)-------<br>";
     $TimeDefine_kakuritsu = $xml_forcast->Body->MeteorologicalInfos->TimeSeriesInfo[1]->TimeDefines->TimeDefine;
     foreach($TimeDefine_kakuritsu as $kaku_time){
          $tmp_t = new DateTime((string)$kaku_time->DateTime);
          $out_kaku_time_start[] = $tmp_t->format("d日H時");//○○日○○時
          //echo "<br>".$tmp_t->format("d日H時")." = ";
          //echo $kaku_time->Name."<br>";
          $out_kaku_time[] = (string)$kaku_time->DateTime;//2020-08-04T18:00:00+09:00タイムスタンプ型
          $out_kaku_time_karamade[]= (string)$kaku_time->Name;//００時から０６時までとか
     }
     //echo "<br>-------確率-------<br>";
     //降水確率（地点予報）
     $kakuritsu_xml = $xml_forcast->Body->MeteorologicalInfos->TimeSeriesInfo[1]->Item;
     foreach($kakuritsu_xml as $kaku_xml){
          $ps_name = (string)$kaku_xml->Area->Name;
          $out_psname[] = $ps_name;
          $ps = $kaku_xml->Kind->Property->ProbabilityOfPrecipitationPart->children("jmx_eb", true)->ProbabilityOfPrecipitation;
          foreach($ps as $pasent){
               $out_kakuritu[$ps_name][] = (string)$pasent;
          }
     }
     $out_kakuritu["name"] = $out_psname;

     //echo "<br>-------地点予報 気温-------<br>";
     $items = $xml_forcast->Body->MeteorologicalInfos[1]->TimeSeriesInfo;//->Item;//->Kind;
     foreach($items->Item as $it){
          $t_name = (string)$it->Station->Name;
          $out_t_name[] = $t_name;
          foreach($it->Kind->Property as $pt){
               //   最低気温とか=type 抽出
            $type = $pt->TemperaturePart->children("jmx_eb", true)->Temperature->attributes()->type;
            $out_t[$t_name]["要素名"][] = (string)$type;
               //   気温部分   
            $tem = $pt->TemperaturePart->children("jmx_eb", true)->Temperature;
            $out_t[$t_name][] = (string)$tem; 
          }
     }
     $out_t["name"] = $out_t_name;

     //echo "<br>-------地点予報 天気-------<br>";
     $items = $xml_forcast->Body->MeteorologicalInfos[2]->TimeSeriesInfo;//->Item;//->Kind;
     //地域名
     foreach($items->Item as $it){
          $tenki_names[] = (string)$it->Area->Name;
     }
     //時刻(timedefine)
     foreach($items->TimeDefines->TimeDefine as $tdef){
          $tenki_time[] = (string)$tdef->DateTime;//天気時系列の時刻
     }

     //echo "時系列天気<br>";
     foreach($items->Item as $its){
          //地域名
          $place = (string)$its->Area->Name;
        //天気
          foreach($its->Kind->Property->WeatherPart->children("jmx_eb", true)->Weather as $tenki_tem){
               $out_ji_tenki[$place][] = (string)$tenki_tem;
          }
     }
     
     ///気温時系列
     $Times = $xml_forcast->Body->MeteorologicalInfos[3]->TimeSeriesInfo->TimeDefines;//->Item;//->Kind;
     foreach($Times->TimeDefine as $tdef){
          $tt = (string)$tdef->DateTime;
          $tem_time[] = $tt;
     }
     $items = $xml_forcast->Body->MeteorologicalInfos[3]->TimeSeriesInfo;//->Item;//->Kind;
     foreach($items->Item as $it){
          $tji_name = (string)$it->Station->Name;
          $out_tji_name[] = $tji_name;
          foreach($it->Kind->Property->TemperaturePart->children("jmx_eb", true)->Temperature as $t_ji){
               //   最低気温とか=type 抽出
            $out_tji[$tji_name][] = (string)$t_ji;
          }
     }
     echo "<br>---今日・明日・明後日-----------<br>";
     print_r($out_timedif);
     echo "<br>----○○地方など、1次細分----------<br>";
     print_r($out_aera);
     echo "<br>--今日・明日の予報----<br>";
     print_r($out_fct);
     echo "<br>---降水確率の時間---<br>";
     print_r($out_kaku_time);
     echo "<br>--降水確率の時間　からまで表示----<br>";
     print_r($out_kaku_time_karamade);
     echo "<br>---降水確率の時間(開始時刻)-----------<br>";
     print_r($out_kaku_time_start);
     echo "<br>---地域名に降水確率配列-----------<br>";   
     print_r($out_kakuritu); //地域名に降水確率配列
     echo "<br>---気温　最高最低と地域名-----------<br>";   
     print_r($out_t);//地域名、最高・最低気温
     echo "<br>---天気時系列の名前-----------<br>";   
     print_r($tenki_names);//地点予報　地域名
     echo "<br>---天気時系列の時刻-----------<br>";   
     print_r($tenki_time);//天気時系列の時刻？
     echo "<br>---時系列の天気----------<br>";   
     print_r($out_ji_tenki); //天気時系列
     echo "<br>---時系列気温の時刻-----------<br>";   
     print_r($tem_time);//気温時系列の時刻
     echo "<br>---時系列気温-----------<br>";   
     print_r($out_tji);
/*
//短期予報関連
/*
$out_timedif[] =  (string)$tdif->Name;//今日・明日・明後日
$out_aera[] = (string)$fc->Area->Name;//○○地方など、1次細分
$out_fct[(string)$fc->Area->Name][] = (string)$fc->Sentence;//今日・明日の予報

//降水確率関連
$out_kaku_time[] = (string)$kaku_time->DateTime;
$out_kaku_time_karamade[]= (string)$kaku_time->Name;
$out_kaku_time_start[] = $tmp_t->format("d日H時");//○○日○○時

$out_kakuritu[$ps_name][] //地域名に降水確率配列
$out_t[][]//地域名、最高・最低気温

$tenki_names//地点予報　地域名
$tenki_time[] = (string)$tdef->DateTime;//天気時系列の時刻？

$out_ji_tenki[$place][] //天気時系列
$tem_time[] = $tt;//気温時系列の時刻
$out_tji[$tji_name][]
*/

echo "<h2>今日から明日の天気</h2>";
?>

</body>
</html>