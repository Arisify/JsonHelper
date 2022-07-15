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

namespace arisify\jsonhelper\schema;

use arisify\jsonhelper\exception\SchemaInvalidElementTypeException;
use arisify\jsonhelper\JsonHelper;
use arisify\jsonhelper\JsonObject;
use arisify\jsonhelper\schema\type\SchemaArray;
use arisify\jsonhelper\schema\type\SchemaBool;
use arisify\jsonhelper\schema\type\SchemaElement;
use arisify\jsonhelper\schema\type\SchemaFloat;
use arisify\jsonhelper\schema\type\SchemaInt;
use arisify\jsonhelper\schema\type\SchemaObject;
use arisify\jsonhelper\schema\type\SchemaString;

class Schema{
	private array $required;
	private string $tilte;
	private string $type;
	private ?SchemaElement $element;

	public function __construct(JsonObject $object) {
		$this->tilte = JsonHelper::getAsString($object, "title", "");
		$this->type = JsonHelper::getAsString($object, "type", "");
		$this->element = match($this->type) {
			SchemaObject::TYPE => new SchemaObject($object->getProperty("properties")),
			SchemaArray::TYPE => new SchemaArray(),
			SchemaString::TYPE => new SchemaString($object->getProperty("enum")),
			SchemaBool::TYPE => new SchemaBool(),
			SchemaInt::TYPE => new SchemaInt(),
			SchemaFloat::TYPE => new SchemaFloat(),
			default => null
		};
		if ($this->element === null) {
			throw new SchemaInvalidElementTypeException("");
		}
		$this->required = JsonHelper::getAsArray($object, "required", []);
	}
}