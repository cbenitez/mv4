<?php
function pr($data){
    print "<pre>\n";
    print_r($data);
    print "</pre>\n";
}

function Error($message){
	clearBuffer();
	print '<html><head><title>' . $message . '</title></head><body style="background-color:#fdfdfd;">';
	print '<pre><h1>Error</h1></pre>';
	pr('<span style="color:#f00; font-size:16px;"><strong>' . $message . '</strong></span>');
	pr('<em>' . $_SERVER['REQUEST_METHOD'] . " ($_SERVER[SERVER_PROTOCOL]) : " . $_SERVER['SERVER_NAME'] . ( $_SERVER['SERVER_PORT'] != "80" ? ":" . $_SERVER['SERVER_PORT'] : "" ) . $_SERVER['REQUEST_URI'] . '</em>');
	print '</body></html>';
	exit;
}

function redirect($uri){
	session_write_close();
	clearBuffer();
	header("Location: $uri");
	exit;
}

function setNotFound(){
	clearBuffer();
	header("HTTP/1.1 404 Not Found");
	exit;
}

function setUnauthorized($str="Unauthorized"){
	clearBuffer();
	header("HTTP/1.1 401 Unauthorized");
	Error($str);
}

function setLocked($str="Locked"){
	clearBuffer();
	header("HTTP/1.1 423 Locked");
	Error($str);
}

function setApplicationJavascript(){
	clearBuffer();
	header("Content-type: application/x-javascript");
}

function setApplicationJSON(){
	clearBuffer();
	header("Content-type: application/json");
}

/**
 * Previene ClickJacking
 */
function set_x_frame_deny(){
    clearBuffer();
    header('X-Frame-Options: DENY');
}

/**
 * Protecion contra XSS
 */
function set_xss_protection(){
    header("X-Content-Security-Policy: allow 'self'; frame-ancestors 'none'");
    header("X-XSS-Protection: '1'; mode='block'");
}

/**
 * Evitar lectura de Content-type
 */
function set_block_read_content_type(){
    header("X-Content-Type-Options: nosniff");
}

/**
 * Cookies seguros
 */
function set_cookie_secure(){
    ini_set("session.cookie_httponly", "True");
    ini_set("session.cookie_secure", "True");
}

/**
 * Compresion
 */
function sanitize_output($buffer)
{
    $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s',       // shorten multiple whitespace sequences
        '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/' // Comentarios html (sin quitar las excepciones de IE)
		);
    $replace = array(
        '>',
        '<',
        '\\1',
		''
        );
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}

function hule($str=NULL){
	die($str);
}

function getIpAddress() {
	if(empty($_SERVER['HTTP_CLIENT_IP'])):
		if(empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
			$ip = $_SERVER['REMOTE_ADDR'] . "R";
		else:
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] . "F";
		endif;
	else:
		$ip = $_SERVER['HTTP_CLIENT_IP'] . "C";
	endif;
	return $ip;
}

function clearBuffer(){
	if(ob_get_length()):
		ob_end_clean();
	endif;
}

function slugit($string){
	$string = mb_strtolower($string,'UTF-8');
	$chars  = array("á","ä","â","à","é","ë","ê","è","í","ï","î","ì","ó","ö","ô","ò","ú","ü","û","ù","ñ");
	$repla  = array("a","a","a","a","e","e","e","e","i","i","i","i","o","o","o","o","u","u","u","u","n");
	$string = str_replace($chars, $repla, $string);
	$string = preg_replace("/[^a-zA-Z0-9\s]/", "", $string);
	$string = explode(" ", $string);
	$rtn = "";
	foreach($string as $str):
		if(strlen(trim($str)) > 0):
			$rtn .= $str . "-";
		endif;
	endforeach;

	$rtn = substr($rtn,0,-1);

	return $rtn;
}

function file_get_contents_utf8($fn) {
	$content = file_get_contents($fn);
	return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}

/*genera codigo aleatorio*/
/*Longitud variable entre (int)@minLen y (int)@maxLen*/
function uniqcode($minLen=5,$maxLen=9,$sym=true){

	// [1] Letras Mayusculas de la A a la Z (65-90)
	// [2] Letras Minusculas de la A a la Z (97-122)
	// [3] Numeros del 0 al 9 (48-57)
	// [4] Caracterees ()*+ (40-43)
	// [5] Caracteres -. ()(45-46)
	$ret = "";
	$totalLen = ($minLen == $maxLen) ? $maxLen : rand($minLen, $maxLen);
	$maxblock = $sym ? 5 : 3;
	for($len = 1; $len <= $totalLen; $len++):
		$block = rand(1,$maxblock);
		switch($block):
			case 1:
				$char = chr(rand(65,90));
				break;
			case 2:
				$char = chr(rand(97,122));
				break;
			case 3:
				$char = chr(rand(48,57));
				break;
			case 4:
				$char = chr(rand(40,43));
				break;
			case 5:
				$char = chr(rand(45,46));
				break;
		endswitch;

		$ret .= $char;

	endfor;

	return $ret;
}

function randomnumbers($minLen=5,$maxLen=11,$zeroFill=true){
	$totalLen = ($minLen == $maxLen) ? $maxLen : rand($minLen, $maxLen);
	$ret = "";
	for($len = 1; $len <= $totalLen; $len++):
		$ret .= rand(0,9);
	endfor;

	return strlen($ret) == $maxLen ? $ret : ( $zeroFill ? str_pad($ret, $maxLen, "0", STR_PAD_LEFT) : $ret );
}


function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb");

    $data = explode(',', $base64_string);

    fwrite($ifp, base64_decode($data[1]));
    fclose($ifp);

    return $output_file;
}
?>
