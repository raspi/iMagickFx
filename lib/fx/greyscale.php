<?php
/**
 *
 */
class iMagickEffectGreyScale extends iMagickEffect
{
  public function fx()
  {
    $this->im->modulateImage(100, 0, 100);
    return $this->im;
  }
}