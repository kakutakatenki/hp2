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
<link rel="stylesheet" href="obsstyle.css">
<!--カレンダー用--> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script>
<script src="changeplace.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126384684-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-126384684-4');
</script>
<?php
     //パラメータ取得部分
     date_default_timezone_set("Asia/Tokyo");
     //データの種類
     

     //地域番号読み込み（ＧＥＴの変数から）
     $prec_no = "1477"; 
     //$prec_no = $_GET['prec_no'];
     if(isset($_GET['prec_no'])){
          $prec_no =$_GET['prec_no'];
          //echo $prec_no;
     }
     //地点番号読み込み（ＧＥＴの変数から）
     $block_no = "47807";
     //$block_no = $_GET['block_no'];
     if(isset($_GET['block_no'])){
          $block_no =$_GET['block_no'];
     }
     //昨日の値(比較用)
     $date = new DateTime();
     $date->modify('-1 days');
     $year = $date->format("Y");
     $month = $date->format("m");
     $day = $date->format("d");
     //取得した日
     if(isset($_GET['year']) && is_numeric($_GET['year'])){
          $year_get =$_GET['year'];
     }else{
          $year_get =$year;
     }
     if(isset($_GET['month']) && is_numeric($_GET['month'])){
          $month_get =$_GET['month'];
     }else{
          $month_get =$month;
     }
     if(isset($_GET['day'])&& is_numeric($_GET['day'])){
          $day_get =$_GET['day'];
     }else{
          $day_get =$day;
     }
     // 数値から
     $date_get = new DateTime();
     $date_get->setDate($year_get,$month_get,$day_get);
     //昨日と比較
     $diff_day = $date->diff($date_get);//get-date（昨日）なので、　マイナスなら観測データあり
     //echo $diff_day->format("%R%a").":dif";
     if($diff_day->format("%R%a") > 0){
          //正の値＝未来なので、getを昨日に変更
          $year_get =$year;
          $month_get =$month;
          $day_get =$day;
          ////////未来だったので・・・ということを書くか？/////////////
     }
     //echo $prec_no."の".$block_no."：".$year_get.$month_get.$day_get.":をget<br>";
?>
</head>

<body>
<div id="contena">
<h1>過去の天気(1時間ごとの天気データ)</h1>
<a href="../index.html">ホーム</a>>>過去の天気（1時間ごとの天気データ）<br>

<!--form id="kenform"-->
    <select name= "prec_no" id="ken_selsect" onchange="changePlace('#block_selsect')">
     <option value="11">北海道(宗谷地方)</option>
     <option value="12">北海道(上川地方)</option>
     <option value="13">北海道(留萌地方)</option>
     <option value="14">北海道(石勝地方)</option>
     <option value="15">北海道(空知地方)</option>
     <option value="16">北海道(後志地方)</option>
     <option value="17">北海道(網走・北見・紋別地方)</option>
     <option value="18">北海道(根室地方)</option>
     <option value="19">北海道(釧路地方)</option>
     <option value="20">北海道(十勝地方)</option>
     <option value="21">北海道(胆振地方)</option>
     <option value="22">北海道(日高地方)</option>
     <option value="23">北海道(渡島地方)</option>
     <option value="24">北海道(檜山地方)</option>
     <option value="31">青森県</option>
     <option value="32">秋田県</option>
     <option value="33">岩手県</option>
     <option value="34">宮城県</option>
     <option value="35">山形県</option>
     <option value="36">福島県</option>
     <option value="40">茨城県</option>
     <option value="41">栃木県</option>
     <option value="42">群馬県</option>
     <option value="43">埼玉県</option>
     <option value="44">東京都</option>
     <option value="45">千葉県</option>
     <option value="46">神奈川県</option>
     <option value="48">長野県</option>
     <option value="49">山梨県</option>
     <option value="50">静岡県</option>
     <option value="51">愛知県</option>
     <option value="52">岐阜県</option>
     <option value="53">三重県</option>
     <option value="54">新潟県</option>
     <option value="55">富山県</option>
     <option value="56">石川県</option>
     <option value="57">福井県</option>
     <option value="60">滋賀県</option>
     <option value="61">京都府</option>
     <option value="62">大阪府</option>
     <option value="63">兵庫県</option>
     <option value="64">奈良県</option>
     <option value="65">和歌山県</option>
     <option value="66">岡山県</option>
     <option value="67">広島県</option>
     <option value="68">島根県</option>
     <option value="69">鳥取県</option>
     <option value="71">徳島県</option>
     <option value="72">香川県</option>
     <option value="73">愛媛県</option>
     <option value="74">高知県</option>
     <option value="81">山口県</option>
     <option value="82">福岡県</option>
     <option value="83">大分県</option>
     <option value="84">長崎県</option>
     <option value="85">佐賀県</option>
     <option value="86">熊本県</option>
     <option value="87">宮崎県</option>
     <option value="88">鹿児島県</option>
     <option value="91">沖縄県</option>
     <option value="99">南極</option>
    </select>
