<?php

$type = (isset($_GET['type']) ? $_GET['type'] : 'tangorin');
require_once('kanji_'.$type.'.php');

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
<p>type: <a href="?type=tangorin">tangorin</a> / <a href="?type=kyoikujoyo">kyōiku+jōyō</a></p>
<form method="POST" action="" />
	<p>your kanji go here: <input type="text" name="kanji"/></p>
</form>
<?php

$overall_all = 0;
$overall_of = 0;

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
		$overall_all += $all;
		$overall_of += $of;
		echo '<br />('.$of.'/'.$all.')';
		echo '<br />[overall: '.$overall_of.'/'.$overall_all.' - missing: '.($overall_all-$overall_of).']</p>';
		}
	}

?>
<hr />
<p><strong>about</strong></p>
<p>kanji lists obtained from here: <?php echo $from_str; ?></p>
</body>
</html>
