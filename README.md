iMagickFx - Effects for iMagick library (PHP module)

# Examples

```php
$im = new iMagickFx('example.jpg');
$im->fxCropResize(100, 100)->fxReflection('white', 0.9);

$im = new iMagickFx('example.jpg');
$im->fxCropResize(100, 100)->fxRoundCorners()->fxDropShadow();
```

See also doc/example.php
