<?php

namespace Html\Form\Input;

use Html\Form\Form;
use Html\Form\FormInput;

class Checkbox extends FormInput {

    public $valueIfChecked = '1';
    public $hiddenInput = true;

    public function __construct(Form $form, $name, $attributes = array()) {
        if (isset($attributes['value'])) {
            $this->valueIfChecked = $attributes['value'];
            unset($attributes['value']);
        }
        if (array_key_exists('hiddenInput', $attributes) && $attributes['hiddenInput'] == false) {
            $this->hiddenInput = false;
        }
        unset($attributes['hiddenInput']);
        parent::__construct($form, $name, $attributes);
    }

    public function buildOpenTag() {
        $attributes['type'] = 'checkbox';
        $this->attributes['value'] = $this->valueIfChecked;
        if (!isset($this->attributes['checked'])) {
            $this->checked = $this->form->getInputValue($this->name) ? true : false;
        }
        if ($this->hiddenInput) {
            $hiddenInput = new Hidden($this->form, $this->name, array('value' => '0', 'id' => $this->id . '_hidden'));
        } else {
            $hiddenInput = '';
        }
        return $hiddenInput . parent::buildOpenTag();
    }
}