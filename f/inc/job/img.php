<?php
if(!function_exists('html')){
	die('F');
}
$vid=base64_decode($vid);
Img_Show($vid);

function Img_Show($nmsg){
	if (function_exists('imagecreate')){
		$width=strlen($nmsg)*10;
		$height=22;
		$aimg = imagecreate($width,$height);
		$back = imagecolorallocate($aimg, 255, 255, 255);
		$border = imagecolorallocate($aimg, 0, 0, 0);
		imagefilledrectangle($aimg, 0, 0, $width - 1, $height - 1, $back);
		//imagerectangle($aimg, 0, 0, $width - 1, $height - 1, $border);
		for ($i=0;$i<strlen($nmsg);$i++){ 
				imageString($aimg,4,$i*$width/strlen($nmsg)+3,2, $nmsg[$i],$border); 
		}
		header("Pragma:no-cache");
		header("Cache-control:no-cache");
		header("Content-type: image/png");
		imagepng($aimg);
		imagedestroy($aimg);
		exit;
	} else {
		header("Pragma:no-cache");
		header("Cache-control:no-cache");
		header("ContentType: Image/BMP");

		$Color[0] = chr(0).chr(0).chr(0);
		$Color[1] = chr(255).chr(255).chr(255);
		$_Num[0]  = "1110000111110111101111011110111101001011110100101111010010111101001011110111101111011110111110000111";
		$_Num[1]  = "1111011111110001111111110111111111011111111101111111110111111111011111111101111111110111111100000111";
		$_Num[2]  = "1110000111110111101111011110111111111011111111011111111011111111011111111011111111011110111100000011";
		$_Num[3]  = "1110000111110111101111011110111111110111111100111111111101111111111011110111101111011110111110000111";
		$_Num[4]  = "1111101111111110111111110011111110101111110110111111011011111100000011111110111111111011111111000011";
		$_Num[5]  = "1100000011110111111111011111111101000111110011101111111110111111111011110111101111011110111110000111";
		$_Num[6]  = "1111000111111011101111011111111101111111110100011111001110111101111011110111101111011110111110000111";
		$_Num[7]  = "1100000011110111011111011101111111101111111110111111110111111111011111111101111111110111111111011111";
		$_Num[8]  = "1110000111110111101111011110111101111011111000011111101101111101111011110111101111011110111110000111";
		$_Num[9]  = "1110001111110111011111011110111101111011110111001111100010111111111011111111101111011101111110001111";

		echo chr(66).chr(77).chr(230).chr(4).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(54).chr(0).chr(0).chr(0).chr(40).chr(0).chr(0).chr(0).chr(40).chr(0).chr(0).chr(0).chr(10).chr(0).chr(0).chr(0).chr(1).chr(0);
		echo chr(24).chr(0).chr(0).chr(0).chr(0).chr(0).chr(176).chr(4).chr(0).chr(0).chr(18).chr(11).chr(0).chr(0).chr(18).chr(11).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0).chr(0);

		for ($i=9;$i>=0;$i--){
				for ($j=0;$j<=3;$j++){
						for ($k=1;$k<=10;$k++){
								echo $Color[substr($_Num[$nmsg[$j]], $i * 10 + $k, 1)];
						}
				}
		}
		exit;
	}
}

?>