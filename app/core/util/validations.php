<?php
/**
 * Escape all HTML, JavaScript, and CSS
 *
 * @param string $input The input string
 * @param string $encoding Which character encoding are we using?
 * @return string
 */
function noHTML($input, $encoding = 'UTF-8')
{
    return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
}

function token($key){
	return Encryption::Encrypt($key);
}

function reverse_token($key){
	return Encryption::Decrypt($key);
}

function input_token($key){
    $token = token($key);
    print '<input type="hidden" name="'.$key.'_token" id="'.$key.'_token" value="'.$token.'" />';
}

function number($n){
	return is_numeric($n) ? number_format($n,0,"","") : 0;
}

function isValidEmail($email){
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
	if(!preg_match($regex, $email)):
		return false;
	else:
		return true;
	endif;
}

function pageNumber(){
	$_GET['page']	= isset($_GET['page']) 	? $_GET['page']		: 0;
	$_POST['page']	= isset($_POST['page'])	? $_POST['page']	: 0;
	return number($_GET['page']) == 0 ? number($_POST['page']) == 0 ? 1 : number($_POST['page']) : number($_GET['page']);
}

function param($param){
	return isset($_GET[$param]) ? cleanParam($_GET[$param]) : (isset($_POST[$param]) ? cleanParam($_POST[$param]) : "");
}

function numParam($param){
	$value = number(param($param));
	if(isset($_POST[$param])):
		$_POST[$param] = $value;
	elseif(isset($_GET[$param])):
		$_GET[$param] = $value;
	endif;
	return $value;
}

function cleanParam($param){
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Elimina javascript
    	'@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
    	'@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
    	'@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-línea
    );
    $param = preg_replace($search, '', $param);
    $param = str_replace("\'","", $param);
    $param = str_replace("'","", $param);
    $param = str_replace('\"',"", $param);
    $param = str_replace('"',"", $param);
	return trim(stripslashes(strip_tags($param)));
}

function haveRows($arr){
	return is_array($arr) && count($arr) > 0 ? true : false;
}

function cropWords($string, $limit = 20){
	$words = explode(" ", trim($string));
	$w = array();
	$crop="";

	//limpia todos los espacios entre las palabras
	foreach($words as $word):
		if(strlen(trim($word)) > 0):
			$w[] = trim($word);
		endif;
	endforeach;

	//une las palabras
	$limit = count($words) < $limit ? count($words) : $limit;
	for($i = 0; $i < $limit; $i++):
		$crop .= $w[$i] . " ";
	endfor;

	$more = count($w) > $limit ? "..." : "";
	return substr($crop,0,-1) . $more;
}

function passValidation($password){
   if(strlen($password) < 8){
      return false;
   }
   if(strlen($password) > 16){
      return false;
   }
   if (!preg_match('`[a-z]`',$password)){
      return false;
   }
   if (!preg_match('`[A-Z]`',$password)){
      return false;
   }
   if (!preg_match('`[0-9]`',$password)){
      return false;
   }
   return true;
}

function isJSON($string){
   return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

/*
* Establece el código de estado HTTP
*/
function setStatusCode($code, $description = null){
	$status_list = array(
		200 => _("OK"),
      	201 => _("Created"),
      	202 => _("Accepted"),
      	203 => _("Non-Authoritative Information"),
      	204 => _("No Content"),
      	205 => _("Reset Content"),
      	206 => _("Partial Content"),
      	207 => _("Multi-Status"),
      	208 => _("Already Reported"),
      	300 => _("Multiple Choices"),
      	301 => _("Moved Permanently"),
      	302 => _("Found"),
      	303 => _("See Other"),
      	304 => _("Not Modified"),
      	305 => _("Use Proxy"),
      	306 => _("Switch Proxy"),
      	307 => _("Temporary Redirect"),
      	308 => _("Permanent Redirect"),
      	400 => _("Bad request"),
      	401 => _("Unauthorized"),
      	403 => _("Forbidden"),
      	404 => _("Not found"),
      	405 => _("Method Not Allowed"),
      	406 => _("Not Acceptable"),
      	407 => _("Proxy Authentication Required"),
      	408 => _("Request Timeout"),
      	409 => _("Conflict"),
      	410 => _("Gone"),
      	411 => _("Length Required"),
      	412 => _("Precondition Failed"),
      	413 => _("Request Entity Too Large"),
      	414 => _("Request-URI Too Long"),
      	415 => _("Unsupported Media Type"),
      	416 => _("Requested Range Not Satisfiable"),
      	417 => _("Expectation Failed"),
      	422 => _("Unprocessable Entity"),
      	423 => _("Locked"),
      	424 => _("Failed Dependency"),
      	425 => _("Unassigned"),
      	426 => _("Upgrade Required"),
      	428 => _("Precondition Required"),
      	429 => _("Too Many Requests"),
      	431 => _("Request Header Fileds Too Large"),
      	451 => _("Unavailable for Legal Reasons"),
      	500 => _("Internal Server Error"),
      	501 => _("Not Implemented"),
      	502 => _("Bad Gateway"),
      	503 => _("Service Unavailable"),
      	504 => _("Gateway Timeout"),
      	505 => _("HTTP Version Not Supported"),
      	506 => _("Variant Also Negotiates"),
      	507 => _("Insufficient Storage"),
      	508 => _("Loop Detected"),
      	509 => _("Bandwidth Limit Exceeded"),
      	510 => _("Not Extended"),
      	511 => _("Network Authentication Required")
	);

	if(isset($status_list[$code])){
		header("HTTP/1.1 {$code} {$status_list[$code]}");
	}else{
		setStatusCode(406);
	}
}

?>
