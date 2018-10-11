# debug-pooper-symfony

Tired of using symfony's dump(); method? Use 💩(); instead!

## More useful features
### Dumping prepared statements
Dumping prepared statements into a readable, and usually executable SQL strings can be useful.
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

## Requirements
- Symfony 3.3+
- PHP 7+