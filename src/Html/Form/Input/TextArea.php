<?php

namespace App\Utils\Html\Form\Input;

use App\Utils\Html\Form\FormInput;

class TextArea extends FormInput {

    public $tagName = 'textarea';
    public $short = false;
    protected $excludeAttributes = array('value');

    public function buildContent() {
        return $this->value;
    }
}