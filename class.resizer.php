<?php
class resizeThis{
 
    var $sourceImage; /* initialize source image */
    var $ext;				/* Get image extension */
    
    function do_upload() /* firstly lets upload the image */
	{
	if($_FILES['category_image']['size']>0)
	{
	$dir='../images/category_images';
	$filename1=$_FILES['category_image']['name'];
	$srcfile=$_FILES['category_image']['tmp_name'];
	$targetfile=$dir.'/'.$filename1;
	if(move_uploaded_file($srcfile, $targetfile))
	{		
		return $filename1;
	}
	else 
	{		
	return $filename1; /* this returns the uploaded image name */
	}
	}
	}
 
    function load($source){
    	$source = '../images/category_images/'.$source; /* get the source directory */
    //echo $source; die();
    	//$source = $this->do_upload();
        $this->ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));
         if($this->ext == "jpg"){
            $this->sourceImage = imagecreatefromjpeg($source);
        }elseif($this->ext == "gif"){
            $this->sourceImage = imagecreatefromgif($source);
        }elseif($this->ext == "png"){
            $this->sourceImage = imagecreatefrompng($source);
        }
    }
 
    function getWidth(){
        return @imagesx($this->sourceImage);
    }
 
    function getHeight(){
        return @imagesy($this->sourceImage);
    }
 
    function resizeToHeight($height){
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width,$height);
    }
 
    function resizeToWidth($width){
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width,$height);
    }
 
    function scale($scale){
        $width = $this->getWidth() * $scale/100;
        $height = $this->getheight() * $scale/100;
        $this->resize($width,$height);
    }
 
    function resize($width,$height){
        $newImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($newImage, $this->sourceImage, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->simagejpegourceImage = $newImage;
    }
 
    function crop($width,$height,$x_pos=0,$y_pos=0){
        $newImage = imagecreatetruecolor($width, $height);
 
        if(@$this->getWidth()/$this->getHeight() != @$width/$height){
            $width_temp=$width;
            $height_temp=$height;
 
            if($this->getWidth()/$this->getHeight()>$width/$height){
                $width = $this->getWidth()*$height/$this->getHeight();
                $x_pos = -($width-$width_temp)/2;
                $y_pos = 0;
            }else{
                @$height = $this->getHeight()*$width/$this->getWidth();
                $y_pos = -($height-$height_temp)/2;
                $x_pos = 0;
            }
        }
 
        @imagecopyresampled($newImage, $this->sourceImage, $x_pos, $y_pos, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->sourceImage = $newImage;
    }
 
    function save($source, $comp=80){
    	 $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));
    	  if($ext == "jpg"){
            imagejpeg($this->sourceImage, $source, $comp);
        }elseif($ext == "gif"){
            imagegif($this->sourceImage, $source,5);
        }elseif($ext == "png"){
            imagepng($this->sourceImage, $source,9);
        }
    }
 
    function output($ext="jpg"){
        if($ext == "jpg"){
            imagejpeg($this->sourceImage);
        }elseif($ext == "gif"){
            imagegif($this->sourceImage);
        }elseif($ext == "png"){
            imagepng($this->sourceImage);
        }
    }
    
   
 
 
}

?>