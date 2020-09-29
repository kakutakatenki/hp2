<html>
<head>
<title>xmlex</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
     $xml = simplexml_load_file('http://www.data.jma.go.jp/developer/xml/feed/regular_l.xml');
     $i=0;
     foreach($xml as $x){
          if(($x->author->name == "福岡管区気象台") &&($i < 10)){

            echo $i." ".$x->title.":".$x->author->name.":".$x->link->attributes()->href;
            echo "<br>--------------<br>";
            echo "<br>↓電文の中身<br>";
            //
            $xml_forcast = simplexml_load_file($x->link->attributes()->href);
            print_r($xml_forcast);
            //
            echo "<br>--------------<br>";
            echo "<br>";
            $i++;
        }
     }
?>
</body>
</html>