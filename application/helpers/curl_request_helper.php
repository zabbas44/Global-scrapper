<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $flag_error;
global $ch;
$flag_error = false;

function printr($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    exit;
}

function curl_login($ch, $link, $username, $password) {
    $ch = curl_init();
    $url = $link;
    //username and password of account
    $username = trim($username);
    $password = trim($password);

    //set the directory for the cookie using defined document root var
    $dir = "/ctemp";
    //build a unique path with every request to store 
    //the info per user with custom func. 
    //login form action url

    $postinfo = "login=" . $username . "&password=" . $password;

    $cookie_file_path = $dir . "/cookie.txt";

    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    //set the cookie the site has for certain features, this is optional
    curl_setopt($ch, CURLOPT_COOKIE, "cookiename=0");
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
    curl_exec($ch);
}


/*
 * Helper FUnctions
 */
function get_field_record($arr,$name){
    if(is_array($arr)){
        foreach($arr as $key=>$val){
            if($val['name']==$name){
                return $val;
            }
        }
        return array();
    }
}
function get_field_value($arr,$name){
    if(is_array($arr)){
       $product_id_arr = get_field_record($arr,$name);
       if(sizeof($product_id_arr)>0){
           return $value = $product_id_arr['value'];
       }
       return '';
    }
}
function curl_request_parameters($ch,$link, $data){
   global $ch;
   $ch = curl_init();
    //url-ify the data for the POST
   $fields_string ='';
   foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
   rtrim($fields_string, '&');
   
   //set the url, number of POST vars, POST data
   curl_setopt($ch,CURLOPT_URL, $link);
   curl_setopt($ch,CURLOPT_POST, count($data));
   curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
   curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
   
   $html = curl_exec($ch);
  // $html = str_get_html($html);
//   printr(json_decode($html,true));
   return $html;
}

function simple_curl_request($link){
    global $ch;
    $ch = curl_init();
//    $link = '';
   //url-ify the data for the POST
//    curl_setopt($ch, CURLOPT_URL, $link);
//    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
//    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
//    $html = curl_exec($ch);
    
    curl_setopt($ch, CURLOPT_URL, $link);
    $header = array();
    $header[0]  = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
    //$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[]   = "Cache-Control: private";
    $header[]   = "Connection: keep-alive";
            //$header[]   = "Host: http://localhost/fbombmedia_udirect";
    $header[]   = "Keep-Alive: 300";
    $header[]   = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $header[]   = "Accept-Language: en-US,en;q=0.5";
    $header[]   = "Pragma: "; // browsers keep this blank.
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar);
    //curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar);

    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POST, count($data));
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

    $html = curl_exec($ch);
    curl_close($ch);
    
    
    $html = str_get_html($html);
    return $html;
}
/*
 * Curl Login Request
 */
function curl_request(){
    global $ch;
    $url = 'https://trade.4over.com/login.php';
    $username = 'info@printinginflorida.com';
    $password = '4over9015';
    $ch = curl_init();
    curl_login($ch, $url, $username, $password);
    return $ch;
}


function CSV_export(){
    $sel_query = "Select a.*,b.* From
            tbl_product_info a INNER JOIN tbl_product_detail b ON (a.p_id=b.product_id_FK)
            order By a.id 
            ";
    $result = mysql_query($sel_query) or die(mysql_error);
    if(mysql_num_rows($result)>0){
        $values_query=$sel_query;
        $fieldseparator=','; //excel needs comma rather than semi colon
        $download_file=1; //should the file be downloaded from browser(1) or saved to the server(0)?
        $filename = 'scrapper_csv'; //contains name of download file or (depending on $download_file) the path to save csv file without file extension.
    
        $colums_arr = array('id','prodcut_id','product_code','Product_Name','Category','Product Link','Price','Reward','size','color','Turn around','ship options','Radius Corner',
            'Date','Date Modified');
        $lineseparator = "\n";
	
	//GET COLUMNS::::::
		$csv_output = '';
		$i = 0;
		if (sizeof($colums_arr) > 0) {
			while ($i < sizeof($colums_arr)) {
				$csv_output .= $colums_arr[$i].$fieldseparator." ";
				$i++;
			}
		}
		$csv_output .= "\n";
	
	
	//GET VALUES:::::::::::::::
                $j=1;
	while ($rowr = mysql_fetch_row($result,MYSQL_ASSOC)) {
//		printr($rowr);
                $csv_output .= $j.$fieldseparator." ";
                $csv_output .= $rowr['p_id'].$fieldseparator." ";
                $csv_output .= $rowr['product_code'].$fieldseparator." ";
                $csv_output .= $rowr['p_name'].$fieldseparator." ";
                $csv_output .= $rowr['p_cate_name'].$fieldseparator." ";
                $csv_output .= $rowr['p_link'].$fieldseparator." ";
                $csv_output .= $rowr['p_price'].$fieldseparator." ";
                $csv_output .= $rowr['reward'].$fieldseparator." ";
                $csv_output .= $rowr['size'].$fieldseparator." ";
                $csv_output .= $rowr['color'].$fieldseparator." ";
                $csv_output .= $rowr['turn_around'].$fieldseparator." ";
                $csv_output .= $rowr['ship_options'].$fieldseparator." ";
                $csv_output .= $rowr['radius_corner'].$fieldseparator." ";
                $csv_output .= $rowr['date'].$fieldseparator." ";
                $csv_output .= $rowr['date_modified'].$fieldseparator." ";
                
		
		//$csv_output=trim($csv_output,$fieldseparator." "); //trim trailing ; from end of line (disrupts import functions
		$csv_output .= $lineseparator;
                $j++;
	}
	
	
	//OUTPUT RESULTS::::::::::::::
	if($download_file){ //DOWNLOAD:
		header("Content-type: application/vnd.ms-excel");
		header("Content-disposition: csv" . date("Y-m-d") . ".csv");
		header( "Content-disposition: filename=".$filename.".csv");
		echo $csv_output;
	}else{//SAVE TO SERVER:
		$fh = fopen($filename.'.csv', 'w') or die("can't open file");
		fwrite($fh, $csv_output);
		fclose($fh);
		if(file_exists($filename.'.csv')){return (1);}else{return(0);}
	}
        
        while($row = mysql_fetch_array($result)){
            printr($row);
        }
    }
}
?>
