<?php

namespace Classes;

class FileUpload {

    public $fileName;
    private $baseFile;
    private $directory;
    private $fileExtension;
    public $response = array();

    public function __construct($file_post, $dir) {
        $this->fileName = $file_post['name'];
        $this->baseFile = $file_post['tmp_name'];
        $this->directory = $dir;
        $this->fileExtension = pathinfo($this->fileName, PATHINFO_EXTENSION);
    }

    private function _validate() {
        $check = true;
        // Basic check for empty names
        if (empty($this->baseFile)) {
            $this->response['error'] = 'No file chosen';
            return false;
        }

        $attrib = getimagesize($this->baseFile);
        if (!$attrib && $this->fileExtension != 'pdf') {
            $this->response['error'] = 'File is not an image';
            $check = false;
        }
        
        if ($this->fileExtension != 'jpg' && $this->fileExtension != 'png' && $this->fileExtension != 'jpeg' && $this->fileExtension != 'pdf') {
            $this->response['error'] = 'Sorry, only JPG, PNG, JPEG, PDF files are allowed.';
            $check = false;
        }

        return $check;
    }

    public function upload() {
        $today = date('Y-m-d H:i:s');
        if ($this->_validate() && move_uploaded_file($this->baseFile, $this->directory . $this->fileName)) {
            $this->response = array('success' => 'Uploaded');
            return true;
        }

        if (empty($this->response)) {
            $this->response = array('error' => 'File not Uploaded');
        }
        return false;
    }
}

?>