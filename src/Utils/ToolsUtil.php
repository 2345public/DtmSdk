<?php
/**
 * 工具类
 */
namespace OA\DtmSdk\Utils;

class ToolsUtil
{
    /**
     * Gets the value of an environment variable.
     * @param  string $key 键
     * @param  mixed $default 默认值
     * @return mixed
     */
    public static function env(string $key, $default = null)
    {
        if (isset($_ENV[$key])) {
            $value = $_ENV[$key];
        } elseif (isset($_SERVER[$key])) {
            $value = $_SERVER[$key];
        } elseif (function_exists('putenv') && function_exists('getenv')) {
            $value = getenv($key);
        } else {
            $value = false;
        }
        if ($value === false) {
            return $default;
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null; // 明确返回 null 或者直接 return 均可
        }
        $len = strlen($value);
        if ($len > 1 && $value[0] == '"' && $value[$len - 1] == '"') {
            return substr($value, 1, -1);
        }
        return $value;
    }
}
