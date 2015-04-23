<?php

namespace App\Utils\Html\Form\Input;

use App\Utils\Html\Form\FormInput;

class Text extends FormInput {

    public function buildOpenTag() {
        $this->type = 'text';
        return parent::buildOpenTag();
    }
}