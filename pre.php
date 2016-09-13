<?php
#change for git desktop
function __autoload($class_name)
{
    
    $root = ini_get('doc_root');
    strlen($root) < 1 ? $root = $_SERVER['DOCUMENT_ROOT'] : $root = $root;

    if(file_exists("$root/class/$class_name.php"))
    {
        include "$root/class/$class_name".'.php';
    }
}
// add option for strings : / 
function mypr($some)
{
    $html = "<pre>";
    if(is_array($some))$html .=  print_r($some, true);
    if(is_object($some))$html .= print_r(get_object_vars($some), true);
    $html .= "</pre>";
    return $html;
}


function convertUtf8($string)
{
    $newstring = mb_convert_encoding($string, 'UTF-8');
    return $newstring;
}

$INPUT = array();

if(isset($_GET))
{
    foreach($_GET as $key => $val)
    {
        $INPUT[$key] = $val;
    } 
}

if(isset($_REQUEST))
{
    foreach($_REQUEST as $key => $val)
    {
        $INPUT[$key] = $val;
    } 
}

if(isset($_POST))
{
    foreach($_POST as $key => $val)
    {
        $INPUT[$key] = $val;
    } 
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
	$ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function debug_string_backtrace()
{ 
    ob_start(); 
    debug_print_backtrace(); 
    $trace = ob_get_contents(); 
    ob_end_clean(); 
    // Remove first item from backtrace as it's this function which 
    // is redundant. 
    $trace = preg_replace ('/^#0\s+' . __FUNCTION__ . "[^\n]*\n/", '', $trace, 1); 
    // Renumber backtrace items. 
    $trace = preg_replace ('/^#(\d+)/me', '\'#\' . ($1 - 1)', $trace); 
    return $trace; 
} 




function formatJSON($json, $html = false) {
    $tabcount = 0; 
    $result = ''; 
    $inquote = false; 
    $ignorenext = false; 
    if ($html) { 
        $tab = "&nbsp;&nbsp;&nbsp;"; 
        $newline = "<br/>"; 
    } else { 
        $tab = "\t"; 
        $newline = "\n"; 
    } 
    for($i = 0; $i < strlen($json); $i++) { 
        $char = $json[$i]; 
        if ($ignorenext) { 
            $result .= $char; 
            $ignorenext = false; 
        } else { 
            switch($char) { 
                case '{': 
                    $tabcount++; 
                    $result .= $char . $newline . str_repeat($tab, $tabcount); 
                    break; 
                case '}': 
                    $tabcount--; 
                    $result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char; 
                    break; 
                case ',': 
                    $result .= $char . $newline . str_repeat($tab, $tabcount); 
                    break; 
                case '"': 
                    $inquote = !$inquote; 
                    $result .= $char; 
                    break; 
                case '\\': 
                    if ($inquote) $ignorenext = true; 
                    $result .= $char; 
                    break; 
                default: 
                    $result .= $char; 
            } 
        } 
    } 
    return $result; 
}

function mediaTimeDeFormater($seconds)
{
    if (!is_numeric($seconds))
        // throw new Exception("Invalid Parameter Type!");
        settype($seconds, "integer");


    $ret = "";

    $hours = (string )floor($seconds / 3600);
    $secs = (string )$seconds % 60;
    $mins = (string )floor(($seconds - ($hours * 3600)) / 60);

    if (strlen($hours) == 1)
        $hours = "0" . $hours;
    if (strlen($secs) == 1)
        $secs = "0" . $secs;
    if (strlen($mins) == 1)
        $mins = "0" . $mins;

    if ($hours == 0)
        $ret = "$mins:$secs";
    else
        $ret = "$hours:$mins:$secs";

    return $ret;
}




?>