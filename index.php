<?php

require_once('kanji.php');
function str_split_unicode($str, $l = 0) {
	if ($l > 0) {
		$ret = array();
		$len = mb_strlen($str, "UTF-8");
		for ($i = 0; $i < $len; $i += $l) {
			$ret[] = mb_substr($str, $i, $l, "UTF-8");
			}
		return $ret;
		}
	return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
	}

?>
<!DOCTYPE HTML>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
.red {
color: #e70000;
}
.green {
color: #3cbf08;
}
</style>
</head>
<body>
<form method="POST" action="" />
	<p>your kanji go here: <input type="text" name="kanji"/></p>
</form>
<?php

if(isset($_POST['kanji']) && strlen($_POST['kanji']) > 0) {
	$pd = str_split_unicode($_POST['kanji']);
	foreach(array('n5'=>$n5_str, 'n4'=>$n4_str, 'n3'=>$n3_str, 'n2'=>$n2_str, 'n1'=>$n1_str) as $name => $nx_str) {
		echo '<p><strong>'.$name.'</strong><br />';
		$of = 0;
		$all = 0;
		foreach(str_split_unicode($nx_str) as $k) {
			if(in_array($k, $pd)) {
				$of++;
				echo '<span class="green">'.$k.'</span>';
				}
			else {
				echo '<span class="red">'.$k.'</span>';
				}
			$all++;
			}
		echo '<br />('.$of.'/'.$all.')</p>';
		}
	}

?>
<hr />
<p><strong>about</strong></p>
<p>kanji lists obtained from here: <a href="http://www.mext.go.jp/a_menu/shotou/new-cs/youryou/syo/koku/001.htm">kyōiku</a> (n5-2), <a href="http://www.aozora.gr.jp/kanji_table/">jōyō</a>+<a href="https://en.wikipedia.org/wiki/J%C5%8Dy%C5%8D_kanji#History">2010 revision</a> (n1)
</body>
</html>
