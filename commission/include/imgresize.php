<?php
function resize($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false)
{
    $info = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);

    #assuming the mime type is correct
    switch ($imgtype) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($source_image);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($source_image);
            break;
        case 'image/png':
            $source = imagecreatefrompng($source_image);
		case 'image/jpg':
            $source = imagecreatefrompng($source_image);
            break;
       // default:
           // die('Invalid image type.');
    }

    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
    $src_w = imagesx($source);
    $src_h = imagesy($source);


    #Do some math to figure out which way we'll need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed

    $x_ratio = $tn_w / $src_w;
    $y_ratio = $tn_h / $src_h;

    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
        $new_w = $src_w;
        $new_h = $src_h;
    } elseif (($x_ratio * $src_h) < $tn_h) {
        $new_h = ceil($x_ratio * $src_h);
        $new_w = $tn_w;
    } else {
        $new_w = ceil($y_ratio * $src_w);
        $new_h = $tn_h;
    }


    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
	imagealphablending($newpic, false);
    imagesavealpha($newpic,true);
    $transparent = imagecolorallocatealpha($newpic, 255, 255, 255, 127);
    imagefilledrectangle($newpic, 0, 0, $width, $height, $transparent);
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);	
		
    $final = imagecreatetruecolor($tn_w, $tn_h);
	imagesavealpha( $final, true );
    $backgroundColor = imagecolorallocatealpha($final, 255, 255, 255,127);
	//imagecolortransparent($final, $backgroundColor);
    imagefill($final, 0, 0, $backgroundColor);
	
	imagealphablending($final,true);
    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);
    return imagejpeg($final, './'.$destination);
}


?>
