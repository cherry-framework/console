# Cherry-Console
CLI Console for Cherry-project.


[![GitHub license](https://img.shields.io/github/license/cherry-framework/console.svg)](https://github.com/cherry-framework/console/blob/master/LICENSE)

[![GitHub release](https://img.shields.io/github/release/cherry-framework/console.svg)](https://github.com/cherry-framework/console/releases)

[![Packagist Version](https://img.shields.io/packagist/v/cherry-project/console.svg "Packagist Version")](https://packagist.org/packages/cherry-project/console "Packagist Version")

------------

## Including
**Install from composer** `composer require cherry-project/console`

Next you must create executable PHP script  (Ex.: console).

**Note** Add this line at top of your console for executing 
it in PHP interpreter: `#!/usr/bin/env php`

**Include Autoloader in console**
```php
require_once __DIR__ . '/vendor/autoload.php';
```

## Usage

Import classes

```php
use Cherry\Console\Console;
use Cherry\Kernel;
```

Create new Kernel and Console instance
```php
$app = new Kernel(__DIR__);

$console = new Console();
```

Now you can get console help message:

`php console --help`

or

`./console --help`

**2019 &copy; Cherry-project**
