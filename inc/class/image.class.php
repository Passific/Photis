<?php

class Image
{
	public function ResizeImage($image, $newimage, $newwidth=0, $newheight=0)
	{
		if (!function_exists('ImageTypes'))
			return false;
		list($width,$height,$type) = GetImageSize($image);
		if ($im = self::ReadImageFromFile($image, $type))
		{
			if ($newwidth==0)
				$newwidth = ($newheight / $height) * $width;
			else if ($newheight==0)
				$newheight = ($newwidth / $width) * $height;
			elseif ($newheight && ($width < $height))
				$newwidth = ($newheight / $height) * $width;
			else
				$newheight = ($newwidth / $width) * $height;
 
			if (function_exists('ImageCreateTrueColor'))
				$im2 = ImageCreateTrueColor($newwidth,$newheight);
			else
				$im2 = ImageCreate($newwidth,$newheight);
 
			if (function_exists('imagealphablending'))
				imagealphablending($im2, false);
			if (function_exists('imagesavealpha'))
				imagesavealpha ($im2 , true);
 
			if (function_exists('ImageCopyResampled'))
			{
				$im2 = imagecreatetruecolor($newwidth, $newheight);
				ImageCopyResampled($im2,$im,0,0,0,0,$newwidth,$newheight,$width,$height);
			}
			else
			{
				ImageCopyResized($im2,$im,0,0,0,0,$newwidth,$newheight,$width,$height);
			}
 
			if (self::WriteImageToFile($im2, $newimage, $type))
				return true;
		}
		return false;
	}
	private function ReadImageFromFile($filename, $type)
	{
		$imagetypes = ImageTypes();
		switch ($type)
		{
			case 1 :
				if ($imagetypes & IMG_GIF)
					return $im = ImageCreateFromGIF($filename);
				break;
			case 2 :
				if ($imagetypes & IMG_JPEG)
					return ImageCreateFromJPEG($filename);
				break;
			case 3 :
				if ($imagetypes & IMG_PNG)
					return ImageCreateFromPNG($filename);
				break;
			default:
				return 0;
		}
	}
	private function WriteImageToFile($im, $filename, $type)
	{
		switch ($type)
		{
			case 1 :
				return ImageGIF($im, $filename);
			case 2 :
				return ImageJpeg($im, $filename, 85);
			case 3 :
				return ImagePNG($im, $filename);
			default:
				return false;
		}
	}

}

?>