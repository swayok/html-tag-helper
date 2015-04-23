<?php

namespace App\Utils\Html\Form\Input;

use App\Utils\Html\Form\FormInput;
use App\Utils\Html\Tag;

class File extends FormInput {

    protected $excludeAttributes = array('value');

    public function buildOpenTag() {
        $this->type = 'file';
        return parent::buildOpenTag();
    }

    public function buildCloseTag() {
        $closeTag = parent::buildCloseTag();
        $fileName = empty($this->value)
            ? ''
            : Tag::div(preg_replace('%^.*/(.*)$%', '$1', $this->value))->class('form-input-current-file-name');
        return $closeTag . $fileName;
    }
}