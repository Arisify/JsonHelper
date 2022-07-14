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

use arisify\jsonhelper\exception\JsonMissingRequiredPropertyException;

class JsonObject{
	public function __construct(public \stdClass $data, public array $required = []){
		foreach ($this->required as $property) {
			if (!isset($this->data->{$property})) {
				throw new JsonMissingRequiredPropertyException("Missing $property");
			}
		}
	}

	public static function parse(string $json, array $required = []) : self{
		return new JsonObject(json_decode($json, true, 512, JSON_THROW_ON_ERROR), $required);
	}

	public function dump() : string{
		return json_encode($this->data, JSON_THROW_ON_ERROR);
	}

	public function toArray() : array{
		return get_object_vars($this->data);
	}

	public function addProperty(string $property, mixed $value) : void{
		$this->data->{$property} = $value;
    }

	public function getProperty(string $property, mixed $default = null) : mixed{
		return $this->data->{$property} ?? $default;
	}

	public function setProperty(string $property, mixed $value, bool $strict = false) : bool{
		$old = $this->data?->{$property};
		if ($old === null) {
			return false;
		}
		if ($strict && gettype($old) !== gettype($value)) {
			return false;
		}
		$this->data->{$property} = $value;
		return true;
	}

	public function removeProperty(string $property) : bool{
		if (in_array($property, $this->required, true)) {
			return false;
		}
		if (isset($this->data->{$property})) {
			unset($this->data->{$property});
			return true;
		}
		return false;
    }

	public function getData() : \stdClass{
		return $this->data;
	}

	/**
	 * @param \stdClass $data
	 */
	public function setData(\stdClass $data) : void{
		$this->data = $data;
	}
}