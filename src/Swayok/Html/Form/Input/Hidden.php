<?php

namespace Swayok\Html\Form\Input;

use Swayok\Html\Form\FormInput;

class Hidden extends FormInput {

    public function buildDlRow() {
        return $this->build();
    }

    public function buildOpenTag() {
        $this->type = 'hidden';
        return parent::buildOpenTag();
    }
}