<?php

namespace app\components;

use ArrayAccess;
use Closure;
use yii\base\InvalidArgumentException;

class Arr
{

    /**
     * Determine whether the given value is array accessible.
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function accessible($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Cross join the given arrays, returning all possible permutations.
     *
     * @param  iterable  ...$arrays
     * @return array
     */
    public static function crossJoin(...$arrays)
    {
        $results = [[]];

        foreach ($arrays as $index => $array) {
            $append = [];

            foreach ($results as $product) {
                foreach ($array as $item) {
                    $product[$index] = $item;

                    $append[] = $product;
                }
            }

            $results = $append;
        }

        return $results;
    }

    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @param  array  $array
     * @return array
     */
    public static function divide($array)
    {
        return [array_keys($array), array_values($array)];
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * Converts a multidimensional array to a single depth "dot" notation array,
     * optionally prepending a string to each array key.
     *
     * The key values will never be an array, even if empty. Empty arrays will be dropped.
     *
     * @param  iterable  $array
     * @param  string  $prepend
     * @return array
     */
    public static function dot($array, $prepend = '')
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && ! empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend.$key.'.'));
            } else {
                $results[$prepend.$key] = $value;
            }
        }

        return $results;
    }

    /**
     * Converts array in "dot" notation to a standard multidimensional array.
     *
     * @param array $array (Array in "dot" notation)
     * @return array
     */
    public static function undot(array $array): array
    {
        $return = [];

        foreach ($array as $key => $value) {
            self::set($return, $key, $value);
        }

        return $return;
    }

    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     *
     * @param  array  $array
     * @return bool
     */
    public static function isAssoc(array $array)
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * Explode the "value" and "key" arguments passed to "pluck".
     *
     * @param  string|array  $value
     * @param  string|array|null  $key
     * @return array
     */
    protected static function explodePluckParameters($value, $key)
    {
        $value = is_string($value) ? explode('.', $value) : $value;

        $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

        return [$value, $key];
    }

    /**
     * Push an item onto the beginning of an array.
     *
     * @param  array  $array
     * @param  mixed  $value
     * @param  mixed  $key
     * @return array
     */
    public static function prepend($array, $value, $key = null)
    {
        if (func_num_args() == 2) {
            array_unshift($array, $value);
        } else {
            $array = [$key => $value] + $array;
        }

        return $array;
    }

    /**
     * Get one or a specified number of random values from an array.
     *
     * @param  array  $array
     * @param  int|null  $number
     * @param  bool|false  $preserveKeys
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public static function random($array, $number = null, $preserveKeys = false)
    {
        $requested = is_null($number) ? 1 : $number;

        $count = count($array);

        if ($requested > $count) {
            throw new InvalidArgumentException(
                "You requested {$requested} items, but there are only {$count} items available."
            );
        }

        if (is_null($number)) {
            return $array[array_rand($array)];
        }

        if ((int) $number === 0) {
            return [];
        }

        $keys = array_rand($array, $number);

        $results = [];

        if ($preserveKeys) {
            foreach ((array) $keys as $key) {
                $results[$key] = $array[$key];
            }
        } else {
            foreach ((array) $keys as $key) {
                $results[] = $array[$key];
            }
        }

        return $results;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array  $array
     * @param  string|null  $key
     * @param  mixed  $value
     * @return array
     */
    public static function set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        foreach ($keys as $i => $key) {
            if (count($keys) === 1) {
                break;
            }

            unset($keys[$i]);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    /**
     * Get an item from an array using "dot" notation, returning an optional default value if not found.
     *
     * @param array $array (Original array)
     * @param string $key (Key to return in "dot" notation)
     * @param mixed $default (Default value to return)
     * @return mixed
     */
    public static function get(array $array, string $key, $default = NULL)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Checks if array key exists and not null using "dot" notation.
     *
     * @param array $array (Original array)
     * @param string $key (Key to check in "dot" notation)
     * @return bool
     */
    public static function has(array $array, string $key): bool
    {
        return NULL !== self::get($array, $key);
    }

    /**
     * Remove a single key, or an array of keys from a given array using "dot" notation.
     *
     * @param array $array (Original array)
     * @param string|array $keys (Key(s) to forget in "dot" notation)
     * @return void
     */
    public static function forget(array &$array, $keys): void
    {
        $original =& $array;

        foreach ((array)$keys as $key) {
            $parts = explode('.', $key);

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array =& $array[$part];
                }
            }

            unset($array[array_shift($parts)]);

            // Clean up after each iteration
            $array =& $original;
        }
    }

    /**
     * Returns the original array except given key(s).
     *
     * @param array $array (Original array)
     * @param string|array $keys (Keys to remove)
     * @return array
     */
    public static function except(array $array, $keys): array
    {
        return array_diff_key($array, array_flip((array)$keys));
    }

    /**
     * Returns array of missing keys from the original array, or an empty array if none are missing.
     *
     * @param array $array (Original array)
     * @param string|array $keys (Keys to check)
     * @return array
     */
    public static function missing(array $array, $keys): array
    {
        return array_values(array_flip(array_diff_key(array_flip((array)$keys), $array)));
    }

    /**
     * Checks if keys are missing from the original array
     *
     * @param array $array (Original array)
     * @param string|array $keys (Keys to check)
     * @return bool
     */
    public static function isMissing(array $array, $keys): bool
    {
        return (bool)self::missing($array, $keys);
    }

    /**
     * Sort a multidimensional array by a given key in ascending (optionally, descending) order.
     *
     * @param array $array (Original array)
     * @param string $key (Key name to sort by)
     * @param bool $descending (Sort descending)
     * @return array
     */
    public static function multiSort(array $array, string $key, bool $descending = false): array
    {
        $columns = array_column($array, $key);

        if (false === $descending) {
            array_multisort($columns, SORT_ASC, $array, SORT_NUMERIC);
        } else {
            array_multisort($columns, SORT_DESC, $array, SORT_NUMERIC);
        }

        return $array;
    }

    /**
     * Rename array keys while preserving their order.
     *
     * @param array $array (Original array)
     * @param array $keys (Key/value pairs to rename)
     * @return array
     */
    public static function renameKeys(array $array, array $keys): array
    {
        $new_array = [];

        foreach ($array as $k => $v) {
            if (array_key_exists($k, $keys)) {
                $new_array[$keys[$k]] = $v;
            } else {
                $new_array[$k] = $v;
            }
        }

        return $new_array;
    }

    /**
     * Order an array based on an array of keys.
     *
     * Keys from the $order array which do not exist in the original array will be ignored.
     *
     * @param array $array (Original array)
     * @param array $order (Array of keys in the order to be returned)
     * @return array
     */
    public static function order(array $array, array $order): array
    {
        return self::only(array_replace(array_flip($order), $array), array_keys($array));
    }

    /**
     * Return an array of values which exist in a given array.
     *
     * @param array $array
     * @param array $values
     * @return array
     */
    public static function getAnyValues(array $array, array $values): array
    {
        return array_intersect($values, Arr::dot($array));
    }

    /**
     * Do any values exist in a given array.
     *
     * @param array $array
     * @param array $values
     * @return bool
     */
    public static function hasAnyValues(array $array, array $values): bool
    {
        return !empty(self::getAnyValues($array, $values));
    }

    /**
     * Do all values exist in a given array.
     *
     * @param array $array
     * @param array $values
     * @return bool
     */
    public static function hasAllValues(array $array, array $values): bool
    {
        return count(array_intersect($values, Arr::dot($array))) == count($values);
    }

    /**
     * Shuffle the given array and return the result.
     *
     * @param  array  $array
     * @param  int|null  $seed
     * @return array
     */
    public static function shuffle($array, $seed = null)
    {
        if (is_null($seed)) {
            shuffle($array);
        } else {
            mt_srand($seed);
            shuffle($array);
            mt_srand();
        }

        return $array;
    }

    /**
     * Recursively sort an array by keys and values.
     *
     * @param  array  $array
     * @param  int  $options
     * @param  bool  $descending
     * @return array
     */
    public static function sortRecursive($array, $options = SORT_REGULAR, $descending = false)
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = static::sortRecursive($value, $options, $descending);
            }
        }

        if (static::isAssoc($array)) {
            $descending
                ? krsort($array, $options)
                : ksort($array, $options);
        } else {
            $descending
                ? rsort($array, $options)
                : sort($array, $options);
        }

        return $array;
    }

    /**
     * Convert the array into a query string.
     *
     * @param  array  $array
     * @return string
     */
    public static function query($array)
    {
        return http_build_query($array, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * Filter the array using the given callback.
     *
     * @param  array  $array
     * @param  callable  $callback
     * @return array
     */
    public static function where($array, callable $callback)
    {
        return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * If the given value is not an array and not null, wrap it in one.
     *
     * @param  mixed  $value
     * @return array
     */
    public static function wrap($value)
    {
        if (is_null($value)) {
            return [];
        }

        return is_array($value) ? $value : [$value];
    }

    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public static function value($value, ...$args)
    {
        return $value instanceof Closure ? $value(...$args) : $value;
    }

    /**
     * Returns whether all the elements in the array are numeric.
     *
     * @param array $array
     * @return bool
     */
    public static function isNumeric(array $array): bool
    {
        foreach ($array as $val) {
            if (!is_numeric($val)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Renames an item in an array. If the new key already exists in the array and the old key doesn’t,
     * the array will be left unchanged.
     *
     * @param array $array the array to extract value from
     * @param string $oldKey old key name of the array element
     * @param string $newKey new key name of the array element
     */
    public static function rename(array &$array, string $oldKey, string $newKey)
    {
        if (!array_key_exists($newKey, $array) || array_key_exists($oldKey, $array)) {
            $array[$newKey] = static::forget($array, $oldKey);
        }
    }

}