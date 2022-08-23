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
	private string $title;
	private string $type;
	private ?SchemaElement $element;

	public function __construct(JsonObject $object) {
		$this->title = JsonHelper::getAsString($object, "title", "");
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

    public function getRequired() : ?array {
        return $this->required;
    }

    public function setRequired(?array $required) : void {
        $this->required = $required;
    }

    public function getTitle() : ?string {
        return $this->title;
    }

    public function setTitle(?string $title): void {
        $this->title = $title;
    }

    public function getElement() : SchemaElement {
        return $this->element;
    }

    public function setElement(SchemaElement $element) : void {
        $this->element = $element;
    }

    public function getType() : ?string {
        return $this->type;
    }

    public function setType(?string $type) : void {
        $this->type = $type;
    }
}