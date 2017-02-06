<?php  
/**
* 
*/
class Notification
{
	
	function sendMessageAndroid($idNoticia , $mensaje){
		$content = array(
			"en" => $mensaje
			);
		
		$fields = array(
			'app_id' => "70f89bba-c190-4195-ba99-44ac183508a7",
			'included_segments' => array('Active Users'),
			'data' => array("foo" => "bar", "idNoticia" => $idNoticia),
			'contents' => $content
		);
		
		$fields = json_encode($fields);
    	/*print("\nJSON sent:\n");
    	print($fields);*/
		$ch = curl_init();
		$proxy="172.16.224.4:8080";
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic MzQ5NzVjYjctNmIyYi00NTRhLTg2NDUtYzhkZWIwNWI1NDAz'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
	
	/*	
		$response = sendMessageAndroid();
		$return["allresponses"] = $response;
		$return = json_encode( $return);
		print("\n\nJSON received:\n");
		print($return);
		print("\n");
	*/
}
?>