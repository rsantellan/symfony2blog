<?php

namespace Maith\Common\ImageBundle\Model;


use Imagine\Imagick\Imagine as mImagick;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * Description of MyImageManager
 *
 * @author rodrigo
 */
class MyImageService {
  
  private $imageInterface = null;
  private $cache_dir = NULL;
  private $root_dir = NULL;
  
  public function __construct() {
    $this->imageInterface = new mImagick();
    $kernel_container = $GLOBALS['kernel']->getContainer()->get('kernel');
    $this->root_dir = $kernel_container->getRootDir() ;
    $this->cache_dir = $kernel_container->getCacheDir() ;
  }
  
  public function doResize($image_path = "", $width = 100, $height = 100)
  {
    //exit(0);
    $aux = "/home/rodrigo/proyectos/symfony-proyectos/symfony2/blog/Symfony/app/../web/upload/album-1/51ba2c4d78806.jpeg";
    
    $tmp_file = $this->retrieveCachePath($aux, 'crop_resize', array('c', 'p0x0', 'b250x250', 'r', 'b400x400'));
    $this->imageInterface->open($aux)->crop(new Point(0, 0), new Box(250, 250))->resize(new Box(400, 400))->save($tmp_file);
    $tmp_file = $this->retrieveCachePath($aux, 'resize_crop', array('r', 'b400x400', 'c', 'p0x0', 'b250x250'));
    $this->imageInterface->open($aux)->resize(new Box(400, 400))->crop(new Point(0, 0), new Box(250, 250))->save($tmp_file);
    $tmp_file = $this->retrieveCachePath($aux, 'resize', array('r', 'b400x400'));
    $this->imageInterface->open($aux)->resize(new Box(400, 400))->save($tmp_file);
    $auxImage = $this->imageInterface->open($aux);
    $tmp_file = $this->retrieveCachePath($aux, 'resize_widen', array('r', 'w700'));
    $auxImage->resize($auxImage->getSize()->widen( 700 ))->save($tmp_file);
    $tmp_file = $this->retrieveCachePath($aux, 'thumbnail', array('r', 'b400x400'));
    $this->imageInterface->open($aux)->thumbnail(new Box(400, 400))->save($tmp_file);
    $tmp_file = $this->retrieveCachePath($aux, 'thumbnail_outbound', array('r', 'b400x400'));
    $this->imageInterface->open($aux)->thumbnail(new Box(400, 400), \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($tmp_file);
    
  }
  
  public function doResizeCropExact($image_path, $width, $height)
  {
    if(!is_file($image_path)){
      throw new \Exception("No file in that path", 10005);
    }
    $mesures = "b".$height."x".$width;
    $tmp_file = $this->retrieveCachePath($image_path, 'rce', array('r', $mesures));
    if(is_file($tmp_file))
    {
      return $tmp_file;
    }
    
    $image = $this->imageInterface->open($image_path);
    $originalWidth = $image->getSize()->getWidth();
    $originalHeight = $image->getSize()->getHeight();
    
    $width_ratio = $originalWidth / $width;
    $height_ratio = $originalHeight / $height;
    $resize_width = 0;
    $resize_height = 0;
    
    if(($originalWidth <= $width) && ($originalHeight <= $height))
    {
      //Dont do nothing
    }
    else
    {
      $crop_x = 0;
      $crop_y = 0;
      if($height_ratio < $width_ratio)
      {
        $resize_height = $height;
        $resize_width = ceil(($width * $originalHeight) / $originalWidth);
        $crop_x = ceil(($resize_width - $width) / 2);
      }
      else
      {
        $resize_height = ceil(($height * $originalWidth) / $originalHeight);
        $resize_width = $width;
        $crop_y = ceil(($resize_height - $height) / 2);
      }
      $image->resize(new Box($resize_width, $resize_height));
      $image->crop(new Point($crop_x,$crop_y), new Box($width, $height));
      
    }
    $image->save($tmp_file);
    return $tmp_file;
  }
  
  public function doThumbnail($image_path, $width, $height)
  {
    if(!is_file($image_path)){
      throw new \Exception("No file in that path", 10005);
    }
    $mesures = "b".$height."x".$width;
    $tmp_file = $this->retrieveCachePath($image_path, 'thumbnail', array('r', $mesures));
    if(is_file($tmp_file))
    {
      return $tmp_file;
    }
    $this->imageInterface->open($image_path)->thumbnail(new Box($width, $height))->save($tmp_file);
    return $tmp_file;
  }
  
  public function doOutboundThumbnail($image_path, $width, $height)
  {
    if(!is_file($image_path)){
      throw new \Exception("No file in that path", 10005);
    }
    $mesures = "b".$height."x".$width;
    $tmp_file = $this->retrieveCachePath($image_path, 'thumbnail', array('r', $mesures));
    if(is_file($tmp_file))
    {
      return $tmp_file;
    }
    $this->imageInterface->open($image_path)->thumbnail(new Box($width, $height), \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($tmp_file);
    return $tmp_file;
  }
  
  public function retrieveCachePath($path, $type, $parameters = array())
  {
    if(strpos($path, $this->root_dir) !== FALSE)
    {
      //El archivo original es de la aplicacion
      $aux_string = $path;
      //Reviso si el archivo tiene el ../web
      if(strpos($path, "../web") !== FALSE)
      {
        $aux_string = str_replace("../web", "web", $aux_string);
      }
      $cache_string = str_replace($this->root_dir, $this->cache_dir, $aux_string);
      //var_dump($cache_string);
      $cache_path_info = pathinfo($cache_string);
      //var_dump($cache_path_info);
      //$cache_path_info["extension"];
      $file_extension = "png";
      if($this->validateFileExtension($cache_path_info["extension"]))
      {
        $file_extension = $cache_path_info["extension"];
      }
      $cache_file_name =  $cache_path_info["filename"].".".$cache_path_info["extension"];
      return $this->checkDirectoryPath($cache_path_info["dirname"].DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR.implode("", $parameters).DIRECTORY_SEPARATOR). $cache_file_name;
    }
    throw new \Exception("No funca con cosas de afuera (por lo menos por ahora....)");
    //return $path;
  }
  
  private function validateFileExtension($file_extension)
  {
    //Deberia de chequear que la extension sea valida para que la libreria la procese.
    return $file_extension;
  }
  
  private function checkDirectoryPath($directory_path)
  {
    //var_dump($directory_path);
    if(!is_dir($directory_path))
    {
      mkdir($directory_path, 0755, true);
    }
    return $directory_path;
  }

}


