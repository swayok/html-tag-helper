<?php

namespace Html\Form\Input;

use Html\Form\FormInput;

class Text extends FormInput {

    public function buildOpenTag() {
        $this->type = 'text';
        return parent::buildOpenTag();
    }
}