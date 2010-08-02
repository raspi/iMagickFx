<?php
/**
 *
 */
class iMagickEffectCropResize extends iMagickEffect
{
  public function fx()
  {
    $args = func_get_args();
    call_user_func_array(array($this->im, 'cropThumbnailImage'), $args);
    return $this->im;
  }
}