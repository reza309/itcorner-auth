<?php
require_once "Watermark.php";
class Upload
{
    protected $err_message = [];
    protected $success_message = [];
    protected $config_data = null;
    protected $max_size = 1024;
    protected $target_file = [];
    protected $err_count = 0;
    protected $imageFileType;
    protected $allowed_file_type = ["jpg","png","jpeg","gif"];

    use Watermark;
    public function __construct($config_data)
    {
        $this->config_data = $config_data;
        if(!isset($this->config_data['[max_size']))
        {
            $this->config_data['max_size'] = 50000;
        }
        if($this->config_data['max_size'] !=null && $this->config_data['max_size'] != 0)
        {
            $this->max_size = $this->config_data['max_size'] * $this->max_size;
        }
        else        
        {
            $this->config_data['max_size'] = 1;
        }
        
        if(isset($this->config_data['watermark_opacity']))
        {
            $this->watermark_opacity = $this->config_data['watermark_opacity'];
        }
        if(isset($config_data['watermark_text']))
        {
            $this->watermarkText = $config_data['watermark_text'];
        }
        if(isset($config_data['watermark_font_size']))
        {
            $this->fontSize = $config_data['watermark_font_size'];
        }
        if(!isset($config_data['file_type']))
        {
            $this->config_data['file_type'] = $this->allowed_file_type;
        }
    }
    public function store()
    {
        if(!isset($this->config_data['upload_option']))
        {
            $name_type = $_FILES[$this->config_data['name_attribute']]['name'];
            if(gettype($name_type) == "array")
            {
                return("Vlue of name attribute should not array");
            }
        }
        // count total file
        $uploadOk = $this->validation_check();
        if(isset($this->config_data['upload_option']))
        {
            if(strtolower($this->config_data['upload_option']==='multiple'))
            {
                $total = count($_FILES[$this->config_data['name_attribute']]['name']);
            }
            else
            {
                $total = 1;
            }
        }
        else
        {
            $total = 1;
        }
        
        for($i=0; $i<$total; $i++)
        {
            if(isset($this->config_data['have_marching']))
            {
                if($this->err_count !=0 && $this->config_data['have_marching']==false)
                {
                    if(!empty($this->take_name($i)))
                    {
                        array_push($this->err_message,"Error found in a file");
                    }
                    break;
                }
            }
            else
            {
                $target_dir = $this->config_data['target_dir'];
                $base_name = $this->config_data['file_name']."-".time().$i.".";
                $target_file = $target_dir . $base_name.pathinfo($this->take_name($i),PATHINFO_EXTENSION);
                $this->imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if($uploadOk != 0)
                {
                    if (move_uploaded_file($this->take_tmp_name($i), $target_file)) 
                    {
                        array_push($this->success_message, "The file ". htmlspecialchars($target_file). " has been uploaded.");
                        array_push($this->target_file,$target_file);
                        // create a watermark to image
                        if(in_array($this->imageFileType,$this->allowed_file_type))
                        {
                            $this->insert_watemark($target_file);
                        }
                        
                    } 
                    else 
                    {
                        array_push($this->err_message, "Sorry, there was an error uploading your file.");
                    }
                }
            }
        }
        // if file uploaded successfully
        if(empty($this->err_message))
        {
            $message = [
                "status" => "success",
                "success" => $this->success_message
            ];
            return $message;
        }
        elseif(!empty($this->err_message && !empty($this->success_message)))
        {
            $total_success = count($this->success_message);
            array_push($this->success_message,"Upload success ".$total_success.", another file failed to upload");
            $message = [
                "status" => "success",
                "success" => $this->success_message,
                "failed" => $this->err_message
            ];
            return $message;
        }
        else
        {
            $message = [
                "status" => "failed",
                "failed" => $this->err_message
            ];
            return $message;
        }
        
    }
    // validation check
    protected function validation_check()
    {
        // count total file
        
        if(isset($this->config_data['upload_option']))
        {
            if(strtolower($this->config_data['upload_option']==='multiple'))
            {
                $total = count($_FILES[$this->config_data['name_attribute']]['name']);
            }
            else
            {
                $total = 1;
            }
        }
        else
        {
            $total = 1;
        }
        $uploadOk = 1;
        for($i=0; $i<$total; $i++)
        {
            
            // check file selected or not
            if(!empty($this->take_name($i)))
            {
                $target_dir = $this->config_data['target_dir'];
                $base_name = $this->config_data['file_name']."-".time().$i.".";
                $target_file = $target_dir . $base_name.pathinfo($this->take_name($i),PATHINFO_EXTENSION);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) 
                {
                    $check = getimagesize($this->take_tmp_name($i));
                    if($check !== false) 
                    {
                        array_push($this->success_message, "File is an image - " . $check["mime"] . ".");
                        $uploadOk = 1;
                    } 
                    else 
                    {
                        array_push($this->err_message,"File is not an image.");
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) 
                {
                    array_push($this->err_message, "Sorry, file already exists.");
                    $uploadOk = 0;
                }
                // Check file size
                
                if ($this->take_size($i) > $this->max_size) 
                {
                    array_push($this->err_message, "Sorry, your file is too large! maximum size ".$this->config_data['max_size']."KB");
                    $uploadOk = 0;
                }
                
                // Allow certain file formats
                if(isset($this->config_data['file_type']))
                {
                    if($this->config_data['file_type'] != null)
                    {
                        if(!in_array($imageFileType, $this->config_data['file_type']))
                        {
                            array_push($this->err_message, "Sorry, only ".implode($this->config_data['file_type'],", ")." files are allowed.");
                            $uploadOk = 0;
                        }
                    }
                }
                
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) 
                {
                    array_push($this->err_message, "Sorry, your file was not uploaded.");
                    $this->err_count ++;
                } 
                
            }
            else
            {
                array_push($this->err_message, "Please choose an image");
                $this->err_count ++;
            }
            
        }
        return $uploadOk;
    }

    // take file name if single or multiple
    protected function take_tmp_name($i)
    {
        if(isset($this->config_data['upload_option']))
        {
            if(strtolower($this->config_data['upload_option']==='multiple'))
            {
                return($_FILES[$this->config_data['name_attribute']]["tmp_name"][$i]);
            }
            else
            {
                return($_FILES[$this->config_data['name_attribute']]["tmp_name"]);
            }
        }
        else
        {
            return($_FILES[$this->config_data['name_attribute']]["tmp_name"]);
        }
    }
    // take tmp name if single or multiple
    protected function take_name($i)
    {
        if(isset($this->config_data['upload_option']))
        {
            if(strtolower($this->config_data['upload_option']==='multiple'))
            {
                return($_FILES[$this->config_data['name_attribute']]['name'][$i]);
            }
            else
            {
                return($_FILES[$this->config_data['name_attribute']]['name']);
            }
        }
        else
        {
            return($_FILES[$this->config_data['name_attribute']]['name']);
        }
    }
    // take size of selected file, single or multiple
    protected function take_size($i)
    {
        if(isset($this->config_data['upload_option']))
        {
            if(strtolower($this->config_data['upload_option']==='multiple'))
            {
                return($_FILES[$this->config_data['name_attribute']]["size"][$i]);
            }
            else
            {
                return($_FILES[$this->config_data['name_attribute']]["size"]);
            }
        }
        else
        {
            return($_FILES[$this->config_data['name_attribute']]["size"]);
        }
    }
    
    // display error message
    public function display_err()
    {
        echo("<ul>");
        for($i=0;$i<count($this->err_message); $i++)
        {
            echo("<li>".$this->err_message[$i]."</li>");
        }
        echo("</ul>");
        
    }
    // display success message
    public function display_success()
    {
        echo($this->success_message);
    }
    // check have a error or not
    public function has_err()
    {
        if(!empty($this->err_message))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    // check have a success message or not
    public function has_success()
    {
        if(!empty($this->success_message))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    // return directory and file name for store to database
    public function get_target_file()
    {
        return($this->target_file);
    }
}