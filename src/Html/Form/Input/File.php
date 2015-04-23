<?php

namespace Html\Form\Input;

use Html\Form\FormInput;

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
            : $this->div(preg_replace('%^.*/(.*)$%', '$1', $this->value))->setClass('form-input-current-file-name');
        return $closeTag . $fileName;
    }
}