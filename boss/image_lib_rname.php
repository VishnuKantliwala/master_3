		<?php	
		
		// make thumb of images
function make_thumb($src,$dest,$desired_width,$ext)
{

//echo $ext;die;
	/* read the source image */
	if($ext=='.jpeg')
	{
	   	$source_image = imagecreatefromjpeg($src);

	}
	else if($ext=='.gif')
	{
	   	$source_image = imagecreatefromgif($src);

	}
	if($ext=='.png')
	{
	   	$source_image = imagecreatefrompng($src);

	}
	
	//echo $source_image;die;
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height*($desired_width/$width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
	
	/* copy source image at a resized size */
	imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);
	
	/* create the physical thumbnail image to its destination */
	if($ext=='.jpeg')
	{
			imagejpeg($virtual_image,$dest);


	}
	else if($ext=='.gif')
	{
			imagegif($virtual_image,$dest);


	}
	else if($ext=='.png')
	{
			imagepng($virtual_image,$dest);


	}
}

// end of thumb images			

function createImage($inputName, $uploadDir)
{

if($_FILES[$inputName]['name']!="")
				{
					if ((($_FILES[$inputName]["type"] == "image/gif")
					|| ($_FILES[$inputName]["type"] == "image/jpeg")
					|| ($_FILES[$inputName]["type"] == "image/jpg")
					|| ($_FILES[$inputName]["type"] == "image/JPG")
					|| ($_FILES[$inputName]["type"] == "image/pjpeg")
					|| ($_FILES[$inputName]["type"] == "image/png"))
					&& ($_FILES[$inputName]["size"] < 10000000))
  
					{
				        
						if($_FILES[$inputName]["type"] == "image/gif")
									$extension=".gif";
					   else if($_FILES[$inputName]["type"] == "image/jpeg")
							$extension=".jpeg";
					   else if($_FILES[$inputName]["type"] == "image/jpg")
							$extension=".jpg";
						else if($_FILES[$inputName]["type"] == "image/pjpeg")
							$extension=".pjpeg";	
						else if($_FILES[$inputName]["type"] == "image/png")
						$extension=".png";
						$namearr=explode(".",$_FILES[$inputName]['name']);
					   $name=$namearr[0].rand(100, 999).$extension;
						//$name = $_FILES[$inputName]['name'];	  
						//$sliderImage = uploadImage($inputName,'../slider/');
						move_uploaded_file($_FILES[$inputName]["tmp_name"],$uploadDir."/big_img/" . $name);
						//echo "insert into tbl_banner values(NULL,'".md5($name).$extension."','".$_REQUEST["img_name"]."')";
						$catImage = $name ;		
						make_thumb($uploadDir."/big_img/".$name,$uploadDir.$name,200,$extension);
					}
					else
					{
					//echo 'else';die;
					  echo "<script>alert('Image size is large'); </script>";

					}
				}	
				
				return $catImage;

}

function createMultiImage($inputName, $uploadDir)
{
// multiple images
	//----------------------
	
	//if(isset($_POST['mulradio']) && count($_POST['mulradio']) == 1)
	//{
	
	$image_name = '';
							if(isset($_FILES[$inputName]))
							{
							for($i=0;$i<count($_FILES[$inputName]['name']);$i++)
							{
								if($_FILES[$inputName]['name'][$i]!="")
								{
								
									if (($_FILES[$inputName]["type"][$i] == "image/gif")
										|| ($_FILES[$inputName]["type"][$i] == "image/jpeg")
										|| ($_FILES[$inputName]["type"][$i] == "image/jpg")
										|| ($_FILES[$inputName]["type"][$i] == "image/png"))
										  {
											  //rand ()
											  if($_FILES[$inputName]["type"][$i] == "image/gif")
													$extension=".gif";
											   else if($_FILES[$inputName]["type"][$i] == "image/jpeg")
													$extension=".jpeg";
											   else if($_FILES[$inputName]["type"][$i] == "image/jpg")
													$extension=".jpg";
												else if($_FILES[$inputName]["type"][$i] == "image/png")
													$extension=".png";
							
											  $namearr=explode(".",$_FILES[$inputName]['name'][$i]);
											  //echo "<script>alert('".$name."');</script>";
											  $name=$namearr[0].rand(100, 999).$extension;
											  
										  if ($_FILES[$inputName]["error"][$i] > 0)
											{
												echo "Return Code: " . $_FILES[$inputName]["error"][$i] . "<br />";
											}
										  else
											{
	
												if (file_exists("../gallery/"  . md5($name)))
												  {
													echo $_FILES[$inputName]["name"][$i] . " already exists. ";
												  }
												else
												  {
													move_uploaded_file($_FILES[$inputName]["tmp_name"][$i],$uploadDir."/big_img/" . $name);
															$image_name .= $name .',';		
													make_thumb($uploadDir."/big_img/".$name, $uploadDir.$name,200,$extension);
													
												  
												  }
											}
										  }//if
										else
										  {
											  
										  echo "Invalid file".$_FILES[$inputName]["type"][$i];
										  }
								}// if 
							}//for
						}//if
	//---------------------
	//end of multiple images
	//-----------------------
	return $image_name;
}

