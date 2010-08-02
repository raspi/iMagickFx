<?php
/**
 * 
 */
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