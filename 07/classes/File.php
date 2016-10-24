<?php

class File {
    
    public static function getUpload() {
        if(isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])) {
            $original_name=$_FILES['myfile']['name'];
            $tmp_name = $_FILES['myfile']['tmp_name'];
            $type = $_FILES['myfile']['type'];
            $size = $_FILES['myfile']['size'];
            $destination = 'uploads/'.$original_name;
            move_uploaded_file($tmp_name, $destination);
            
            $file = array('name' => $original_name, 
                'tmp_name' => $tmp_name, 
                'type' => $type, 
                'size' => $size, 
                'destination' => $destination);
            return $file;
        } else {
            return null;
        }
    }
    /**
     * Check to see if the MIME-Type is of Type text.  Any subtypes are also 
     * accepted.  If the file exists, and it is of MIME-Type text, it's parsable. 
     * @param String $filename
     * @return boolean
     */
    public static function isParsable($filename, $filetype) {
        if (file_exists($filename)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = substr(finfo_file($finfo, $filename),0,4);
            finfo_close($finfo);
            if ($type === $filetype) {
                return true;
            }
            else {
                //delete the file if it's not the right filetype
                unlink($filename);
            }
        }
        return false;
        
    }
}
