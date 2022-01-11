<?php
/**
 * all of watermark functions is here
 */
trait Watermark
{
    protected $imageHeight = 0;
    protected $imageWidth = 0;
    protected $watermarkText="IT CORNER";
    protected $fontSize=50;
    protected $opacity = 7;
    protected $font;
    protected $image;
    
    // insert watermark
    protected function insert_watemark($target_file)
    {
        if(isset($this->config_data['watermark']) && $this->config_data['watermark']==true)
        {
            if(isset($this->config_data['watermark_type']))
            {
                $this->create_watermark($this->config_data['watermark_type'],$target_file);
            }
            else
            {
                $this->create_watermark("text",$target_file);
            }
        }
    }
    // create watermark
    protected function create_watermark($watermark_type,$target_file)
    {
        // Check type of water mark is selected 
        if($watermark_type == 'text'){
            // Add text watermark over image
            $watermark = $this->watermarkText; // Add water mark here
            $this->addTextWatermark($target_file, $watermark, $target_file);							
        } elseif($watermark_type == 'image'){
            // Add image watermark over image
            $watermark = dirname(__FILE__) . '/../images/default.png';
            $this->addImageWatermark ($target_file,$watermark);
        }
    }
    // create watermark with image
    // Function to add image watermark over image
    protected function addImageWatermark($target_file,$watermark)
    {
        // Load the watermarkImg$watermarkImg and the photo to apply the watermark to 
        switch(strtolower(pathinfo($watermark,PATHINFO_EXTENSION)))
        {
            case 'jpg':
                $watermarkImg = imagecreatefromjpeg($watermark); 
                break;
            case 'png':
                $watermarkImg = imagecreatefrompng($watermark); 
            break;
            case 'jpeg':
                $watermarkImg = imagecreatefromjpeg($watermark); 
            break;
            case 'gif':
                $watermarkImg = imagecreatefromgif($watermark); 
            break;
        }
        switch($this->imageFileType){ 
            case 'jpg': 
                $im = imagecreatefromjpeg($target_file); 
                break; 
            case 'jpeg': 
                $im = imagecreatefromjpeg($target_file); 
                break; 
            case 'png': 
                $im = imagecreatefrompng($target_file); 
                break; 
            default: 
                $im = imagecreatefromgif($target_file); 
        } 
        // resize watermark image
        $watermark_width = imagesx($watermarkImg);
        $watermark_height = imagesy($watermarkImg);
        // $percent = 0.5;
        // $newwidth = $watermark_width * $percent;
        // $newheight = $watermark_height * $percent;
        // $watermarkImg = imagecreatetruecolor($newwidth, $newheight);
        
        // Set the margins for the watermark 
        $marge_right = 0; 
        $marge_bottom = 0; 
            
        // Get the height/width of the watermark image 
        $sx = imagesx($watermarkImg);
        $sy = imagesy($watermarkImg);
        

        // Merge the stamp onto our photo with an opacity (transparency) of gigen transparency
        imagecopymerge($im, $watermarkImg, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($watermarkImg), imagesy($watermarkImg), 20);   
        // Save image and free memory 
        imagepng($im, $target_file); 
        imagedestroy($im);
    }
    
    // create watermark with text
    // Function to add text water mark over image
    protected function addTextWatermark($src, $watermark, $save=NULL) 
    { 
        list($width, $height) = getimagesize($src);
        $this->imageHeight = $height;
        $this->imageWidth = $width;
        $this->watermarkText = $watermark;
        $image_color = imagecreatetruecolor($width, $height);
        switch($this->imageFileType)
        {
            case 'jpg':
                $image = imagecreatefromjpeg($src);
                $this->image = $image;
                break;
            case 'png':
                $image = imagecreatefrompng($src);
                $this->image = $image;
                break;
            case 'gif':
                $image = imagecreatefromgif($src);
                $this->image = $image;
                break;
        }
        imagecopyresampled($image_color, $image, 0, 0, 0, 0, $width, $height, $width, $height); 
        // $txtcolor = imagecolorallocate($image_color, 250,250,250);
        $alpha_color = imagecolorallocatealpha(
            $image_color,
            hexdec( substr( 14, 0, 2 ) ),
            hexdec( substr( 14, 2, 2 ) ),
            hexdec( substr( 14, 4, 2 ) ),
            127 * ( 100 - $this->opacity ) / 100
          );
        $font = dirname(__FILE__) . '/../fonts/cambriai.ttf';
        $this->font = $font;
        $test = imagettftext($image_color, $this->setFontSize(),$this->watermarkStyle(), $this->positionX(),$this->positionY(), $alpha_color, $font, $watermark);
        echo("<pre>");
        print_r($test);
        echo("</pre>");
        if ($save<>'') {
        imagejpeg ($image_color, $save, 100); 
        } else {
            header('Content-Type: image/jpeg');
            imagejpeg($image_color, null, 100);
        }
        imagedestroy($image); 
        imagedestroy($image_color); 
   }

