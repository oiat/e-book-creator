<?php
include("../includes/session.php");
if(!$session->logged_in){
header("location:/");
exit();
}

/**
 * Handle file uploads via XMLHttpRequest
 */
 
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSize()){            
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}


class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;
	private $_db;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
		
		$this->_db = new MySQLDB();
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = TRUE){
		global $session;
		
		$widget_id = $_GET['widget_id'];
		// get $uploadDirectory
		$q = "SELECT a.book_id, b.uid FROM " . TBL_BOOKS_STRUCTURE . " as a, " . TBL_BOOKS . " as b WHERE a.id='$widget_id' and a.book_id=b.id";
		$result = mysql_query($q, $this->_db->connection);
		$row = mysql_fetch_row($result);
		$book_id = $row[0];
		$uid = $row[1];
		
		$uploadDirectory = CO_PATH.'/books/'.$uid.'/uploads/';
		//$pdfDirectory = CO_PATH.'/books/'.$uid.'/'.$book_id.'/Resources/Templates/print/';
		
		
        if (!is_writable($uploadDirectory)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }
        
        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('error' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }
		setlocale(LC_ALL, 'en_US.UTF8');
		$pathinfo = pathinfo(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $this->file->getName()));
		
        //$filename = str_replace(" ", "_", $pathinfo['basename']);

		$filename = $pathinfo['filename'];
		$filename = 'cover';
        $ext = strtolower($pathinfo['extension']);

        if($this->allowedExtensions && !in_array($ext, $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
			$pattern = '/(.+)\_([0-9]+)\_$/';
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                if(preg_match( $pattern, $filename, $matches)) {
					$num = $matches[2]+1;
					$filename = $matches[1] . '_' . $num . '_';
					//echo $filename;
				} else {
					$filename .= '_1_';
				}
            }
        }
        $widget_id = $_GET['widget_id'];
        if ($this->file->save($uploadDirectory . 'c_' . $widget_id . '.' . $ext)){
			//$fsave = '' . $filename . '.' . $ext . '';
			$fsave = 'c_' . $widget_id . '.' . $ext . '';
			
			$forig = $uploadDirectory . 'c_' . $widget_id . '.' . $ext;
			// resample file
			$img_size = getimagesize($forig);
			$x_size = $img_size[0];
			$y_size = $img_size[1];
			if($x_size > 800 || $y_size > 800) {
				$w = number_format(800, 0, ',', '');
				$h = number_format(($y_size/$x_size)*800,0,',','');
				$dest = imagecreatetruecolor($w, $h);
				imageantialias($dest, TRUE);
				if($ext == 'jpg' || $ext == 'jpeg') {
					$src = imagecreatefromjpeg($forig);
				}
				if($ext == 'png') {
					$src = imagecreatefrompng($forig);
				}
				imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $x_size , $y_size );
				if($ext == 'jpg' || $ext == 'jpeg') {
					imagejpeg($dest, $forig, 100);
				}
				if($ext == 'png') {
					imagepng($dest, $forig,0);
				}
			}
			
			
			$now = gmdate("Y-m-d H:i:s");
			$q = "UPDATE " . TBL_BOOKS_STRUCTURE . " set content='$fsave' WHERE id='$widget_id'";
			$result = mysql_query($q, $this->_db->connection);

			return array("success"=>true,"id"=>"$widget_id","uid"=>"$uid","book_id"=>"$book_id","image"=>"$fsave");
        } else {
            return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
        
    }    
}

// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$allowedExtensions = array('jpg','jpeg');
// max file size in bytes
$sizeLimit = 2 * 1024 * 1024;

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload(CO_PATH.'/books/'.$session->uid.'/uploads/');
// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
?>