function createPDF($inputName, $uploadDir)
{

if ( isset( $inputName ) ) 
{
	if ($_FILES[$inputName]['type'] == "application/pdf") 
	{
		$source_file = $_FILES[$inputName]['tmp_name'];
		$dest_file = $uploadDir.$_FILES[$inputName]['name'];

		if (file_exists($dest_file)) {
			print "The file name already exists!!";
		}
		else {
			move_uploaded_file( $source_file, $dest_file )
			or die ("Error!!");
			if($_FILES[$inputName]['error'] == 0) 
			{
				return $_FILES[$inputName]['name'];
			}
		}
	}
	else {
		if ( $_FILES[$inputName]['type'] != "application/pdf") 
		{
			print "Error occured while uploading file : ".$_FILES[$inputName]['name']."<br/>";
			print "Invalid  file extension, should be pdf !!"."<br/>";
			print "Error Code : ".$_FILES[$inputName]['error']."<br/>";
		}
	}
}
}
function createMultiIcon($inputName, $uploadDir,$i)
{
//print_r($_FILES[$inputName]);die;
// multiple images
	//----------------------
	
	//if(isset($_POST['mulradio']) && count($_POST['mulradio']) == 1)
	//{
	$image_name = '';
							
								if($_FILES[$inputName]['name'][$i]!="")
								{
								
									if (($_FILES[$inputName]["type"][$i] == "image/gif")
										|| ($_FILES[$inputName]["type"][$i] == "image/jpeg")
										|| ($_FILES[$inputName]["type"][$i] == "image/jpg")
										|| ($_FILES[$inputName]["type"][$i] == "image/png"))
										  {
											  //rand ()
											  if($_FILES[$inputName]["type"][$i] == "image/gif")
													$extension=".gif";
											   else if($_FILES[$inputName]["type"][$i] == "image/jpeg")
													$extension=".jpeg";
											   else if($_FILES[$inputName]["type"][$i] == "image/jpg")
													$extension=".jpg";
							
												else if($_FILES[$inputName]["type"][$i] == "image/png")
													$extension=".png";
							
											  $name4=$_FILES[$inputName]['name'][$i];
										  if ($_FILES[$inputName]["error"][$i] > 0)
											{
												echo "Return Code: " . $_FILES[$inputName]["error"][$i] . "<br />";
											}
										  else
											{
	
												if (file_exists("../icon/"  . $name4))
												  {
													echo $_FILES[$inputName]["name"][$i] . " already exists. ";
												  }
												else
												  {
													move_uploaded_file($_FILES[$inputName]["tmp_name"][$i],$uploadDir."/big_img/" . $name4);
													$image_name = 	$name4;		
													make_thumb($uploadDir."/big_img/".$name4, $uploadDir.$name4,200,$extension);
													
												  
												  }
											}
										  }//if
										else
										  {
											  
										  echo "Invalid file".$_FILES[$inputName]["type"][$i];
										  }
								}// if 
							
	//---------------------
	//end of multiple icons
	//-----------------------
	return $image_name;
}
?>