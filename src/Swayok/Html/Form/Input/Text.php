<?php

namespace Swayok\Html\Form\Input;

use Swayok\Html\Form\FormInput;

class Text extends FormInput {

    public function buildOpenTag() {
        $this->type = 'text';
        return parent::buildOpenTag();
    }
}