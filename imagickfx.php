<?php
abstract class iMagickEffect
{
  protected $im = null;

  public function __construct(IMagick $im)
  {
    if (false === ($im instanceOf IMagick))
    {
      throw new Exception('not valid instance');
    }

    $this->im = $im;
  }

  public function getIM()
  {
    return $this->im;
  }

  public function fx()
  {
    throw new Exception('Not implemented');
  }

}

class iMagickEffectGreyScale extends iMagickEffect
{
  public function fx()
  {
    $this->im->modulateImage(100, 0, 100);
    return $this->im;
  }
}

class iMagickEffectCropResize extends iMagickEffect
{
  public function fx()
  {
    $args = func_get_args();
    call_user_func_array(array($this->im, 'cropThumbnailImage'), $args);
    return $this->im;
  }
}

class iMagickEffectReflection extends iMagickEffect
{
  /**
   *
   * @param mixed color
   * @param float opacity
   */
  public function fx($color = 'black', $opacity = 0.3)
  {

    $this->im->setImageFormat('png');

    $reflection = $this->im->clone();
    $reflection->flipImage();

    $gradient = new Imagick();
    $gradient->newPseudoImage($reflection->getImageWidth(), $reflection->getImageHeight(), "gradient:transparent-$color");
    $reflection->compositeImage($gradient, imagick::COMPOSITE_OVER, 0, 0);
    $reflection->setImageOpacity($opacity);

    $canvas = new Imagick();
    $canvas->newImage($this->im->getImageWidth(), $this->im->getImageHeight() * 2, $color, "png");
    $canvas->compositeImage($this->im, imagick::COMPOSITE_OVER, 0, 0);
    $canvas->compositeImage($reflection, imagick::COMPOSITE_OVER, 0, $this->im->getImageHeight());

    return $canvas;
  }
}

class iMagickEffectRoundCorners extends iMagickEffect
{
  public function fx($width = 5, $height = null)
  {
    if (null === $height) {$height = $width;}

    $this->im->setImageFormat('png');

    $this->im->roundCorners($width, $height);

    return $this->im;
  }
}


class iMagickEffectDropShadow extends iMagickEffect
{
  public function fx()
  {
    $this->im->setImageFormat('png');

    $shadow = $this->im->clone();
    $shadow->setImageBackgroundColor(new ImagickPixel('black'));
    $shadow->shadowImage(80, 3, 5, 5);
    $shadow->compositeImage($this->im, Imagick::COMPOSITE_OVER, 0, 0 );
    
    return $shadow;
  }
}



class iMagickFx 
{
  public $im = null;
  public $throwExceptionOnMissingFx = true;

  public function __construct($params = null)
  {
    $this->im = new iMagick($params);
  }

  public function __toString()
  {
    return $this->im->__toString();
  }

  public function __call($name, array $arguments)
  {
    if (substr($name, 0, 2) === 'fx')
    {
      $name = 'iMagickEffect' . substr($name, 2);

      if (class_exists($name))
      {
        $fx = new $name($this->im);
        $this->im = call_user_func_array(array($fx, 'fx'), $arguments);
      }
      else
      {
        if ($this->throwExceptionOnMissingFx)
        {
          throw new Exception("Unknown effect: $name");
        }
      }
    }
    else
    {
      return call_user_func_array(array($this->im, $name), $arguments);
    }
    
    return $this;
  }
}
