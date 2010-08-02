<?php
/**
 * http://github.com/raspi/iMagickFx
 */


/**
 * Base for exceptions
 */
class iMagickEffectException extends Exception
{

}

/**
 * Base for effects
 */
abstract class iMagickEffect
{
  /**
   *
   * @var iMagick
   */
  protected $im = null;

  public function __construct(IMagick $im)
  {
    if (false === ($im instanceOf IMagick))
    {
      throw new iMagickEffectException('not valid instance');
    }

    $this->im = $im;
  }

  public function getIM()
  {
    return $this->im;
  }

  /**
   * All effects call this method
   */
  public function fx()
  {
    throw new iMagickEffectException('Effect not implemented');
  }

}

/**
 * 
 *
 * <code>
 * $im = new iMagickFx('example.jpg');
 * $im->fxCropResize(100, 100)->fxReflection('white', 0.9);
 * </code>
 */
class iMagickFx 
{
  /**
   *
   * @var IMagick
   */
  public $im = null;

  /**
   * Throw exception on missing effects?
   * @var boolean
   */
  public $throwExceptionOnMissingFx = true;

  public function __construct($params = null)
  {
    if (false === class_exists('iMagick'))
    {
      throw new iMagickEffectException('IMagick class not found. Module missing or not loaded?');
    }

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
      $fxName = basename(substr($name, 2));
      $className = 'iMagickEffect' . $fxName;
      $fxFile = dirname(__FILE__) . '/fx/' . strtolower($fxName) . '.php';

      if (false === class_exists($className) && true === file_exists($fxFile))
      {
        require_once $fxFile;
      }

      if (class_exists($className))
      {
        // Call effect
        $fx = new $className($this->im);
        $this->im = call_user_func_array(array($fx, 'fx'), $arguments);
      }
      else
      {
        if ($this->throwExceptionOnMissingFx)
        {
          // Effect of given name was not found
          throw new Exception("Unknown effect: '$name'");
        }
      }
    }
    else
    {
      // Call iMagick's own method
      return call_user_func_array(array($this->im, $name), $arguments);
    }
    
    return $this;
  }
}
