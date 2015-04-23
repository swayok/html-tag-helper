<?php

namespace App\Utils\Html\Form\Input;

use App\Utils\Html\Form\FormInput;

class Hidden extends FormInput {

    public function buildDlRow() {
        return $this->build();
    }

    public function buildOpenTag() {
        $this->type = 'hidden';
        return parent::buildOpenTag();
    }
}