    //    calculate the watermark position
    // calculate the watermark position of Y ofset
    protected function positionY()
    {
        //if watermark style set
        if(isset($this->config_data['watermark_style']))
        {
            // switch watermark style
            switch($this->config_data['watermark_style'])
            {
                // vartical style y-offset
                case 'vartical':
                    if(isset($this->config_data['watermark_position']))
                    {
                        switch($this->config_data['watermark_position'])
                        {
                            case 'top-left':
                                return($this->yOffsetTop());
                                break;
                            case 'top-right':
                                return($this->yOffsetTop());
                                break;
                            case 'center-top':
                                return($this->yOffsetTop());
                                break;
                            case 'bottom-left':
                                return($this->imageHeight-10);
                            case 'bottom-right':
                                return($this->imageHeight-10);
                            case 'center-bottom':
                                return($this->imageHeight-10);
                            default :
                                return($this->defaultPositionY());
                            break;
                        }
                        break;
                    }
                    else
                    {
                        return($this->defaultPositionY());
                    }
                    break;
                // horizontal style y-offset
                case 'horizontal':
                    if(isset($this->config_data['watermark_position']))
                    {
                        switch($this->config_data['watermark_position'])
                        {
                            case 'center-top':
                                // watermark position horizontal top
                                return ($this->fontSize);
                                break;
                            case 'center-bottom':
                                // watermark position horizontal bottom
                                return ($this->imageHeight-10);
                                break;
                            case 'top-left':
                                // position left-top y-offset
                                return($this->fontSize);
                                break;
                            case 'bottom-right':
                                // position bottom-right y-offset
                                return($this->imageHeight-10);
                                break;
                            case 'bottom-left':
                                return($this->imageHeight-10);
                                break;
                            case 'top-right':
                                return ($this->fontSize);
                                break;
                            default :
                                //  watermark position horizontal center
                                $watermark_width = strlen($this->watermarkText) * $this->fontSize;
                                $positionY = $this->imageWidth/2;
                                return ($positionY);
                            break;
                        }
                        break;
                    }
                    else
                    {
                        return($this->defaultPositionY());
                    }
                // angle style y-offset
                default:
                    return($this->defaultPositionY());
                break;
            }
        }
        else
        {
            // if watermark style not set use this default angle style
            return($this->defaultPositionY());
        }      
    }


    // position y-offset top
    protected function yOffsetTop()
    {
        // watermark position vartical top
        $watermark_width = strlen($this->watermarkText) * $this->fontSize;
        $positionY = $watermark_width /2;
        $width_ratio = $this->imageWidth / 4.8;
        return ($positionY+$width_ratio);
    }

    // position x-offset right
    protected function xOffsetRight()
    {
        $watermark_width = strlen($this->watermarkText) * $this->fontSize;
        $position_x = $this->imageWidth - $watermark_width;
        return($position_x+($watermark_width/3.5));
    }

