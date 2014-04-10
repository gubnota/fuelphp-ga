# GA\Fuel helper methods package

GA is abbreviation stand for Gubnota-Artwell (two's company name) and makes it easier to recognise package.

## Installing

Simply add `ga` to your config.php `always_loaded.packages` config option.

## Included Parsers

* Intl - replacement for default Lang that change default behavior in case there is no language file for default language. Instead of returning an empty string value for nonexisted key it will return same string as in argument.

## Usage

```php
// old usage still valid, will load app/views/example.php
Intl::get('word_definition_in_english');
```

## Installing GA\helpers

Clone to your `fuel/packages` subfolder, new folder named `ga`.

## Config and runtime config

Because of simplicity of current version, there is no config options available. You can make changes making fork.