<!--/form-->
<!--form id="blockform" action = "./obs.php" method = "get"-->
    <select name= "block_no" id="block_selsect" onchange="changeTiten()">
    </select>
    <input id="datepicker" type="text"/><!--日付カレンダー用-->
    <button id="get" onclick="sendform()">決定</button>
<!--/form-->
<!--p>
<span id="url_div"></span>
<span id="year_div"> <?php echo $year_get;?></span>年
<span id="month_div"> <?php echo $month_get;?></span>月
<span id="day_div"> <?php echo $day_get;?></span>日
</p-->
<script>
     //urlのパラメータから初期値を設定
     var prec_no = "";
     var block_no = "";
     prec_no = "<?php echo $prec_no;?>";
     block_no = "<?php echo $block_no;?>";
     //block_noのセレクタを作成
     $("#ken_selsect option[value='"+prec_no+"']").prop('selected', true);
     changePlace('#block_selsect');

     //htmlのセレクタを選択
     //$("#block_no").val("block_no");
     $("#block_selsect option[value='"+block_no+"']").prop('selected', true);

     //日付関係
     var year = <?php echo $year_get;?>;
     var month = <?php echo $month_get;?>;
     var day = <?php echo $day_get;?>;

     //都道府県番号をオプションにして飛ばす
     setcal();
     function setcal(){

         $('[name="prec_no"] option[value="'+prec_no+'"').prop('selected',true);//県用
         //$('#datepicker').datepicker();//日付用
         $('#datepicker').datepicker({
               setDate:'-3d',
               dateFormat: 'yy/mm/dd (DD)',
               yearSuffix: '年',
               showMonthAfterYear: true,
               minDate: new Date(-5),
               maxDate: '-1d',
               hideIfNoPrevNext: true,
               onSelect: function(dateText, inst){
                    /*
                    $("#year_div").text(inst.selectedYear);
                    $("#month_div").text(inst.selectedMonth+1);
                    $("#day_div").text(inst.selectedDay);*/
                    year = inst.selectedYear;
                    month = inst.selectedMonth+1;
                    day = inst.selectedDay;
                    //window.location.href = 'obs.php?'+ "prec_no=" + prec_no +"&block_no="+block_no+"&year=" + inst.selectedYear + "&month=" + (inst.selectedMonth+1) +"&day="+inst.selectedDay;     
               }
          });
          $("#datepicker").datepicker("option", "dateFormat", 'yy-mm-dd' );
          $("#datepicker").datepicker("setDate", year+"-"+month+"-"+day);

    }
    function changeTiten(){
         //block_no選択時
          prec_no = document.getElementById("ken_selsect").value;
          block_no = document.getElementById("block_selsect").value;
    }
    function sendform(){
     prec_no = document.getElementById("ken_selsect").value;
     block_no = document.getElementById("block_selsect").value;
     window.location.href = 'obs.php?prec_no='+prec_no+"&block_no="+block_no+"&year="+year +"&month="+month+"&day="+day;
    }
    //changePlace("#block_selsect");
