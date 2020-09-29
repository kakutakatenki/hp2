<!DOCTYPE html>
<html lang="ja">
<head>
<title>気象庁の天気予報</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="jquery.min.js"></script>
<meta name="Keywords" content="気象庁,天気予報," />
<meta name="Description" content="気象庁の最新の天気予報や気象データを見やすく配信" />
<link rel="icon" href="http://weather.kakutyoutakaki.com/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" type="img/x-icon" href="http://weather.kakutyoutakaki.com/images/favicon.ico" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126384684-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-126384684-4');
</script>
<?php
     //選択した地点を選択しなおす
     $ken = "東京都"; 
     if(isset($_GET['ken'])){
          $ken =$_GET['ken'];
          setcookie("jmaweth_ken", $ken);
     }elseif(isset($_COOKIE["jmaweth_ken"])){
          $ken = $_COOKIE["jmaweth_ken"];
     }
?>

</head>

<body>
<?php
 echo $ken;
?>
<a href="../index.html">ホーム</a>>>最新天気予報
<script>
function changeKen(){
    var ken = document.getElementById("ken_select").value;
    window.location.href ="./fct.php?ken=" + ken;
    $("#ken_select").val(ken);
    $('[name="ken"] option[value='+ken).prop('selected',true);
}
</script>

<form id="myform" action = "./fct.php" method = "get">
    <select name= "ken" id="ken_select" onchange="changeKen()">
     <option value="宗谷地方">北海道(宗谷地方)</option>
     <option value="上川・留萌地方">北海道(上川・留萌地方)</option>
     <option value="網走・北見・紋別地方">北海道(網走・北見・紋別地方)</option>
     <option value="釧路・根室・十勝地方">北海道(釧路・根室・十勝地方)</option>
     <option value="胆振・日高地方">北海道(胆振・日高地方)</option>
     <option value="石狩・空知・後志地方">北海道(石狩・空知・後志地方)</option>
     <option value="渡島・檜山地方">北海道(渡島・檜山地方)</option>
     <option value="青森県">青森県</option>
     <option value="岩手県">岩手県</option>
     <option value="宮城県">宮城県</option>
     <option value="秋田県">秋田県</option>
     <option value="山形県">山形県</option>
     <option value="福島県">福島県</option>
     <option value="茨城県">茨城県</option>
     <option value="栃木県">栃木県</option>
     <option value="群馬県">群馬県</option>
     <option value="埼玉県">埼玉県</option>
     <option value="千葉県">千葉県</option>
     <option value="東京都">東京都</option>
     <option value="神奈川県">神奈川県</option>
     <option value="新潟県">新潟県</option>
     <option value="富山県">富山県</option>
     <option value="石川県">石川県</option>
     <option value="福井県">福井県</option>
     <option value="山梨県">山梨県</option>
     <option value="長野県">長野県</option>
     <option value="岐阜県">岐阜県</option>
     <option value="静岡県">静岡県</option>
     <option value="愛知県">愛知県</option>
     <option value="三重県">三重県</option>
     <option value="滋賀県">滋賀県</option>
     <option value="京都府">京都府</option>
     <option value="大阪府">大阪府</option>
     <option value="兵庫県">兵庫県</option>
     <option value="奈良県">奈良県</option>
     <option value="和歌山県">和歌山県</option>
     <option value="鳥取県">鳥取県</option>
     <option value="島根県">島根県</option>
     <option value="岡山県">岡山県</option>
     <option value="広島県">広島県</option>
     <option value="山口県">山口県</option>
     <option value="徳島県">徳島県</option>
     <option value="香川県">香川県</option>
     <option value="愛媛県">愛媛県</option>
     <option value="高知県">高知県</option>
     <option value="福岡県">福岡県</option>
     <option value="佐賀県">佐賀県</option>
     <option value="長崎県">長崎県</option>
     <option value="熊本県">熊本県</option>
     <option value="大分県">大分県</option>
     <option value="宮崎県">宮崎県</option>
     <option value="鹿児島県">鹿児島県</option>
     <option value="沖縄本島地方">沖縄県(沖縄本島地方)</option>
     <option value="大東島地方">沖縄県(大東島地方)</option>
     <option value="宮古島地方">沖縄県(宮古島地方)</option>
     <option value="八重山地方">沖縄県(八重山地方)</option>
    </select>
