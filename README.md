# TwigExtensions

Some helpful Twig extensions

## ColorLuminance
Modify luminance of hex RGB value

```twig
{{ ColorLuminance('#BADA55', 0.1) }}
```

## Image
A wrapper for [Gregwar/Image](https://github.com/Gregwar/Image)

```twig
<img src="{{ image('/img/big/image.jpg').resize(42, 42) }}">
<img src="{{ image('/img/big/image.jpg').sepia() }}">
```
