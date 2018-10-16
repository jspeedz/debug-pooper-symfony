# debug-pooper-symfony

Tired of using symfony's dump(); method? Use 💩(); instead!

[![GitHub license](https://img.shields.io/github/license/jspeedz/debug-pooper-symfony.svg)](https://github.com/jspeedz/debug-pooper-symfony/blob/master/LICENSE)

## More useful features
### Dumping prepared statements
Dumping prepared statements into a readable, and usually executable SQL strings can be useful.

#### Example 1:

```php
dumpQuery(
    'SELECT 1 FROM x WHERE y = ?',
    [
        1234
    ],
    [
        \PDO::PARAM_INT
    ]
);
```
Result:

`SELECT 1 FROM x WHERE y = 1234`

#### Example 2:

```php
dumpQuery(
    'SELECT 1 FROM x WHERE y = :some_named_value',
    [
        'some_named_value' => 1234
    ],
    [
        \PDO::PARAM_INT
    ]
);
```
Result:

`SELECT 1 FROM x WHERE y = 1234`

### Dumping request information
```php
dumpRequest();
```

Result:

`To be determined..`

## Code templates
### PhpStorm Live templates
```php
if($this->container->getParameter('kernel.environment') === 'dev') {
    💩($END$);
    die(__FILE__ . ':' . __LINE__);
}
```

```php
if($this->container->getParameter('kernel.environment') === 'dev') {
    dumpQuery($END$);
    die(__FILE__ . ':' . __LINE__);
}
```

## Install
Please only install this package for development:

`composer require --dev jspeedz/debug-pooper-symfony`

## Requirements
- Symfony 3.3+
- PHP 7.1+