</form>
<script>
     var ken = "<?php echo $ken;?>";
     $('[name="ken"] option[value='+ken).prop('selected',true);
</script>

<?php
     
     date_default_timezone_set("Asia/Tokyo");
     //$ken = "福岡県";
     $xml = simplexml_load_file('http://www.data.jma.go.jp/developer/xml/feed/regular_l.xml');
     $i=0;
     $back =0;//何個前の予報にする？テスト用
     $back_index=0;
     foreach($xml as $x){//府県天気予報
          //if(($x->author->name == $kisyoudai) &&($i < 15) && ($x->title =="府県天気予報（Ｒ１）")){
          if(($x->content =="【".$ken."府県天気予報】") && ($x->title =="府県天気予報（Ｒ１）")){
               if($back_index == $back){
                    //echo $i." ".$x->title.":".$x->author->name.":".$x->link->attributes()->href;
                    $xml_forcast = simplexml_load_file($x->link->attributes()->href);
                    $i++;
                    break;     
               }
               $back_index++;
          }
     }
     //独自予報があるか（あるとxmlの読み込み順番が変わるので）
     $dokuji = 0;
     if($xml_forcast->Body->MeteorologicalInfos[2]->attributes()->type=="独自予報"){
          $dokuji = 1;
     }
     echo "<br>";
     $reptime_tanki = date("m月d日H時",strtotime((string)$xml_forcast->Head->ReportDateTime));
     echo $reptime_tanki ."発表の天気予報と";
     foreach($xml as $x){//府県週間天気予報
        if($x->content =="【".$ken."府県週間天気予報】"){
               //echo $i." ".$x->title.":".$x->author->name.":".$x->link->attributes()->href;
               $xml_week = simplexml_load_file($x->link->attributes()->href);
               $i++;
               break;
        }
     }
     $repday_tanki = date("d",strtotime((string)$xml_forcast->Head->ReportDateTime));
     $repday_week = date("d",strtotime((string)$xml_week->Head->ReportDateTime));
     $reptime_week =  date("d日H時",strtotime((string)$xml_week->Head->ReportDateTime));
     echo $reptime_week."発表の週間天気予報<br>";
     //何時形式か。5時or11時or17時
     $fct_type =(string) $xml_forcast->Body->MeteorologicalInfos->TimeSeriesInfo->TimeDefines->TimeDefine;

     //今日　今夜　などtimedifを抽出
     $timedif = $xml_forcast->Body->MeteorologicalInfos->TimeSeriesInfo->TimeDefines->TimeDefine;
     foreach($timedif as $tdif){
          $out_timedif[] =  (string)$tdif->Name;//今日・明日・明後日
          $tmp_day = new DateTime((string)$tdif->DateTime);
          $out_daytime[] = $tmp_day->format("n月j日")."(".getweekday($tmp_day).")";//今日・明日の日付2020-08-08T11:00:00+09:00
     }

     //地域名と明後日迄の予報
     $item = $xml_forcast->Body->MeteorologicalInfos->TimeSeriesInfo->Item;
     foreach($item as $fc){
          $aera = (string)$fc->Area->Name;//○○地方など、1次細分
          $out_aera[] = $aera ;
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
          $out_kaku_time_karamade[]= cnv_karamade((string)$kaku_time->Name);//００時から０６時までとか
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
     //だいたい↓で動くけど
     $items = $xml_forcast->Body->MeteorologicalInfos[2+$dokuji]->TimeSeriesInfo;//->Item;//->Kind;

     //地域名
     foreach($items->Item as $it){
          $tenki_names[] = (string)$it->Area->Name;
     }
     //時刻(timedefine)
     foreach($items->TimeDefines->TimeDefine as $tdef){
          $tenki_time[] = (string)$tdef->DateTime;//天気時系列の時刻
     }
     //今日のコマ数を数える
     $today_n =  0;
     $today = date("d", strtotime($tenki_time[0]));
     foreach($tenki_time as $times){
          $day_tem  = date("d", strtotime($times));
          if($today == $day_tem){
               $today_n++;
          }
     }
     $tommrow_n = count($tenki_time)-$today_n;
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
     $tem_time = array();//配列初期化

     foreach($Times->TimeDefine as $tdef){
          $tt = (string)$tdef->DateTime;//XMLから抽出 タイムスタンプ形式
          //最初と00時のみ日を入れる
          if(count($tem_time)==0 || date('H', strtotime($tt))=="00"){
               $tem_time[] = date('d日H時', strtotime($tt));
          }else{
               $tem_time[] = date('H時', strtotime($tt));
          }
          $out_tenki_ji[] = date('H時', strtotime($tt));
     }

     $items = $xml_forcast->Body->MeteorologicalInfos[3+$dokuji]->TimeSeriesInfo;//->Item;//->Kind;
     foreach($items->Item as $it){
          $tji_name = (string)$it->Station->Name;
          $out_tji_name[] = $tji_name;
          foreach($it->Kind->Property->TemperaturePart->children("jmx_eb", true)->Temperature as $t_ji){
               //   最低気温とか=type 抽出
            $out_tji[$tji_name][] = (string)$t_ji;
          }
     }
     //明後日
     $asatte_no_week = 1;//明後日は週間の予報配列の何番目　基本は０が明日、１が明後日。
 
     if( $repday_tanki == $repday_week){
          //短期と週間で発表日が同じ = 11時予報以降
          $asatte_no_week = 1;    
     }else{
          //5時予報から11時予報の間
          $asatte_no_week = 0;
     }
     $asatte_tenki = $xml_week->Body->MeteorologicalInfos->TimeSeriesInfo->Item->Kind[0]->Property->WeatherPart->children("jmx_eb", true)->Weather[$asatte_no_week];
     $asatte_kakuritu = $xml_week->Body->MeteorologicalInfos[0]->TimeSeriesInfo->Item->Kind[1]->Property->ProbabilityOfPrecipitationPart->children("jmx_eb", true)->ProbabilityOfPrecipitation[$asatte_no_week];
     $asatte_min = $xml_week->Body->MeteorologicalInfos[1]->TimeSeriesInfo->Item->Kind->Property[0]->TemperaturePart->children("jmx_eb", true)->Temperature[$asatte_no_week];
     $asatte_max =$xml_week->Body->MeteorologicalInfos[1]->TimeSeriesInfo->Item->Kind->Property[3]->TemperaturePart->children("jmx_eb", true)->Temperature[$asatte_no_week];

     
     foreach($xml_week->Body->MeteorologicalInfos->TimeSeriesInfo->Item->Kind[0]->Property->WeatherPart->children("jmx_eb", true)->Weather as $weektenki){
          $week_tenki[] = (string)$weektenki;
     }
     foreach($xml_week->Body->MeteorologicalInfos[0]->TimeSeriesInfo->Item->Kind[1]->Property->ProbabilityOfPrecipitationPart->children("jmx_eb", true)->ProbabilityOfPrecipitation as $weekkakuritu){
          $week_kakuritu[] = (string)$weekkakuritu;
     }
     foreach($xml_week->Body->MeteorologicalInfos[1]->TimeSeriesInfo->Item->Kind->Property[0]->TemperaturePart->children("jmx_eb", true)->Temperature as $weekmin){
          $week_min[] = (string)$weekmin;
     }
     foreach($xml_week->Body->MeteorologicalInfos[1]->TimeSeriesInfo->Item->Kind->Property[3]->TemperaturePart->children("jmx_eb", true)->Temperature as $weektem){
          $week_max[] =(string)$weektem;
     }
     foreach($xml_week->Body->MeteorologicalInfos->TimeSeriesInfo->TimeDefines->TimeDefine as $weekday){
          $tmp_day = new DateTime((string)$weekday->DateTime);
          $week_day[] = $tmp_day->format("j日")."(".getweekday($tmp_day).")";//今日・明日の日付2020-08-08T11:00:00+09:00
     } 
     /*
          echo "<br>---週間天気予報-----------<br>";
     print_r($week_tenki);
     print_r($week_kakuritu);
     print_r($week_min);
     print_r($week_max);
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
     */



echo "<h1 class='title'>気象庁の天気予報 </h1>";
echo "<h2 class='ken'>". $ken ."の天気予報</h2>";;
//確率の今日は何番目まで？
$kakuritu_today_last = array_search('１８-００', $out_kaku_time_karamade);

$point_index =0;//地点のインデックス
$t_aeras = $out_t["name"];//気温の地点名（予報とは違って、アメダスポイント名）

echo "<div id='fct'>";
foreach($out_aera as $area){
     echo "<div class='aera_tile'>";
     echo "<h3 class='aera_name'>".$area."</h2>";
     $i=0;//0：今日　1：明日 2:明後日
     $j=0;//予報のindex…予報は一つの配列に入っているので
     $kakuritu_today_last_tmp = $kakuritu_today_last;
     //今日、明日、明後日の予報でループ
     foreach($out_fct[$area] as $ar_fct){
          $j_st = $j;
          $t_name =$t_aeras[$point_index];
          echo "<div class='fct_timedif'>";
          //ここに時系列もの。
          
          echo "<div class='fct_day'>".$out_timedif[$i]."　".$out_daytime[$i]."</div>";//今日とか明日とか
          echo "<div class='nowrap'>";//予報と最高気温と改行させない
          if($i <=1){
               echo  "<div class='fct'>".fcttoimg($ar_fct)."</div>";//予報文(今日明日)
          }elseif($i==2){
               //明後日の場合
               echo  "<div class='fct'>".fcttoimg($ar_fct)."<br>";           
               echo "<table class='plob'><tr><td>時間</td><td>00-24</td></tr><tr><td>降水確率</td><td>".$asatte_kakuritu."</td></tr></table>";
               echo "</div>";//nowrap 予報と最高気温のコンテナ終了
          }

          //ここで最高最低気温
          if($i==0){
               //今日の場合
               if(count($out_t[$t_name])==3){
                    //17時形式は気温無し
                    echo "<div class='tem_maxmin'>";
                    echo "</div>";
               }elseif(count($out_t[$t_name])==5){
                    //11時形式,05時形式
                    echo "<div class='tem_maxmin'>";
                    echo "<p class='max'>".$out_t[$t_name]["要素名"][0]."</p>";
                    echo "<div class='max_tem'>".$out_t[$t_name][0]."℃</div>";
                    echo "</div>";
               }
          }elseif($i==1){
               //明日の場合
               if(count($out_t[$t_name])==3){
                    //17時形式
                    echo "<div class='tem_maxmin'>";
                    echo "<p class='min'>".$out_t[$t_name]["要素名"][0]."</p>";
                    echo "<div class='min_tem'>".$out_t[$t_name][0]."℃</div>";//明日の最低気温
                    echo "<p class='max'>".$out_t[$t_name]["要素名"][1]."</p>";
                    echo "<div class='max_tem'>".$out_t[$t_name][1]."℃</div>";//明日の最高気温
                    echo "</div>";
               }elseif(count($out_t[$t_name])==5){
                    //11時形式,05時形式
                    echo "<div class='tem_maxmin'>";
                    echo "<p class='min'>".$out_t[$t_name]["要素名"][2]."</p>";
                    echo "<div class='min_tem'>".$out_t[$t_name][2]."℃</div>";//明日の最低気温
                    echo "<p class='max'>".$out_t[$t_name]["要素名"][3]."</p>";
                    echo "<div class='max_tem'>".$out_t[$t_name][3]."℃</div>";//明日の最高気温
                    echo "</div>";
               }
          }elseif($i==2){
               //明後日の場合
               echo "<div class='tem_maxmin'>";
               echo "<p class='min'>最低気温</p>";
               echo "<div class='min_tem'>".$asatte_min."℃</div>";//明日の最低気温
               echo "<p class='max'>最高気温</p>";
               echo "<div class='max_tem'>".$asatte_max."℃</div>";//明日の最高気温
               echo "</div>";
          }
          echo "</div>";//予報と最高気温と改行させない

          //降水確率
          if($i <= 1){
               echo "<table class='plob'>";
               echo "<tr><td>時間</td>";
               while($j<=$kakuritu_today_last_tmp){
                    echo "<td>".$out_kaku_time_karamade[$j]."</td>";
                    $j++;
               }
               $j = $j_st;
               echo "</tr><tr><td>降水確率</td>";
               while($j<=$kakuritu_today_last_tmp){
                    echo "<td>".$out_kakuritu[$area][$j]."%</td>";
                    $j++;
               }
               echo "</tr></table>";
               
          }
          echo "</div>";//timedif終了

          //天気時系列
          if($i==0){
               //今日の場合、天気予報時系列
               echo "<table class='tenki_table'><caption>3時間ごとの天気</caption>";
               //時刻部分
               echo "<tbody><tr>";
               //$today_sell_num = count($out_tenki_ji) - 9;
               echo "<th colspan='".($today_n * 2 +1 ) ."' class='tenkitable_day'>今日</th><th colspan='".($tommrow_n *2 )."'>明日</th></tr>";
               foreach($out_tenki_ji as $ttime){
                    echo "<th colspan='2'>".$ttime."</th>";//2セルずつにして１セルずらす
               }
               echo "<th></th></tr><tr><td></td>";
               //予報部分
               foreach($out_ji_tenki[$area] as $tenki){
                    echo "<td colspan='2'>".fcttoimg_ji($tenki)."</td>";
               }
               echo "</tr></tbody></table>";

               //明日の場合　気温時系列
               echo "<canvas id='tem_char_".array_search($area,$out_aera)."' class='tem_char'></canvas>";
          }

          $kakuritu_today_last_tmp += 4;
          $i++;
          
     }
     echo "</div>";//〇地方終了
     $point_index++;
     
}
echo "</div>";
//週間
$week_index = 0;
echo "<table class='week_table'><tr>";
echo "<th class='week_title'>日付</th>";
foreach($week_day as $wd){
     if($week_index >= 2){
          echo "<th>".$wd."</th>";
     }
     $week_index++;
}
echo "</tr><tr>";
$week_index = 0;
echo "<th class='week_title'>天気</th>";
foreach($week_tenki as $wd){
     if($week_index >= 2){
          echo "<td class='w_td'>".fcttoimg($wd)."</td>";
     }
     $week_index++;
}
echo "</tr><tr>";
$week_index = 0;
echo "<th class='week_title'>降水確率</th>";
foreach($week_kakuritu as $wd){
     if($week_index >= 2){
          echo "<td>".$wd."%</td>";
     }
     $week_index++;
}
echo "</tr><tr>";
$week_index = 0;
echo "<th class='week_title'>最高気温</th>";
foreach($week_max as $wd){
     if($week_index >= 2){
          echo "<td class='w_max'>".$wd."℃</td>";
     }
     $week_index++;
}
echo "</tr><tr>";
$week_index = 0;
echo "<th class='week_title'>最低気温</th>";
foreach($week_min as $wd){
     if($week_index >= 2){
          echo "<td class='w_min'>".$wd."℃</td>";
     }
     $week_index++;
}
echo "</tr><tr>";
echo "</tr></table>";
//週間ここまで
//配列から、何番目がその言葉か探す
function get_index($times,$sarch_star){
     $i=0;
     $ret = 0;
     foreach($times as $ts){
          if($ts == $sarch_star){
               $ret = $i;
               break;
          }
          $i++;
     }
     return $ret;
}

function fcttoimg($str){
     $ret = str_replace("晴れ", "<img src='./img/hare_min.png' alt='晴れ'>___", $str);
     $ret = str_replace("くもり", "<img src='./img/kumori_min.png' alt='曇り'>___", $ret);
     $ret = str_replace("雨", "<img src='./img/ame_min.png' alt='雨'>___", $ret);
     $ret = str_replace("雪", "<img src='./img/yuki_min.png' alt='雪'>___", $ret);

     $tmp_str = explode("___",$ret);
     //$tmp_strは、イメージごとに分かれて配列に。

      //所によりより後ろが長いので改行使用問題
      
     $sub_tenki_flg = false;
     $sub_tenki_index = 0;
     $main_fct = "";
     $sub_fct = "";
     //$return_str = "<span class='main_fct'>";
     $mainimg_index=0;
     //２つ目のmain天気のあとで改行を入れたい
     foreach($tmp_str as $tmp_str){
          
          if(!$sub_tenki_flg){//サブ天気を見つけるまで
               if(preg_match('/所により/',$tmp_str)){
                    //$return_str = $return_str."</span><p class='text_min'>".$tmp_str;
                    $sub_tenki_flg = true;
                    $sub_tenki_index = 1;
                    $sub_fct = $tmp_str;//所によりなのでsub
               }elseif(preg_match('/では/',$tmp_str)){
                    //$return_str = $return_str."</span><p class='text_min'>".$tmp_str;
                    $sub_tenki_flg = true;
                    $sub_tenki_index = 1;
                    $sub_fct = $tmp_str;//所によりなのでsub
               }else{//main天気の場合はここで処理
                    if($mainimg_index==2){
                         $main_fct = $main_fct." <br>".$tmp_str;
                    }else{
                         $main_fct = $main_fct." ".$tmp_str;//所により以外はmain
                    }
                    $mainimg_index++;
                   // $return_str =$return_str.$tmp_str;
               }
          }else{
               //サブ天気の場合のみ
               $sub_fct =$sub_fct."　".$tmp_str;//所によりなのでsub
          }
     }
     //$ret = $return_str."</p>";


     //ここでtokorominと同じ改行する

     $sub_fcts = explode("　",$sub_fct);
     $i=0;
     $after_sub="";
     foreach($sub_fcts as $st){
          if($i==5){
               $after_sub = $after_sub."<br>".$st; 
          }else{
               $after_sub = $after_sub." ".$st; 
          }
          $i++;
     }//$after_sub は所によりの後ろの表現で長すぎるときは改行が入る
     //$ret = "<span class='main_fct'>".$tmp_str[0]."</span><p class='text_min'>所により".$tmp_str[1]."</p>";

     $ret = "<span class='main_fct'>".$main_fct."</span><p class='text_min'>".$after_sub."</p>";

//////////////////
     $ret = str_replace("雷", "<img src='./img/kaminari_min.png' alt='雷'>", $ret);     
     
     return $ret;
}
function fcttoimg_ji($str){
     $ret = str_replace("晴れ", "<img src='./img/hare_min.png' alt='晴れ'><br>", $str);
     $ret = str_replace("くもり", "<img src='./img/kumori_min.png' alt='曇り'><br>", $ret);
     $ret = str_replace("雨", "<img src='./img/ame_min.png' alt='雨'><br>", $ret);
     $ret = str_replace("雪", "<img src='./img/yuki_min.png' alt='雪'><br>", $ret);
     return $ret;
}
function cnv_karamade($str){
     $ret = str_replace("時から","-",$str);
     $ret = str_replace("時まで","",$ret);
     return $ret;
}
function tokoro_min($str){
     /*
     //所によりを小さな文字に。
     $tmp_str = explode("所により",$str);
     if(count($tmp_str)>=2){
          //所によりがある場合
          //所以下の文字が多い場合は改行しましょう。
          $tokoro_str = explode("　",$tmp_str[1]);
          $i=0;
          $after_tokoro="";
          foreach($tokoro_str as $st){
               if($i==4){
                    $after_tokoro = $after_tokoro."<br>".$st; 
               }else{
                    $after_tokoro = $after_tokoro." ".$st; 
               }
               $i++;
          }//$tokoro_str は所によりの後ろの表現で長すぎるときは改行が入る
          //$ret = "<span class='main_fct'>".$tmp_str[0]."</span><p class='text_min'>所により".$tmp_str[1]."</p>";
          $ret = "<span class='main_fct'>".$tmp_str[0]."</span><p class='text_min'>所により".$after_tokoro."</p>";

     }else{
          $ret = "<span class='main_fct'>".$str."</span>";
     }
     */
     return $str;
}
function tiiki_min($str){
          //地域天気（所によりとか、〇〇地方ではとか）を小さな文字に。
          $tmp_str = explode(">",$str);

          if(count($tmp_str)>=3){
               //所によりがある場合
               //所以下の文字が多い場合は改行しましょう。
               $tokoro_str = explode("　",$tmp_str[1]);
               $i=0;
               $after_tokoro="";
               foreach($tokoro_str as $st){
                    if($i==4){
                         $after_tokoro = $after_tokoro."<br>".$st; 
                    }else{
                         $after_tokoro = $after_tokoro." ".$st; 
                    }
                    $i++;
               }//$tokoro_str は所によりの後ろの表現で長すぎるときは改行が入る
               //$ret = "<span class='main_fct'>".$tmp_str[0]."</span><p class='text_min'>所により".$tmp_str[1]."</p>";
               $ret = "<span class='main_fct'>".$tmp_str[0]."</span><p class='text_min'>所により".$after_tokoro."</p>";
     
          }else{
               $ret = "<span class='main_fct'>".$str."</span>";
          }
          return $ret;
}
function getweekday($day){//引数day は日付オブジェクト
     $weekn = $day->format("w");
     switch($weekn)
{
    case 0:
        $ret = "日";
        break;
    case 1:
        $ret ="月";
        break;
    case 2:
        $ret ="火";
        break;
    case 3:
        $ret = "水";
        break;
    case 4:
        $ret = "木";
        break;
    case 5:
        $ret = "金";
        break;
    case 6:
        $ret = "土";
        break;
}
     return $ret;
}
?>
<!--チャート-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

  <script>
//地域名でループ使用
//var t_name = <?php echo json_encode($out_t["name"], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
var t_name = <?php echo json_encode($out_tji_name, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
var t_time = <?php echo json_encode($tem_time, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
var t_ji = <?php echo json_encode($out_tji, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;


//チャートchart.js　で時系列気温のグラフ描画
for(var i=0;i<t_name.length;i++){
     //console.log(t_name[i]);     
     var ctx = document.getElementById("tem_char_"+i);
     drow_chart(ctx,i);

}
function drow_chart(ctx,i){
     
  const aryMax = function (a, b) {return Math.max(a, b);}
  const aryMin = function (a, b) {return Math.min(a, b);}

  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
          labels: t_time,//〇〇時
      datasets: [
        {
          label: '気温(度）',
          data:t_ji[t_name[i]],
          borderColor: "rgba(50,100,50,1)",
          backgroundColor: "rgba(0,0,0,0)"
        },
      ],
    },
    options: {
      title: {
        display: true,
        text: t_name[i]+'の予想気温'
      },
      scales: {
        yAxes: [{
          ticks: {
            //suggestedMax: 35,
            suggestedMax: 1 + t_ji[t_name[i]].reduce(aryMax),
            suggestedMin: -1 + t_ji[t_name[i]].reduce(aryMin),
            stepSize: 1,
            callback: function(value, index, values){
              return  value +  '度'
            }
          }
        }]
      },
      legend: {
            display: false
      }
    }
  });
}
  </script>
  
  <style>
/*タイトル：：ミシン目、付箋タイプ*/
h1 {
  position: relative;
  padding: 0.2em 0.5em;
  background: -webkit-linear-gradient(to right, rgb(11, 24, 255), #a994ff);
  background: linear-gradient(to right, rgb(11, 24, 255), #a994ff);
  color: white;
  font-weight: lighter;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.56);
}
/*地域名：吹き出し*/
h3.aera_name {
  position: relative;
  padding: 0.6em;
  background: #202dCf;
  margin : 0;
  color : white;
  text-align: center;

}

h3.aera_name:after {
  position: absolute;
  content: '';
  top: 100%;
  left: 30px;
  border: 15px solid transparent;
  border-top: 15px solid #202dCf;
  width: 0;
  height: 0;
}

/*予報全体の背景*/
div.aera_tile{
     display: inline-block;
     border: solid 2px #202dCf;
     background: #FFFFF3;
     margin-left:3px;
     width : 400px;
     /*height : 400px;*/
}
/*予報の入れ物*/
div.fct_day{
     width :100%;
     display: inline-block;
     position: relative;
     height: 60px;/*高さ*/
     line-height: 60px;/*高さ*/
     text-align: center;
     padding: 0px 40px 3px; 18px;/*文字の左右の余白*/
     font-size: 18px;/*文字サイズ*/
     background: #8648ff;/*背景色*/
     color: #FFF;/*文字色*/
     box-sizing: border-box;
}
div.fct_timedif{
     margin : 5px;
     margin-top :15px; 
     margin-left : 10px;     
     background: #F5F5F0;
     box-shadow: 1px 1px 5px 1px #999;
     border-radius:5px;
}
div.fct{
     display :inline-block;
     height : 100%;/*予報枠の高さは固定*/
     width : 280px;
     background: #F5F5FF;
     word-wrap: break-word;
     /*fct_timedifのさらに中*/
     font-size: 13px;/*文字サイズ*/
     float : left;
     /*border : 2px solid #A0A0A0;*/
     margin-left : 1px;
}

div.fct img {
     max-width : 50px;
     max-height : 50px;
}
div.nowrap{
     white-space: nowrap;
     width : 100%;
     height : 150px;
     margin-left : 1px;
     padding : 1px;
}
span.main_fct{
     background: linear-gradient(transparent 60%, #5bed3b 0%);
     /*white-space: nowrap;*/
     margin : 2px;
}
/*予報時系列*/
table.tenki_table{
  border-collapse: separate; /*collapse;*/
  border: solid 1px #000000;
  width : 92%;
  margin-left: 8%;
}
table.tenki_table tr{
  border-bottom: solid 2px white;
}
table.tenki_table tr:last-child{
  border-bottom: none;
}
table.tenki_table td{
  position: relative;
  text-align: center;
  max-width: 10px;
  /*background-color: #52c2d0;*/
  color: #505050;
  text-align: center;
  padding: 10px 0;
  border-right: 0.5px solid #E0E0E0;
}

table.tenki_table th{
     text-align: center;
     max-width : 10px;
     font-size : 12px;
}
table.tenki_table th.tenkitable_day{
     border-right: 0.5px solid #E0E0E0;
}
table.tenki_table td img{
     max-width : 20px;
}
/*気温*/
div.tem_maxmin{
     display :inline-block;
     width : 90px;
     /*min-height: 100px;*/
     /*height : 120px;*/
     height :100%;
     /*border : 2px solid #A0A0A0;*/
     background: #F5F5FF;
     margin : 1px;
     /*fct_timedifのさらに中*/
}
div.max_tem{
     font-size : 32px;
     color : red;
     font-weight: 800;
     float : right;
     text-align : center;
     margin : 0;
}
div.min_tem{
     margin :0;
     padding :0;
     font-size : 32px;
     color : blue;
     font-weight: 800;
     text-align : center;
}
p.max{
     margin :0;
     padding :0;
     font-size : 12px;
     color : red;
}
p.min{
     margin :0;
     padding :0;
     font-size : 12px;
     color : blue;
     
}
div.fct img{
     width :80px;
     height:80px;
} 

div.fct p.text_min img{
     width :25px;
     height:22px;
}
/*降水確率*/
table.plob{
  width: 100%;
  margin :0;
  border-collapse: collapse;
}

table.plob tr{
  background-image: linear-gradient(40deg, #e043fc 0%, #4F4Ffb 64%);
}

table.plob tr:last-child *{
  border-bottom: none;
}

table.plob th,table td{
  text-align: center;
  border: solid 2px #fff;
  color: white;
  padding: 2px 0;
}
p.text_min{
     font-size:14px;
     word-wrap: break-word;
}
div.week_fct{
     display : inline-block;
}
.week_table{
     width :400px;
     border-collapse: collapse;
     text-align: left;
     line-height: 1.5;
     border: 1px solid #ccc;
     margin :2px;
}
.week_table th{
     font-weight: bold;
     border: 1px solid #A0A0A0;
     background: -webkit-linear-gradient(to right, rgb(11, 24, 255), #7974ff);
     background: linear-gradient(to right, rgb(81, 84, 255), #3934ff);
     color: #ffffff;
}
.week_table tr td{
     color :black;
     border: 1px solid #A0A0A0;
}
.week_table tr td img{
     width : 20px;
     height : 20px;
}
.week_table td {
     width : 40px;
     font-weight: 600;
}
.week_table td.w_td {
     font-size : 10px;
}
table.week_table th.week_title{
     width : 40px;
     padding: 10px;
} 
table.week_table .w_max{
    color : red; 
}
table.week_table .w_min{
    color : blue; 
}

</style>
</body>
</html>