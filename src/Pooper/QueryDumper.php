<?php
namespace Jspeedz\DebugPooper\Pooper;

use Doctrine\DBAL\Connection;
use Jspeedz\Exception\InvalidParameterException;
use Jspeedz\Exception\InvalidTypeException;
use PDO;

class QueryDumper {
    /**
     * Takes a query with placeholders and an array of parameters, and dumps them in a readable / executable format.
     *
     * @param string $query The query
     * @param array $params The parameters to be inserted into the placeholders in the query
     * @param int[] $types The types the parameters are in
     * @return void
     *
     * @throws InvalidParameterException
     */
    public static function dump(string $query, array $params = [], array $types = []): void {
        if(count($params) > 0) {
            if(count($types) !== 0 && count($types) !== count($params)) {
                throw new InvalidParameterException('Param count did not match type count');
            }

            $params = array_map(function($value, $key) use ($types) {
                return self::formatValue($value, isset($types[$key]) ? $types[$key] : null);
            }, $params);

            if(!is_numeric(array_pop(array_keys($params)))) {
                // These are named indexes
                foreach($params as $param => $value) {
                    $query = str_replace(':' . $param, $value, $query);
                }
            }
            else {
                // These are ?'s
                $position = strpos($query, '?');
                $i = 0;
                while($position !== false) {
                    $query = substr_replace($query, $params[$i], $position, 1);
                    $position = strpos($query, '?');
                    $i++;
                }
            }
        }

        💩($query);
    }

    /**
     * @param mixed $value
     * @param null|int $type
     *
     * @return int|string
     * @throws InvalidTypeException
     */
    private static function formatValue($value, ?int $type = null) {
        if($type === null) {
            // Do a best guess
            if(is_array($value)) {
                foreach($value as &$item) {
                    if(!is_numeric($item)) {
                        $item = '\'' . $item . '\'';
                    }
                }
                return implode(', ', $value);
            }
            elseif(!is_numeric($value)) {
                return '\'' . $value . '\'';
            }
            else {
                return $value;
            }
        }

        switch($type) {
            case PDO::PARAM_INT:
                return (int) $value;
            case PDO::PARAM_STR:
                return '"' . $value . '"';
            case Connection::PARAM_INT_ARRAY:
                $value = array_map(function($value) {
                    return (int) $value;
                }, $value);
                return implode(', ', $value);
            case Connection::PARAM_STR_ARRAY:
                $value = array_map(function($value) {
                    return '"' . $value . '"';
                }, $value);
                return implode(', ', $value);
        }

        throw new InvalidTypeException('Type is not implemented (' . $type . ')');
    }
}