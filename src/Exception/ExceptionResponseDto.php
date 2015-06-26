<?php

namespace Hole\Exception;

class ExceptionResponseDto
{
    public $success = false;
    public $errors = array();
    public $type;

    public function __construct($type, array $errors) {
        $this->type = $type;
        $this->errors = $errors;
    }
}