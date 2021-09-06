<?php
class upload{
    //public $src = "upload/";
    public $src;
    public $tmp;
    public $filename;
    public $new_file_name;
    public $getFe=array();
    public $typefl;
    public $uploadfile;
    public $source;
    public $destination;
    public $quality='95';
    public $get_file_type;
    public $get_file_size;
    public $get_file_loaction;
    public $get_file_name;
    public $type = array("PNG", "png", "jpeg", "JPEG", "jpg", "JPG",'GIF','gif');
    public $typePdf = array('PDF','pdf');
    public $sms = array();

//    function __construct(){
//	
//	
//    } 
    
    public function uploadfile($type,$file_name,$loaction,$size){
	
	if(trim($type)=='img_pdf'){
	    $this -> type =array_merge($this -> type,$this -> typePdf);
	}
	$this -> get_file_type =trim($type);
	$this -> file_name =trim($file_name);
        $this -> loaction =trim($loaction);
        $this -> src =trim($loaction);
        $this -> size =trim($size);
	$this -> filename = $_FILES[$this -> file_name]["name"];
        $this -> tmp = $_FILES[$this -> file_name]["tmp_name"];
        $temp = explode(".", $_FILES[$this -> file_name]["name"]);
	$this -> new_file_name =date('Ymdhis')."-".rand(10,100)."-". basename($this -> file_name).".".end($temp);
	$this -> uploadfile = $this -> src .$this -> new_file_name;
	$this -> getFe = pathinfo($this ->filename);
        $this -> typefl = $this -> getFe['extension'];
	
	
	//size
	if(in_array($this -> typefl, $this -> typePdf)){
	    if($_FILES[$this -> file_name]["size"] > $this -> size){
		$smsN= "Please ensure your chosen file is less than ".(($this -> size)/1000000)."MB.";
		return $this -> sms= array('status'=>'0','sms'=>$smsN);
	    }
	}
	//extens
	if($this -> get_file_type =='img'){
	    if(!in_array($this -> typefl, $this -> type)){
		$smsN='Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
		return $this -> sms= array('status'=>'0','sms'=>$smsN);
	    }
	}
	elseif($this -> get_file_type =='img_pdf'){
	    if(!in_array($this -> typefl, $this -> type)){
		$smsN='Sorry, only JPG, JPEG, PNG,GIF, & PDF files are allowed to upload.'; 
		return $this -> sms= array('status'=>'0','sms'=>$smsN);
	    }
	}
	else{
	    if(!in_array($this -> typefl, $this -> typePdf)){
		$smsN='Sorry, only PDF files are allowed to upload.'; 
		return $this -> sms= array('status'=>'0','sms'=>$smsN);
	    }
	}
	if(in_array($this -> typefl, $this -> typePdf)){
	    if(move_uploaded_file($this -> tmp, $this -> uploadfile)){
		return $this -> sms= array('status'=>'1','sms'=>$this -> new_file_name);
	    }
	}
	else{
	    $source=$this -> tmp;
	    $destination=$this -> uploadfile;
	    $quality=$this -> quality;
	    // Get image info 
	    $imgInfo = getimagesize($source); 
	    $mime = $imgInfo['mime']; 

	    // Create a new image from file 
	    switch($mime){ 
		case 'image/jpeg': 
		    $image = imagecreatefromjpeg($source); 
		    break; 
		case 'image/png': 
		    $image = imagecreatefrompng($source); 
		    break; 
		case 'image/gif': 
		    $image = imagecreatefromgif($source); 
		    break; 
		default: 
		    $image = imagecreatefromjpeg($source); 
	    } 
	    list($width, $height) = getimagesize($source);
	    $newWidth=1024;
	    $newHeight=786;
	    if($newWidth<$width){
		$newHeight = ($height / $width) * $newWidth;
		$tmp = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($tmp, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height); 
	    }
	    else{
		$tmp=$image;
		if($this -> size >=12000000){
		    $quality=45;
		}
		elseif($this -> size >=2000000){
		    $this -> size=75;
		}
		elseif($size >=1000000){
		    $this -> size=85;
		}
	    }
	    // Save image 
	    imagejpeg($tmp, $destination, $quality); 
	    // Return compressed image 
	    return $this -> sms= array('status'=>'1','sms'=>$this -> new_file_name);
	    
	}
    }
    
}
// call function
//uploadfile($type,$file_name,$loaction,$size);
?>
