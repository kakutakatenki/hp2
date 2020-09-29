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
     //地域番号読み込み（ＧＥＴの変数から）
     $prec_no = "1477"; 
     //$prec_no = $_GET['prec_no'];
     if(isset($_GET['prec_no'])){
          $prec_no =$_GET['prec_no'];
          echo $prec_no;
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
     echo $prec_no."の".$block_no."：".$year_get.$month_get.$day_get.":をget<br>";
?>
</head>

<body>
<?php
 echo $prec_no."<br>";
?>

<a href="../index.html">ホーム</a>>>過去の天気

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
<form id="blockform" action = "./obs.php" method = "get">
    <select name= "block_no" id="block_selsect" onchange="changeTiten()">
    </select>
</form>
<input id="datepicker" type="text"/><!--日付カレンダー用-->
<div id="url_div"></div>

<script>
var prece_no;
var block_no;

</script>
<script>
     //urlのパラメータから初期値を設定
    // var prec_no = "";
    // var block_no = "";
     prec_no = "<?php echo $prec_no;?>";
     block_no = "<?php echo $block_no;?>";
     //block_noのセレクタを作成
     $("#prec_no").val("prec_no");
     changePlace('#block_selsect')

     //htmlのセレクタを選択
     $("#block_no").val("block_no");
     console.log(prec_no+"パラメータ取得");
     console.log(block_no+"パラメータ取得で設定しました");

     //

     //都道府県番号をオプションにして飛ばす
    reload_from_option();
    function reload_from_option(){

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
          //ここだけボタンにする？     
               window.location.href = 'obs.php?'+ "prec_no=" + prec_no +"&block_no="+block_no+"&year=" + inst.selectedYear + "&month=" + (inst.selectedMonth+1) +"&day="+inst.selectedDay;     
          }
          
          });
    }
    function changeTiten(){
         //block_no選択時
          prec_no = document.getElementById("ken_selsect").value;
          block_no = document.getElementById("block_selsect").value;
          console.log(block_no);
          console.log(prec_no);

    }
    changePlace("#block_selsect");

</script>

 
//phpデータ取得部分
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