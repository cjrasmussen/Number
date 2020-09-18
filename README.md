# Number

Simple functions for numeric conversions.


## Usage

```php
use cjrasmussen\Number\Convert;

$num = Convert::intToOrdinal(153);
echo $num; // 153rd

$num = Convert::intToEnglish(153);
echo $num; // one-hundred fifty-three

$num = Convert::intToRoman(153);
echo $num; // CLIII
```

## Installation

Simply add a dependency on cjrasmussen/number to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:

```sh
composer require cjrasmussen/number
```

Although it's recommended to use Composer, you can actually include the file(s) any way you want.


## License

Number is [MIT](http://opensource.org/licenses/MIT) licensed.