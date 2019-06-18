<?php
class _Image{

	static function save_from_url($url){
		$path = UF ;
		if(!file_exists($path)):	//没有文件夹创建
			mkdir($path, 0755, true);
			chmod($path, 0755);
		endif;
		$fn = random(16);
		$fl = explode('.', basename($url));
		$ext = $fl[count($fl) - 1];

		while(file_exists($path . $fn . '.' . $ext)){
			$fn = random(16);
		}
		$ori = file_get_contents($url);

		// $ori = imagecreatefromwebp($url);

		// // Convert it to a jpeg file with 100% quality
		// $ori = imagejpeg($im, './example.jpeg', 100);

		file_put_contents($path . $fn . '.' . $ext, $ori);
		return $fn . '.' . $ext;
	}

	static function save_from_upload($file = null){
		//var_dump($_FILES['data']);
		if(!@$_FILES['data']['name']){return null;}
		$count = count($_FILES['data']['name']);
		#print_r($_FILES['data']);
		for($i = 0; $i < $count; $i++ ){
			foreach($_FILES['data'] as $k => $v):
				$IMGS[$i][$k]	=	$_FILES['data'][$k][$i];
			endforeach;
		}
		$target_dir = UF;
		$uploadOk = 1;

		foreach ($IMGS as $IMG) :
			$target_file = $target_dir . basename($IMG["name"]);
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($IMG["tmp_name"]);
			    if($check !== false) {
			        echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}

			$info = pathinfo($IMG['name']);
			$ext = $info['extension']; // get the extension of the file
			$newname =  rid("16") . "." . $ext; 

			$path = UF . '/products/';
			if(!file_exists($path)):	//没有文件夹创建
				mkdir($path, 0755, true);
				chmod($path, 0755);
			endif;

			$target = $path . $newname;
			#move_uploaded_file( $_FILES['image']['tmp_name'], $target);

			$resized = self::resize($IMG['tmp_name']);
			imagejpeg($resized, $path . $newname, 100); 
			//file_put_contents($path . $newname . '.' . $ext, $resized);
			$arr[]['url'] = HOME . "uploads/products/" .$newname;
		endforeach;
		return $arr;
	}

	static function remove($file){
		try{
			if(file_exists(GPATH . "/public/" . $file)){
				unlink(GPATH . "/public/" . $file);
			}
		}catch(Excetpion $e){
			return false;
		}
	}

	protected function save_avatar($image){
		$type = strtolower(_REF(1));
		switch ($type) {
			case 'agency':
				$con = new _Agency();
				$con->build($con->find(_REF(2)));
				break;
			case "client":
				$con = new _Client();
				$con->build($con->find(_REF(2)));
				break;
			case "user":
				$con = new _User();
				$con->build($con->find(_REF(2)));
				break;
			default:
				return false;
				break;
		}
		$data = array("image"	=> $image, "type"	=> $type, "type_id"	=>	$con->id);
		try{
			$db = new _DB();
			$sql = "INSERT INTO avatar (image, type, type_id) VALUES (:image, :type, :type_id)";
			$res = $db->insert($data, $sql);
			if($res){
				return true;
			}else{
				return false;
			}
		}catch(Excetpion $e){
			return false;
		}
	}

	static protected function resize($fin, $max = 500){		
		ini_set('memory_limit', '8096M');
		$fn = $fin;
		$size = getimagesize($fn);
		$ratio = $size[0]/$size[1]; // width/height
		if( $ratio > 1) {
		    $width = $max;
		    $height = $max/$ratio;
		}
		else {
		    $width = $max*$ratio;
		    $height = $max;
		}
		$src = imagecreatefromstring(file_get_contents($fn));
		$dst = imagecreatetruecolor($width,$height);
		imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
		imagedestroy($src);
		return $dst;
		//imagepng($dst,$target_filename_here); // adjust format as needed
		//imagedestroy($dst);
	}

	static function delete_img($name){

	}

}
?>