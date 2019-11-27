[![Build Status](https://travis-ci.org/paveljanda/php-openapi-specificaion-expander.svg?branch=master)](https://travis-ci.org/paveljanda/php-openapi-specificaion-expander)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/paveljanda/php-openapi-specificaion-expander/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/paveljanda/php-openapi-specificaion-expander/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/paveljanda/php-openapi-specificaion-expander/v/stable)](https://packagist.org/packages/paveljanda/php-openapi-specificaion-expander)
[![License](https://poser.pugx.org/paveljanda/php-openapi-specificaion-expander/license)](https://packagist.org/packages/paveljanda/php-openapi-specificaion-expander)
[![Total Downloads](https://poser.pugx.org/paveljanda/php-openapi-specificaion-expander/downloads)](https://packagist.org/packages/paveljanda/php-openapi-specificaion-expander)

paveljanda/php-openapi-specificaion-expander
============================================

This tool let's you expand recursively definitions in open api specifiation (JSON/YAML)

## Installation

```bash
composer require paveljanda/php-openapi-specificaion-expander
```

## Example - YAML

```php
require __DIR__ . '/vendor/autoload.php';

use PavelJanda\OpenAPIExpander\OpenAPIExpander;
use Symfony\Component\Yaml\Yaml;

$specData = Yaml::parseFile(__DIR__ . '/openapiv3.yaml');

$expandedData = (new OpenAPIExpander)->expand($specData);

echo Yaml::dump($expandedData, 100, 2);
```

## Example - JSON

```php
require __DIR__ . '/vendor/autoload.php';

use PavelJanda\OpenAPIExpander\OpenAPIExpander;

$specData = json_decode(file_get_contents(__DIR__ . '/openapiv3.json'));

$expandedData = (new OpenAPIExpander)->expand($specData);

echo json_encode($expandedData, JSON_PRETTY_PRINT);
```
