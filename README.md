# debug-pooper-symfony

Tired of using symfony's dump(); method? Use 💩(); instead!

## More useful features
### Dumping prepared statements
Dumping prepared statements into a readable, and usually executable SQL strings can be useful.

#### Example 1:

```php
QueryDumper::dump(
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
QueryDumper::dump(
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

## Install
Please only install this package for dev:

`composer require --dev jspeedz/debug-pooper-symfony`

Enable the core debug methods you want manually by adding the following files to your core _composer.json_ file in the _autoload-dev_ section:
```json
    "autoload-dev": {
        "files": [
            "vendor/jspeedz/debug-pooper-symfony/src/Component/VarDumper/Resources/functions/dump.php",
            "vendor/jspeedz/debug-pooper-symfony/src/Component/VarDumper/Resources/functions/dumpquery.php"
        ]
    },
```

## Requirements
- Symfony 3.3+
- PHP 7+