    // calculate the watermark position of X ofset
    protected function positionX()
    {
        if(isset($this->config_data['watermark_style']))
        {
            // switch watermark style x-offset
            switch($this->config_data['watermark_style'])
            {
                // horizontal style x-offet
                case 'horizontal':
                    // position horizontal style                   
                    if(isset($this->config_data['watermark_position']))
                     // if set watermark position
                    {
                        switch($this->config_data['watermark_position'])
                        {
                            case 'top-left':
                                return (10);
                                break;
                            case 'top-right':
                                return($this->xOffsetRight());
                                break;
                            case 'bottom-right':
                                return($this->xOffsetRight());
                                break;
                            case 'bottom-left':
                                return(10);
                            // position horizontal center x-ofset
                            default :
                                return $this->defaultPositionX();
                                break;
                        }
                    }
                    // if not set watermark position
                    else
                    {
                        return $this->defaultPositionX();
                    }
                    break;
                //vartical position x-offset
                case 'vartical':
                    // position horizontal style                   
                    if(isset($this->config_data['watermark_position']))
                     // if set watermark position
                    {
                        switch($this->config_data['watermark_position'])
                        {
                            case 'top-left':
                                return ($this->fontSize);
                                break;
                            case 'top-right':
                                return($this->imageWidth-10);
                                break;
                            case 'bottom-right':
                                return($this->imageWidth-10);
                                break;
                            case 'bottom-left':
                                return($this->fontSize);
                            case 'center-top':
                                return($this->defaultPositionX());
                                return 0;
                            case 'center-bottom':
                                return($this->defaultPositionX());
                                return 0;
                            // position horizontal center x-ofset
                            default :
                                return $this->defaultPositionX();
                                break;
                        }
                    }
                    // if not set watermark position
                    else
                    {
                        return $this->defaultPositionX();
                    }
                    break;
                    
                // angle style x-offset
                default:
                    return $this->defaultPositionX();
                    break;
            }
        }
        else
        {
            // this code for default watermark style
            return $this->defaultPositionX();
        }
        
    }
    // default watermark position y-offset
    protected function defaultPositionY()
    {
        if(isset($this->config_data['watermark_style']))
        {
            switch($this->config_data['watermark_style'])
            {
                case 'vartical':
                    $watermark_width = strlen($this->watermarkText) * $this->fontSize;
                    $positionY = $watermark_width /2;
                    $width_ratio = $this->imageWidth / 2.8;
                    return ($positionY+$width_ratio);
                    break;
                case 'horizontal':
                    return (($this->imageHeight/2)+($this->fontSize/2));
                    break;
                default:
                    return($this->defaultAnlgeStyleY());
                    break;
            }
        }
        else
        {
            // if not set watermark style 
            return($this->defaultAnlgeStyleY());
        }
        
    }
    
    // default watermark position
    protected function defaultPositionX()
    {
        // if set or config watermark style
        if(isset($this->config_data['watermark_style']))
        {
            switch($this->config_data['watermark_style'])
            {   
                // default position of horizontal style x-ofset
                case 'horizontal':
                    $watermark_width = strlen($this->watermarkText) * $this->fontSize;
                    $position_x = $this->imageWidth - $watermark_width;
                    $ratio = $watermark_width / 7;
                    return (($position_x/2) + $ratio);
                    break;
                case 'vartical':
                    $watermark_width = strlen($this->watermarkText) * $this->fontSize;
                    $position_x = $this->imageWidth - $watermark_width;
                    $ratio = $watermark_width / 7;
                    return (($this->imageWidth/2) + ($this->fontSize/2));
                    break;
                default :
                // default position angle style
                // if not set watermark style
                    return($this->defaultAnlgeStyleX());
                break;
            }
        }
        else
        {
            // if not set watermark style
            return($this->defaultAnlgeStyleX());
        }
    }

    // default angle style y-offset
    protected function defaultAnlgeStyleY()
    {
        // retrieve boundingbox
        $centerY = $this->imageHeight/2;
        // Get size of text
        list($left, $bottom, $right, , , $top) = imageftbbox($this->fontSize, 45, $this->font, $this->watermarkText);

        // Determine offset of text
        $left_offset = ($right - $left) / 2;
        $top_offset = ($bottom - $top) / 2;

        // Generate coordinates
        // $x = $centerX - $left_offset;
        $y = $centerY + $top_offset;

        return $y;
    }

    
    // default angle style x-offset
    protected function defaultAnlgeStyleX()
    {
        $centerX = $this->imageWidth/2;
        // Get size of text
        list($left, $bottom, $right, , , $top) = imageftbbox($this->fontSize, 45, $this->font, $this->watermarkText);

        // Determine offset of text
        $left_offset = ($right - $left) / 2;
        $top_offset = ($bottom - $top) / 2;

        // Generate coordinates
        $x = $centerX - $left_offset;
        // $y = $centerY + $top_offset;

        return $x;
    }


    // creat text watermark style
    protected function watermarkStyle()
    {
        if(isset($this->config_data['watermark_style']))
        {
            switch($this->config_data['watermark_style'])
            {
                case 'horizontal':
                    return 0;
                    break;
                case 'vartical':
                    return 90;
                    break;
                default:
                    return 45;
                break;
            }
        }
        else{
            return 45;
        }
    }
    // set font size to watermark text
    protected function setFontSize()
    {
        $watermark_width = strlen($this->watermarkText) * $this->fontSize;
        if($watermark_width > $this->imageWidth){
            $this->fontSize = $this->imageWidth / strlen($this->watermarkText);
        }
        return $this->fontSize;
    }
}
