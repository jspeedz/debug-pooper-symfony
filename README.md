# debug-pooper-symfony

Tired of using symfony's dump(); method? Use 💩(); instead!

[![Build Status](https://travis-ci.com/jspeedz/debug-pooper-symfony.svg?branch=master)](https://travis-ci.com/jspeedz/debug-pooper-symfony) [![Coverage Status](https://coveralls.io/repos/github/jspeedz/debug-pooper-symfony/badge.svg?branch=master)](https://coveralls.io/github/jspeedz/debug-pooper-symfony?branch=master) [![GitHub license](https://img.shields.io/github/license/jspeedz/debug-pooper-symfony.svg)](https://github.com/jspeedz/debug-pooper-symfony/blob/master/LICENSE)

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

### Dumping simple XML element objects
Converting and dumping SimpleXmlObjects into a readable string.

#### Example 1:

```php
dumpSimpleXmlElement(
    simplexml_load_string('<?xml version="1.0" encoding="utf-8" ?><root><someElement>someValue</someElement></root>')
);
```
Result:

```SimpleXML object (1 item)
[
    Element {
        Name: 'root'
        String Content: ''
        Content in Default Namespace
            Children: 1 - 1 'someElement'
            Attributes: 0
    }
]
```


### Dumping simple XML element object trees
Converting and dumping SimpleXmlObjects into a readable tree string.

#### Example 1:

```php
dumpSimpleXmlElementTree(
    simplexml_load_string('<?xml version="1.0" encoding="utf-8" ?><root><someElement>someValue</someElement></root>')
);
```
Result:

```SimpleXML object (1 item)
   [0] // <root>
   	->someElement[0]
   		(string) 'someValue' (9 chars)
```

## Utilities
### Timing a block of code
```php
$timer = debugTimer();
sleep(1);
$timeInMs = $timer();
```

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

```php
if($this->container->getParameter('kernel.environment') === 'dev') {
    dumpRequest();
    die(__FILE__ . ':' . __LINE__);
}
```

```php
if($this->container->getParameter('kernel.environment') === 'dev') {
    $timer = debugTimer();
    // Do some work
    💩($END$);
    $taskTookMs = $timer();
    echo 'Completed task in ' . $taskTookMs . 'ms!' . PHP_EOL;
    die(__FILE__ . ':' . __LINE__);
}
```

```php
if($this->container->getParameter('kernel.environment') === 'dev') {
    dumpSimpleXmlElement($END$);
    die(__FILE__ . ':' . __LINE__);
}
```

```php
if($this->container->getParameter('kernel.environment') === 'dev') {
    dumpSimpleXmlElementTree($END$);
    die(__FILE__ . ':' . __LINE__);
}
```

## Install
Please only install this package for development:

`composer require --dev jspeedz/debug-pooper-symfony`

## Requirements
- Symfony 3.3+
- PHP 7.1+
