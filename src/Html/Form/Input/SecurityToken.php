<?php

namespace App\Utils\Html\Form\Input;

use App\Utils\Html\Security;

class SecurityToken extends Hidden {

    public function buildOpenTag() {
        $this->attributes['value'] = Security::generateToken($this->form->name, $this->form->getHiddenValues(), $this->form->action);
        return parent::buildOpenTag();
    }
}