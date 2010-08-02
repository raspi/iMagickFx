<?php
require_once realpath(dirname(__FILE__) . '/../lib/imagickfx.php');

switch($_GET['example'])
{
  default: break;

  case 'original':
    $im = new iMagickFx('apple.jpg');
    header('Content-Type: ' . strtolower($im->getImageType()));
    echo $im;
  break;

  case 'grey':
    $im = new iMagickFx('apple.jpg');
    $im->fxGreyScale();
    header('Content-Type: ' . strtolower($im->getImageType()));
    echo $im;
  break;

  case 'crop-round-shadows':
    $im = new iMagickFx('apple.jpg');
    $im->fxCropResize(120, 120)->fxRoundCorners()->fxDropShadow();
    header('Content-Type: ' . strtolower($im->getImageType()));
    echo $im;
  break;

  case 'crop-reflection':
    $im = new iMagickFx('apple.jpg');
    $im->fxCropResize(200, 200)->fxReflection('white', 0.9);
    header('Content-Type: ' . strtolower($im->getImageType()));
    echo $im;
  break;


} // /switch
?>
<html>
<head>
  <title>iMagickFx - Examples</title>
</head>
<body>
  Original image:<br />
  <img src="?example=original" alt="" /><br />

  Greyscale:<br />
  <img src="?example=grey" alt="" /><br />

  Crop resize to 120x120 + add rounded corners + drop shadow:<br />
  <img src="?example=crop-round-shadows" alt="" /><br />

  Crop resize to 200x200 + add reflection:<br />
  <img src="?example=crop-reflection" alt="" /><br />

</body>
</html>