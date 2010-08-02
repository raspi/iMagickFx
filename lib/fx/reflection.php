<?php
/**
 *
 */
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