<?php 
namespace Icons;

use Icons\Exception\Exception;

class TiconsGenerator implements IconsGenerator
{
	/*const ICON_PATH	= 0;
	const ICON_SIZE		= 1;
	const ICON_DPI		= 2;
	const ICON_RADIUS	= 3;
	
	const SPLASH_PATH	= 0';
	const SPLASH_WIDTH	= 1;
	const SPLASH_HEIGHT	= 2;
	const SPLASH_DPI	= 3;
	const SPLASH_ROTATE	= 4;*/
	
	private $_IMAGE_PATH	= 0;
	private $_IMAGE_WIDTH	= 1;
	private $_IMAGE_HEIGHT	= 2;
	private $_IMAGE_DPI		= 3;
	private $_IMAGE_ROTATE	= 4;
	
	public function __construct()
	{
		$this->imagemagick = new \Imagick;
	}

	public function generateIcons($imageArrayList, $file, $transparencyFlag = false)
	{
		/** Validate empty check **/
		if( empty($imageArrayList) || !file_exists($file) ) {
			return false;
		}
		
		foreach ( $imageArrayList as $images ) {
			$filePath = $images[$this->_IMAGE_PATH];
			$dir = dirname( $filePath );
			
			if ( is_dir( $dir ) == false ) {
				mkdir( $dir, 0777, true );
			}
			
			/** Get extension from the image path **/
			$ext = substr( $images[$this->_IMAGE_PATH], strrpos( $images[$this->_IMAGE_PATH], '.' ) + 1 );
			
			/** Get the file information **/
			$fileInfo = getimagesize($file);
			if ($fileInfo['mime'] == 'image/jpeg') {
				$ext	=	'jpg';
			}
			
			//$this->imagemagick = new Imagick();
			$this->imagemagick->setResolution( $images[$this->_IMAGE_DPI], $images[$this->_IMAGE_DPI] );
			$this->imagemagick->readImage( $file );
			$this->imagemagick->stripImage();
			
			if ( $ext == 'jpg' ) {
				$this->imagemagick->setImageFormat( 'jpeg' );
				$this->imagemagick->setImageCompression( 8 );
				$this->imagemagick->setImageCompressionQuality( 100 );
			} else {
				$this->imagemagick->setImageFormat( 'png' );
				$this->imagemagick->setImageCompressionQuality(9);
			}
			
			if ( isset( $images[$this->_IMAGE_ROTATE] ) ) {
				$this->imagemagick->rotateImage( new ImagickPixel( 'none' ), $images[$this->_IMAGE_ROTATE] );
			}
			
			$this->imagemagick->cropThumbnailImage( $images[$this->_IMAGE_WIDTH], $images[$this->_IMAGE_HEIGHT] );
			$this->imagemagick->setImageResolution( $images[$this->_IMAGE_DPI], $images[$this->_IMAGE_DPI] );
			$this->imagemagick->setImageUnits( 1 );
			// $this->imagemagick->setImageAlphaChannel( 4 );
			$this->imagemagick->writeImage( $filePath );
			
			//@TODO : Need to validate and another compression techniques is used on future.
			/** GD Library Methods **/
			//$getImagePathFileInfo = getimagesize( $filePath );
			
			/** Get image path file info extension is validated **/
			/* if ($getImagePathFileInfo['mime'] == 'image/jpeg') {
				$image1		=	imagecreatefromjpeg( $filePath );
				imagejpeg( $image1, $filePath, 90 );
			} elseif ($getImagePathFileInfo['mime'] == 'image/gif') {
				$image		=	imagecreatefromgif( $filePath );
				imagegif( $image1, $filePath );
			} elseif ($getImagePathFileInfo['mime'] == 'image/png') {
				$image1		=	imagecreatefrompng($filePath);
				imagealphablending( $image1, false );
				imagesavealpha( $image1, true );
				
				/** transparency flag is true means then imagepng method is called otherwise imagejpeg method called from GD library **/
				/*if( $transparencyFlag ) {
					imagepng ( $image1, $filePath, 9,PNG_NO_FILTER );
				} else {
					imagejpeg( $image1, $filePath, 90 );
				}
			} */
		}
		
		return true;
	}
}
?>