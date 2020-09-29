<?php
$xml = simplexml_load_file("http://www.data.jma.go.jp/developer/xml/data/db13a58f-e5b1-353b-8117-4c483448fdba.xml");
//print_r($xml);
echo "<br>----------------<br>";
$products = $xml->xpath("/Control");
print_r($products);
 ?>