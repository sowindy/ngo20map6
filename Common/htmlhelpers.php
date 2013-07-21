<?php


// insert a <script> tag
function js($str){
	return '<script type="text/javascript" src="'.__APP__.'/Public/js/'.$str.'.js"></script>';
}

// insert css file
function css($str){
	return '<link href="'.__APP__.'/Public/css/'.$str.'.css" rel="stylesheet"/>';
}

// insert url of uploaded image or thumbnail
function thumb($str, $thumb_level = 0){
	if(is_array($str)){
		if(isset($str['image'])){
			$str = $str['image'];
		}
	}

	if($thumb_level == 0){
		return __APP__.'/Public/Uploaded/'.$str;
	}
	else{
		return __APP__.'/Public/Uploaded/thumb'.$thumb_level.'_'.$str;
	}
}

// print default text if string is empty
function place($str, $ifempty = "暂无"){
	if(empty($str)){
		return $ifempty;
	}
	else{
		return $str;
	}
}

/* filter GET and POST data before use */
function cleanInput($input) {

	$search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
    );

	$output = preg_replace($search, '', $input);
	return $output;
}

function san($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = san($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = mysql_real_escape_string($input);
    }
    return $output;
}

// back to the previous page
function back(){
	if(isset($_SESSION['last_page'])){
        redirect($_SESSION['last_page']);
        return true;
    }
    else{
        return false;
    }
}

function flash($content, $type='error'){
	$_SESSION['flash']['type'] = $type;
	$_SESSION['flash']['content'] = $content;
}

?>