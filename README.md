# GA\Fuel helper methods package

GA is abbreviation stand for Gubnota-Artwell (two's company name) and makes it easier to recognise package.

## Installing

Simply add `ga` to your config.php `always_loaded.packages` config option.

## Included Parsers

* Intl - replacement for default Lang that change default behavior in case there is no language file for default language. Instead of returning an empty string value for nonexisted key it will return same string as in argument.

## Usage
### Intl
By default, language file should be located in `fuel/app/lang/en/example.php`, e.g.:
```php
return ['word_definition_in_english'=>'word definition in other language'];
```

Use like in [fuelphp.com doc](http://fuelphp.com/docs/classes/lang.html) example:
```php
Intl::load('example');
echo Intl::get('word_definition_in_english'); // will echoes 'word definition in other language'
```
All other commands will retain.

### Uuid
Let you generate unique id like '''3RPNH-RTFZ1-XTRZA-EHW9V-PN3LG-RT9E1-LHS95-9ZYPZ''':
```php
echo Ga\Uuid::generate(); // will echoes 
```
By default contains 47 symbols (with dashes) or 40 symbols w/o it [A-Z0-9] without ''I'', ''O'', ''0''.

## Installing GA\helpers

Clone to your `fuel/packages` subfolder, new folder named `ga`.

## Config and runtime config

Because of simplicity of current version, there is no config options available. You can make changes making fork.
