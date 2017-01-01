<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Ugly class. 
 *
 * @author pavel
 */
class Uploader {
	
	private $message;
	private $status;
	private $fileName;


	public function __construct($formInputName, $savingDirectory = "www/photos/upload/") {
		$target_dir = $savingDirectory;
		$target_file = $target_dir . basename($_FILES[$formInputName]["name"]);
		$this->fileName = basename($_FILES[$formInputName]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES[$formInputName]["tmp_name"]);
			if($check !== false) {
				$this->message .= "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$this->message .= "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			$this->message .= "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES[$formInputName]["size"] > 10485760) { //10 MB (size is also in bytes)
			$this->message .= "Sorry, your file is too large. (10 MB max)";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			$this->message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$this->message .= "Sorry, your file was not uploaded.";
			$this->status = false;
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES[$formInputName]["tmp_name"], $target_file)) {
				$this->message .= "The file ". basename( $_FILES[$formInputName]["name"]). " has been uploaded.";
				$this->status = true;
		} else {
				$this->message .= "Sorry, there was an error uploading your file.";
				$this->status = false;
			}
		}
	}
	
	public function redirect($url, $statusCode = 303)
	{
		header('Location: ' . $url, true, $statusCode);
		die();
	}


	public function getMessage() {
		return $this->message;
	}

	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}
	public function getStatus() {
		return $this->status;
	}

	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	
	public function getFileName() {
		return $this->fileName;
	}

	public function setFileName($fileName) {
		$this->fileName = $fileName;
		return $this;
	}
}
