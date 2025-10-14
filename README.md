ChromePDF
======

[![License](https://poser.pugx.org/royalty/chrome-pdf/license)](https://packagist.org/packages/royalty/chrome-pdf)
 
**ChromePDF is an very simple Chrome PDF wrapper, written in PHP**

This library is inspired by [DomPDF](https://github.com/dompdf/dompdf), attempting 
to retain most of the applicable syntax that it uses, while reducing the amount of effort needed 
in development. It also aims to reduce the external dependency that comes along with 
using other (excellent) libraries like PuPHPeteer and chrome-php/chrome.

---

## Features

 * Works 
 
## Requirements

 * PHP version 7.1 or higher
 * Chrome

## Easy Installation

### Install with composer

To install with [Composer](https://getcomposer.org/), simply require the
latest version of this package.

```bash
composer require royalty/chrome-pdf
```

Make sure that the autoload file from Composer is loaded.

```php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';
```

### Install with git

From the command line, switch to the directory where ChromePDF will
reside and run the following commands:

```sh
git clone https://github.com/runbiscuit/ChromePDF.git
```

Require ChromePDF and it's dependencies in your PHP.

## Quick Start

Just pass your HTML in to ChromePDF and save the output:

```php
// reference the ChromePDF namespace
use Royalty\ChromePDF\ChromePDF;

// instantiate and use the ChromePDF class
$chromepdf = new ChromePDF();
$chromepdf->loadHtml('<h1>Hello world! If you can see this, this library works!</h1>');

// Save the pdf
$chromepdf->save('output.pdf');
```

### Setting Options
Set options anytime before running `save(string $output_path)`:

| Method Signature                                | Description (**default** is bolded)                      |
| ----------------------------------------------- | -------------------------------------------------------- |
| `setGPUAcceleration(bool $setting)`             | Set GPU Acceleration (on/**off**)                        |
| `setMargins(bool $setting)`                     | Set Margins (**on**/off)                                 |
| `setPDFHeaders(bool $setting)`                  | Set PDF Headers (**on**/off)                             |
| `setWindowSize($width, $height)`                | Set Window Size (default: **800x600**)                   |
| `setRenderWait($duration = 0)`                  | Set Render Wait (timeout before loading, default: **0**) |
| `improveRenderingQuality(bool $setting = true)` | Improve Rendering Quality (on/**off**)                   |

## License
This project is licensed under the The MIT License (MIT).

