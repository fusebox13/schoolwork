<?php


/**
 * Img Class for drawing with GD Library
 * Jason Jarvis - 2/22/2014
 *
 * 	loadImage			Load an image
 * 	getWidth				Get width of the image
 * 	getHeight			Get height of the image
 * 	setColorRGB			Set current draw color
 * 	setLineWidth		Set line width for drawing
 * 	moveTo				Move pen to the given coordinate
 * 	lineTo				Draw a line from the current location
 * 	curveTo				Draw a Quadratic Bezier curve
 * 	getPixel				Retrieve an array of color inormation at a specified location
 * 	setPixel				Set a pixel color
 * 	drawFilledRect		Draw a filled rectangle shape at the specified locations
 * 	setTextSize			Select text style (1-5)
 * 	writeText			Write a string of text at the current location
 * 	output				Print headers and send image to output buffer
 * 	
 */
class Img {
	
	private $_img;
	private $_x=0;
	private $_y=0;
	private $_color=0;
	private $_textSize=1;
	
	/**
	 * Image Library
	 * @param type $param1 (optional) image filename or width
	 * @param type $param2 (optional) image height
	 */
	public function __construct($param1=null, $param2=null){
		if(!is_numeric($param1) && strlen($param1) > 0 && $param2==null){
			// create from known image
			$this->loadImage($param1);
		} elseif(is_numeric($param1) && is_numeric($param2) && $param1 > 0 && $param2 > 0) {
			$this->_img = imagecreatetruecolor($param1, $param2);
		} else {
			$this->_img = imagecreatetruecolor(320, 240);
		}
		$this->setColorRGB(255,255,255);
	}
	
	/**
	 * Load an image
	 * @param type $src
	 */
	public function loadImage($src){
		if($this->_img) $this->_img = null;
		$this->_img = @imagecreatefromjpeg($src);
	}
	
	/**
	 * Get width of the image
	 * @return type
	 */
	public function getWidth(){
		return imagesx($this->_img);
	}
	
	/**
	 * Get height of the image
	 * @return type
	 */
	public function getHeight(){
		return imagesy($this->_img);
	}
	
	/**
	 * Set current draw color
	 * @param type $red (0-255)
	 * @param type $green (0-255)
	 * @param type $blue (0-255)
	 */
	public function setColorRGB($red,$green,$blue){
		$this->_color = imagecolorallocate($this->_img, $red, $green, $blue);
	}
	
	/**
	 * Set line width for drawing
	 * @param type $width
	 */
	public function setLineWidth($width){
		$w = abs(floatval($width));
		imagesetthickness( $this->_img , $w);
	}
	
	/**
	 * Move pen to the given coordinate
	 * @param type $x
	 * @param type $y
	 */
	public function moveTo($x,$y){
		$this->_x=$x;
		$this->_y=$y;
	}
	
	/**
	 * Draw a line from the current location
	 * @param type $x
	 * @param type $y
	 */
	public function lineTo($x, $y){
		imageline($this->_img, $this->_x , $this->_y, $x, $y, $this->_color );
		$this->_x=$x; $this->_y = $y;
	}
	
	/**
	 * Draw a Quadratic Bezier curve from the current location using one control point
	 * @param type $x X-location of end of curve
	 * @param type $y Y-location of end of curve
	 * @param type $cx X-location of control point
	 * @param type $cy Y-location of control point
	 */
	public function curveTo($x, $y, $cx, $cy){
		$ox = $this->_x; $oy = $this->_y; $lx=$ox; $ly=$oy;
		// identify a sampling size (3 * disance between points)
		$tmax = ceil(sqrt(pow($ox-$x,2)+pow($oy-$y,2))*3); 
		for($t=0;$t < $tmax; $t++){
			$tp = $t / $tmax;
			// Quadratic Bezier function
			$tx = (1-$tp)*(1-$tp)*$ox+2*(1-$tp)*$tp*$cx+$tp*$tp*$x;
			$ty = (1-$tp)*(1-$tp)*$oy+2*(1-$tp)*$tp*$cy+$tp*$tp*$y;
			imageline($this->_img, $lx, $ly, $tx, $ty, $this->_color);
			$lx = $tx; $ly=$ty;
		}
	}
	
	/**
	 * Retrieve an array of color inormation at a specified location
	 * @param type $x
	 * @param type $y
	 * @return array(red, green, blue)
	 */
	public function getPixel($x, $y){
		return $this->_int2rgb(imagecolorat( $this->_img, $x , $y));
	}
	
	/**
	 * Set a pixel color
	 * @param type $x
	 * @param type $y
	 * @param type $red
	 * @param type $green
	 * @param type $blue
	 */
	public function setPixel($x, $y, $red, $green, $blue){
		imagesetpixel( $this->_img, $x, $y, imagecolorallocate($this->_img, $red, $green, $blue) );
	}
	
	/**
	 * Draw a filled rectangle shape at the specified locations
	 * @param type $x
	 * @param type $y
	 * @param type $width
	 * @param type $height
	 */
	public function drawFilledRect($x, $y, $width, $height){
		imagefilledrectangle( $this->_img, $x, $y, $x+$width, $y+$height, $this->_color);
	}
	
	/**
	 * Select text style (1-5)
	 * @param type $size
	 */
	public function setTextSize($size){
		$this->_textSize=$size;
	}
	
	/**
	 * Write a string of text at the current location
	 * @param type $string
	 */
	public function writeText($string){
		imagestring( $this->_img, $this->_textSize, $this->_x, $this->_y, $string , $this->_color);
	}
	
	/**
	 * Print headers and send image to output buffer
	 * @param type $quality Quality of the final image (0-100)
	 */
	public function output($quality=75){ 
		// header to identify type
		header('Content-Type: image/jpeg');
		// headers to inhibit image caching
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		imagejpeg($this->_img, null, $quality);
	}
	
	/**
	 * Class Destructor
	 */
	public function __destruct(){
		imagedestroy($this->_img);
	}
	
	/**
	 * PRIVATE function to convert RGB to Int
	 * @param type $int
	 * @return type
	 */
	private function _int2rgb($int){
		$r = ($int >> 16) & 0xFF;
		$g = ($int >> 8) & 0xFF;
		$b = $int & 0xFF;
		return array($r,$g,$b);
	}
	
}

