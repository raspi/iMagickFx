<?php
/**
 *
 */
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