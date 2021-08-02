<?php
// echo "<pre>"; print_r($_FILES['docx']);die();
$headers = array(
	'Content-type: multipart/form-data'
); 

$url = "http://49.207.184.83:5004/upload";
    
$csv_file = new CURLFile($_FILES['docx']['tmp_name'],$_FILES['docx']['type'],$_FILES['docx']['name']); 

$post_data = array(
	"file" => $csv_file
);
$curl = curl_init();
// curl_setopt($curl, CURLOPT_VERBOSE, true);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($curl);
// $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl); 
 $html = file_get_contents('template/'.$_POST['template']); //get input html file
 $dir = "ResumeTask";
 if(is_dir($dir) === false )
 {
     mkdir($dir);
 }
 $file_name_complete =  'resumedoc.docx';
 // Extract file extension
 $extension = pathinfo($file_name_complete, PATHINFO_EXTENSION);
 // Extract file name without extension
 $file_name = pathinfo($file_name_complete, PATHINFO_FILENAME);
 // Save an original file name variable to track while renaming if file already exists
 $file_name_original = $file_name;
 $num = 1;
 // checking if file already exists
 while (file_exists($dir . '/'  . $file_name . "." . $extension)) {
     $file_name = (string) $file_name_original . $num;
     $file_name_complete = $file_name . "." . $extension;
     $num++;
 }
 // copying data fron html file to word document
 $file = fopen($dir . '/' . $file_name_complete,"w+");
 // $json = file_get_contents("json/".$_POST['json']);
 // echo $json;die();
 $data='';
 $placeholder_key = ['Skill','Education','Projects','Objective','Certificate','Activities'];
 $placeholder_value = ['data_skill','data_education','data_projects','data_objective','data_certificate','data_activities'];
 foreach (json_decode($response) as $key => $value) { 	
 	if(in_array($key, $placeholder_key)){
 		$key_key = array_search ($key, $placeholder_key);
 		$html = str_replace($placeholder_value[$key_key],      $value,       $html);
 	}else{
 		if(strtoupper($key)!='END'){
 		$data.='<br /><br /><div style="font-family: Arial, Helvetica, sans-serif!important;">
 		<div style="font-size: 24px"><b>'.strtoupper($key).':</b> </div>
 		<span style="font-size: 20px"> '.$value.'</span>
 		</div>';
 		}
 	}
 }
 foreach ($placeholder_value as $keyP => $valueP) {
 	$html = str_replace($valueP,      'Enter your text here',       $html);
 }
 

// $html = str_replace('u0096',      '&bull;',       $html);

$html = str_replace("data_content",      $data,       $html);
// file_put_contents($dir . '/' . $file_name_complete, $html);
 fwrite($file, $html);
 // closes the file
 fclose($file);
 echo "Success";

$headers1 = array(
	'Content-type: application/json'
); 

$url1 = "http://2c353e858fd3.in.ngrok.io/convert";
    // echo $file_name_complete;

$html1 = file_get_contents('ResumeTask/'.$file_name_complete);    

$post_data1 = array(
	"file" => trim(str_replace("'", "\'", $html1))
);
$curl1 = curl_init();
// curl_setopt($curl, CURLOPT_VERBOSE, true);
curl_setopt($curl1, CURLOPT_HEADER, false);
curl_setopt($curl1, CURLOPT_POST, true);
curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl1, CURLOPT_URL, $url1);
curl_setopt($curl1, CURLOPT_POSTFIELDS, json_encode($post_data1));
curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers1);
$response1 = curl_exec($curl1);
// $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl1); 

// print_r($response1);
 header("Location: http://localhost/resume_creator/basic/ResumeTask/".$file_name_complete); 
?>