</script>

<!--phpデータで取得--> 
<?php
require("phpQuery-onefile.php");
     if(strlen($block_no) <= 3){
          //3桁未満なら５桁に
          $block_no = str_pad($block_no, 4, 0, STR_PAD_LEFT);
     }
     if(strlen($block_no)==5){
          //地上の場合    
          $url = "https://www.data.jma.go.jp/obd/stats/etrn/view/hourly_s1.php?prec_no=".$prec_no."&block_no=".$block_no."&year="
          .$year_get."&month=".$month_get."&day=".$day_get."&view=";     
     }else{
          //アメダスの場合
          $url = "https://www.data.jma.go.jp/obd/stats/etrn/view/hourly_a1.php?prec_no=".$prec_no."&block_no=".$block_no."&year="
          .$year_get."&month=".$month_get."&day=".$day_get."&view=";     
     }
     //echo $url;
     $html = file_get_contents($url, False);
     $doc = phpQuery::newDocument($html);     
     //pq('img')->attr("src")->remove();//晴れ雨をちゃんとする
     $h3 = $doc["h3:eq(0)"];
     $h3 = str_replace("h3","h2",$h3);
     //$h3 = str_replace($h3);
     echo $h3;
     $table = $doc["table#tablefix1"];
     $table= str_replace('../../', 'https://www.data.jma.go.jp/obd/stats/', $table);//URL置換
     //ローカルの画像に変換
     $table= str_replace('../../', 'https://www.data.jma.go.jp/obd/stats/', $table);//URL置換
     $table= str_replace('https://www.data.jma.go.jp/obd/stats/data/image/tenki/large/F8A0.gif', './image/hare.png', $table);//URL置換　晴れ
     $table= str_replace('https://www.data.jma.go.jp/obd/stats/data/image/tenki/large/F89F.gif', './image/kaisei.png', $table);//URL置換　快晴
     $table= str_replace('https://www.data.jma.go.jp/obd/stats/data/image/tenki/large/F8A2.gif', './image/kumori.png', $table);//URL置換　曇り
     $table= str_replace('https://www.data.jma.go.jp/obd/stats/data/image/tenki/large/F8A1.gif', './image/usugumori.png', $table);//URL置換　薄曇り
     $table= str_replace('https://www.data.jma.go.jp/obd/stats/data/image/tenki/large/F8A8.gif', './image/ame.png', $table);//URL置換　雨
     $table= str_replace('https://www.data.jma.go.jp/obd/stats/data/image/tenki/large/F8AA.gif', './image/yuki.png', $table);//URL置換　ゆき
     $table= str_replace('https://www.data.jma.go.jp/obd/stats/data/image/tenki/large/F8AD.gif', './image/kaminari.png', $table);//URL置換　雷

     //方角関係
     $table= str_replace('<td class="data_0_0" style="text-align:center">北</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/N.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">北北東</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/NNE.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">北東</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/NE.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">東北東</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/ENE.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">東</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/E.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">東南東</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/ESE.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">南東</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/SE.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">南南東</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/SSE.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">南</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/S.png"></td>', $table);

     $table= str_replace('<td class="data_0_0" style="text-align:center">南</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/S.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">南南西</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/SSW.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">南西</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/SW.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">西南西</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/WSW.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">西</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/W.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">西北西</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/WNW.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">北西</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/NW.png"></td>', $table);
     $table= str_replace('<td class="data_0_0" style="text-align:center">北北西</td>', '<td class="data_0_0" style="text-align:center"><img src="./image/NNW.png"></td>', $table);

     echo "<table>".$table."</table>";
