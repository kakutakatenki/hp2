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


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126384684-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-126384684-4');
</script>
<?php
     date_default_timezone_set("Asia/Tokyo");
     //選択地点読み込み（ＧＥＴの変数から）
     $ken = "東京都"; 
     if(isset($_GET['ken'])){
          $ken =$_GET['ken'];
          setcookie("kakotenki_ken", $ken);
     }elseif(isset($_COOKIE["kakotenki_ken"])){
          $ken = $_COOKIE["kakotenki_ken"];
     }
     //昨日の値(比較用)
     $date = new DateTime();
     $date->modify('-1 days');
     $year = $date->format("Y");
     $month = $date->format("m");
     $day = $date->format("d");
     //取得した日
     if(isset($_GET['year'])){
          $year_get =$_GET['year'];
     }else{
          $year_get =$year;
     }
     if(isset($_GET['month'])){
          $month_get =$_GET['month'];
     }else{
          $month_get =$month;
     }
     if(isset($_GET['day'])){
          $day_get =$_GET['day'];
     }else{
          $day_get =$day;
     }
     // 数値から
     $date_get = new DateTime();
     $date_get->setDate($year_get,$month_get,$day_get);
     //昨日と比較
     $diff_day = $date->diff($date_get);//get-date（昨日）なので、　マイナスなら観測データあり
     echo $diff_day->format("%R%a").":dif";
     if($diff_day->format("%R%a") > 0){
          //正の値＝未来なので、getを昨日に変更
          $year_get =$year;
          $month_get =$month;
          $day_get =$day;
          ////////未来だったので・・・ということを書くか？/////////////
     }
     echo $year_get.$month_get.$day_get.":をget<br>";
?>
</head>

<body>
<?php
 echo $ken."<br>";
?>
<a href="../index.html">ホーム</a>>>過去の天気
<script>
function changeKen(){
    var ken = document.getElementById("ken_select").value;
    window.location.href ="./obs.php?ken=" + ken;
    $("#ken_select").val(ken);
    $('[name="ken"] option[value='+ken).prop('selected',true);
}
</script>

<form id="myform" action = "./obs.php" method = "get">
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
    <input id="datepicker" type="text" /><!--日付カレンダー用-->
</form>
<div id="url_div"></div>
<script>
    var ken = "<?php echo $ken;?>";
    $('[name="ken"] option[value='+ken).prop('selected',true);//県用
    //$('#datepicker').datepicker();//日付用
    $('#datepicker').datepicker({
    onSelect: function(dateText, inst){
    window.location.href = 'obs.php?'+ "ken=" + ken +"&year=" + inst.selectedYear + "&month=" + (inst.selectedMonth+1) +"&day="+inst.selectedDay;     
  }
});
</script>

 

<?php
require("phpQuery-onefile.php");
     $url = "https://www.data.jma.go.jp/obd/stats/etrn/view/hourly_a1.php?prec_no=82&block_no=1477&year="
     .$year_get."&month=".$month_get."&day=".$day_get."&view=";

     echo $url;
     $html = file_get_contents($url, False);
     $doc = phpQuery::newDocument($html);
     ////
	$h3 = $doc["h3"];
     echo $h3;
     ///
	$table = $doc["table#tablefix1"];
     //pq("input")->remove();
     echo "<table>".$table."</table>";
?>

</style>
</body>
</html>