<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function barcode_create($barcode_text='', $barcode_type=39)
{
	// Including all required classes
	require_once('barcode/BCGFontFile.php');
	require_once('barcode/BCGColor.php');
	require_once('barcode/BCGDrawing.php');

	// Including the barcode technology
	switch($barcode_type){
		case 11:
			require_once('barcode/BCGcode11.barcode.php'); 
			$code = new BCGcode11();
			break;
		case 39:
			require_once('barcode/BCGcode39.barcode.php'); 		
			$code = new BCGcode39();
			break;
		case '39e':
			require_once('barcode/BCGcode39extended.barcode.php'); 		
			$code = new BCGcode39();
			break;
		case 93:
			require_once('barcode/BCGcode93.barcode.php'); 
			$code = new BCGcode93();
			break;
		case 128:
			require_once('barcode/BCGcode128.barcode.php'); 
			$code = new BCGcode128();
			break;
		default:
			require_once('barcode/BCGcode39.barcode.php');
			$code = new BCGcode39();			
	}

	// Loading Font
	$font = new BCGFontFile('./assets/font/Arial.ttf', 10);

	// The arguments are R, G, B for color.
	$color_black = new BCGColor(0, 0, 0);
	$color_white = new BCGColor(255, 255, 255);

	$drawException = null;
	try {
		$code->setScale(2); // Resolution
		$code->setThickness(15); // Thickness
		$code->setForegroundColor($color_black); // Color of bars
		$code->setBackgroundColor($color_white); // Color of spaces
		$code->setFont($font); // Font (or 0)
		$code->parse($barcode_text); // Text
	} catch(Exception $exception) {
		$drawException = $exception;
	}

	/* Here is the list of the arguments
	1 - Filename (empty : display on screen)
	2 - Background color */

	$drawing = new BCGDrawing('', $color_white);
	if($drawException) {
		$drawing->drawException($drawException);
	} else {
		$drawing->setBarcode($code);
		$drawing->draw();
	}

	// Header that says it is an image (remove it if you save the barcode to a file)
	header('Content-Type: image/png');

	// Draw (or save) the image into PNG format.
	$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
}
?>