?>
<h2>他の県の過去の天気</h2>
<a href="./obs.php?prec_no=14&block_no=47412">札幌</a>
<a href="./obs.php?prec_no=31&block_no=47575">青森県</a>
<a href="./obs.php?prec_no=32&block_no=47582">秋田県</a>
<a href="./obs.php?prec_no=33&block_no=47584">岩手県</a>
<a href="./obs.php?prec_no=34&block_no=47590">宮城県</a>
<a href="./obs.php?prec_no=35&block_no=47588">山形県</a>
<a href="./obs.php?prec_no=36&block_no=47595">福島県</a>
<a href="./obs.php?prec_no=40&block_no=47629">茨城県</a>
<a href="./obs.php?prec_no=41&block_no=47615">栃木県</a>
<a href="./obs.php?prec_no=42&block_no=47624">群馬県</a>
<a href="./obs.php?prec_no=43&block_no=47626">埼玉県</a>
<a href="./obs.php?prec_no=44&block_no=47662">東京都</a>
<a href="./obs.php?prec_no=45&block_no=47682">千葉県</a>
<a href="./obs.php?prec_no=46&block_no=47670">神奈川県</a>
<a href="./obs.php?prec_no=48&block_no=47610">長野県</a>
<a href="./obs.php?prec_no=49&block_no=47638">山梨県</a>
<a href="./obs.php?prec_no=50&block_no=47656">静岡県</a>
<a href="./obs.php?prec_no=51&block_no=47636">愛知県</a>
<a href="./obs.php?prec_no=52&block_no=47632">岐阜県</a>
<a href="./obs.php?prec_no=53&block_no=47651">三重県</a>
<a href="./obs.php?prec_no=54&block_no=47604">新潟県</a>
<a href="./obs.php?prec_no=55&block_no=47607">富山県</a>
<a href="./obs.php?prec_no=56&block_no=47605">石川県</a>
<a href="./obs.php?prec_no=57&block_no=47616">福井県</a>
<a href="./obs.php?prec_no=60&block_no=47761">滋賀県</a>
<a href="./obs.php?prec_no=61&block_no=47759">京都府</a>
<a href="./obs.php?prec_no=62&block_no=47772">大阪府</a>
<a href="./obs.php?prec_no=63&block_no=47769">兵庫県</a>
<a href="./obs.php?prec_no=64&block_no=47780">奈良県</a>
<a href="./obs.php?prec_no=65&block_no=47777">和歌山県</a>
<a href="./obs.php?prec_no=66&block_no=47768">岡山県</a>
<a href="./obs.php?prec_no=67&block_no=47766">広島県</a>
<a href="./obs.php?prec_no=68&block_no=47741">島根県</a>
<a href="./obs.php?prec_no=69&block_no=47746">鳥取県</a>
<a href="./obs.php?prec_no=71&block_no=47895">徳島県</a>
<a href="./obs.php?prec_no=72&block_no=47891">香川県</a>
<a href="./obs.php?prec_no=73&block_no=47887">愛媛県</a>
<a href="./obs.php?prec_no=74&block_no=47893">高知県</a>
<a href="./obs.php?prec_no=81&block_no=47784">山口県</a>
<a href="./obs.php?prec_no=82&block_no=47807">福岡県</a>
<a href="./obs.php?prec_no=83&block_no=47815">大分県</a>
<a href="./obs.php?prec_no=84&block_no=47817">長崎県</a>
<a href="./obs.php?prec_no=85&block_no=47813">佐賀県</a>
<a href="./obs.php?prec_no=86&block_no=47819">熊本県</a>
<a href="./obs.php?prec_no=87&block_no=47830">宮崎県</a>
<a href="./obs.php?prec_no=88&block_no=47827">鹿児島県</a>
<a href="./obs.php?prec_no=91&block_no=47768">沖縄県</a>
<a href="./obs.php?prec_no=99&block_no=89532">南極</a>


</div>
</body>
</html>