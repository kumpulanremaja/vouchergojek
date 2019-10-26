<?php
function curl($url, $data = null, $headers = null, $proxy = null) {

	$ch = curl_init();
	$options = array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_HEADER => true,
		CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
	);

	if ($data != "") {
		$options[CURLOPT_POST] = true;
		$options[CURLOPT_POSTFIELDS] = $data;
	}

	if ($proxy != "") {
		$options[CURLOPT_HTTPPROXYTUNNEL] =  true;
		$options[CURLOPT_PROXYTYPE] =  CURLPROXY_SOCKS4;
		$options[CURLOPT_PROXY] =  $proxy;
	}

	if ($headers != "") {
		$options[CURLOPT_HTTPHEADER] = $headers;
	}

	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;

}

function fetch_value($str,$find_start,$find_end) {
	$start = @strpos($str,$find_start);
	if ($start === false) {
		return "";
	}
	$length = strlen($find_start);
	$end    = strpos(substr($str,$start +$length),$find_end);
	return trim(substr($str,$start +$length,$end));
}

function getcookies($source) {
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $source, $matches);
	$cookies = array();
	foreach($matches[1] as $item) {
		parse_str($item, $cookie);
		$cookies = array_merge($cookies, $cookie);
	}
	return $cookies;
}

function number($length) {
	$characters = '0123456789';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function string($length) {
	$characters = 'abcdefghijklmopqrstuvwxyz';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function nama()
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	// $rand = json_decode($rnd_get, true);
	preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
	return $name[2][mt_rand(0, 14) ];
	}


?>
