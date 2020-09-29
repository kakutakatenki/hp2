<?php

/**
 * 気象庁のサイトから都府県・地方データの一覧を得る
 * @return array ('name'=>名称,'prec_no'=>都府県・地方No)
 */
function jma_get_prec_list() {
	
	$url = "http://www.data.jma.go.jp/obd/stats/etrn/select/prefecture00.php";
	
	$html = file_get_contents($url);
	
	$html = preg_replace('/^.*<map/ims', '<map', $html);
	$html = preg_replace('/\/map>.*$/ims', '/map>', $html);
	$html = preg_replace('/<br>/i', '', $html);
	$html = preg_replace('/<area(\b.*)>/i', '<area$1/>', $html);
	$html = preg_replace('/&/ims', '&amp;', $html);
	
	$doc = simplexml_load_string($html);
	
	$areas = $doc->xpath("//area");
	$prec_no_map = array();
	$prec_list = array();
	for($i = 0; $i < count($areas); $i++) {
		$attr = $areas[$i]->attributes();
		$href = preg_replace('/&amp;/', '&', $attr['href']);
		$prec_no = preg_replace('/^.*prec_no=(\d+).*/', '$1', $href);
		if(!array_key_exists($prec_no, $prec_no_map)) {
			$prec_no_map[$prec_no] = true;
			$prec_list[] = array(
				"name" => $attr['alt'],
				"url" => $href,
				"prec_no" => $prec_no,
			);
		}
	}
	return $prec_list;
}

/**
 * 指定された都府県・地方に含まれる、観測地点(ブロック)データの一覧を気象庁のサイトから得る
 * @param int $prec_no 都府県・地方No.
 * @return array ('name'=>名称,'block_no'=>地点・ブロックNo)
 */
function jma_get_block_list($prec_no) {
	
	$url = "http://www.data.jma.go.jp/obd/stats/etrn/select/prefecture.php?prec_no=$prec_no";
	
	$html = file_get_contents($url);

	$html = preg_replace('/^.*<map/ims', '<map', $html);
	$html = preg_replace('/\/map>.*$/ims', '/map>', $html);
	$html = preg_replace('/<br>/i', '', $html);
	$html = preg_replace('/<area(\b.*?)>/ims', '<area$1/>', $html);
	$html = preg_replace('/&/ims', '&amp;', $html);
	
	$doc = simplexml_load_string($html);
	
	$areas = $doc->xpath("//area");
	$block_no_map = array();
	$block_list = array();
	for($i = 0; $i < count($areas); $i++) {
		$attr = $areas[$i]->attributes();
		$href = preg_replace('/&amp;/', '&', $attr['href']);
		$prec_no_in_url = preg_replace('/^.*prec_no=(\d+).*/', '$1', $href);
		if($prec_no_in_url == $prec_no) {
			$block_no = preg_replace('/^.*block_no=(\d+).*/', '$1', $href);
			if(!array_key_exists($block_no, $block_no_map)) {
				$block_no_map[$block_no] = true;
				$block_list[] = array(
					"name" => $attr['alt'],
					"url" => $href,
					"prec_no" => $prec_no,
					"block_no" => $block_no,
				);
			}
		}
	}
	return $block_list;
}

/**
 * 気象庁のサイトから観測地点を指定して、指定日付の10分間隔の気圧情報を得る。
 * @param int $prec_no 都府県・地方No
 * @param int $block_no 地点(ブロック)No
 * @param int $year 年
 * @param int $month 月(1..12)
 * @param int $day 日
 * @return array ('t'=>時刻,'p'=>現地気圧,'p0'=>海面気圧)
 */
function jma_get_pressure_10min(
		$prec_no, $block_no, $year, $month, $day)
{
	$url = "http://www.data.jma.go.jp/obd/stats/etrn/view/10min_s1.php?"
			. "prec_no=$prec_no&"
			. "block_no=$block_no&"
			. "year=$year&"
			. "month=$month&"
			. "day=$day";

	$html = file_get_contents($url);

	$html = preg_replace('/^.*<table id=\'tablefix1\' class=\'data2_s\'/ims', '<table', $html);
	$html = preg_replace('/\/table>.*/ims', '/table>', $html);
	$html = preg_replace('/<br>/i', '', $html);

	$doc = simplexml_load_string($html);

	$table_rows = $doc->xpath("//tr");
	$presure_data = array();
	for($i = 2; $i < count($table_rows); $i++) {
		$presure_data[] = array(
				"t" => $table_rows[$i]->td[0],
				"p" => $table_rows[$i]->td[1],
				"p0" => $table_rows[$i]->td[2],
		);
	}
	return $presure_data;
}


$prec_list = jma_get_prec_list();
sleep(1);

echo "\n";
echo "## 都府県・地方一覧\n";
echo "\n";
echo "|No.|名称|\n";
echo "|--:|:--|\n";
foreach($prec_list as $prec) {
	echo "|" . $prec["prec_no"];
	echo "|" . $prec["name"];
	echo "|\n";
}
echo "\n";
foreach($prec_list as $prec) {
	$prec_no = $prec["prec_no"];
	$block_list = jma_get_block_list($prec_no);
	echo "### " . $prec["name"] . "(" . $prec["prec_no"] . ") 地点(ブロック)一覧\n";
	echo "\n";
	
	echo "|No.|名称|\n";
	echo "|--:|:--|\n";
	foreach($block_list as $block) {
		echo "|" . $block["block_no"];
		echo "|" . $block["name"];
		echo "|\n";
	}
	echo "\n";
	sleep(1);
}

//兵庫県姫路の2014-09-24の気圧データを取得
$presure_data = jma_get_pressure_10min(
		63,47769,//兵庫県姫路
		2014,9,24);
echo "### 兵庫県 姫路 2014年9月24日の10分間隔の気圧データ\n";
echo "\n";
echo "|時刻|現地気圧|海面気圧|\n";
echo "|:--:|--:|--:|\n";
foreach($presure_data as $data) {
	echo "|" . $data["t"];
	echo "|" . $data["p"];
	echo "|" . $data["p0"];
	echo "|\n";
}