<?php

namespace Html\Form;

/**
 * Used to place custom content into form
 */
class FormCustomContent extends FormInput {
    public $tagName = 'div';
    public $short = false;

    public function buildOpenTag() {
        unset($this->attributes['name']);
        unset($this->attributes['value']);
        unset($this->attributes['type']);
        return parent::buildOpenTag();
    }
}