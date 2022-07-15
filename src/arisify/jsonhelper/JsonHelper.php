<?php
/**
 * This file is part of the JsonHelper ©2022
 *
 * @author Arisify
 * @link   https://github.com/Arisify
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * •.,¸,.•*`•.,¸¸,.•*¯ ╭━━━━━━━━━━━━╮
 * •.,¸,.•*¯`•.,¸,.•*¯.|:::::::/\___/\
 * •.,¸,.•*¯`•.,¸,.•* <|:::::::(｡ ●ω●｡)
 * •.,¸,.•¯•.,¸,.•╰ *  し------し---Ｊ
 *
 */
declare(strict_types=1);

namespace arisify\jsonhelper;

class JsonHelper{
	public static function getAsObject(JsonObject $object, $key, bool $rawObjectData = false, array $required = [], ?\stdClass $default = null) : \stdClass|JsonObject|null{
		$result = $object->getProperty($key, $default);
		if ($result === null) {
			return null;
		}
		if (!is_object($result)) {
			$result = (object) $result;
		}
		return $rawObjectData ? $result : new JsonObject($result, $required);
	}

	public static function getAsInt(JsonObject $object, $key, ?int $default = null) : ?int{
		$result = $object->getProperty($key, $default);
		return is_null($result) || is_int($result) ? $result : (int) $result;
	}

	public static function getAsFloat(JsonObject $object, $key, ?float $default = null) : ?float{
		$result = $object->getProperty($key, $default);
		return is_null($result) || is_float($result) ? $result : (float) $result;
	}

	public static function getAsString(JsonObject $object, $key, ?string $default = null) : ?string{
		$result = $object->getProperty($key, $default);
		return is_null($result) || is_string($result) ? $result : (string) $result;
	}

	public static function getAsBool(JsonObject $object, $key, ?bool $default = null) : ?bool{
		$result = $object->getProperty($key, $default);
		return is_null($result) || is_bool($result) ? $result : (bool) $result;
	}

	public static function getAsArray(JsonObject $object, $key, ?array $default = null) : ?array{
		$result = $object->getProperty($key, $default);
		return is_null($result) || is_array($result) ? $result : (array) $result;
	}

	/**
	 * Poorly made :C
	 * @param JsonObject $object
	 * @param            $key
	 * @param array      $type
	 * @param mixed|null $default
	 * @return mixed
	 */
	public static function getAsOneOf(JsonObject $object, $key, array $type, mixed $default = null) : mixed{
		$result = $object->getProperty($key, $default);
		$t = gettype($result);
		if (in_array($t, $type, true)) {
			return $result;
		}
		return $default;
	}
}