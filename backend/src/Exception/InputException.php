<?php

namespace Hole\Exception;

class InputException extends \Exception
{
    const REQUIRED = 'El campo es requerido';
    const INVALID = 'Los datos son invalidos';

    private $nested = array();

    public function __construct($fieldName = '', $message = self::REQUIRED, $code = null, $previous = null)
    {
        if ($fieldName) {
            $this->addErrorMsg($fieldName, $message, $code, $previous);
        }
        parent::__construct('_INPUT_EXCEPTION', $code, $previous);
    }

    public function addFieldError($fieldName = '', $message = self::REQUIRED, $code = null, $previous = null)
    {
        $obj = new \stdClass();
        $obj->fieldName = $fieldName;
        $obj->message = $message;
        $obj->code = $code;
        $obj->previous = $previous;
        $this->nested[] = $obj;
    }

    public function hasFieldErrors()
    {
        return (bool) $this->nested;
    }

    public function getFieldErrors()
    {
        return $this->nested;
    }

    public function throwOnError()
    {
        if ($this->hasFieldErrors()) {
            throw $this;
        }
    }
}