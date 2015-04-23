<?php

namespace Swayok\Html\Form\Input;

use Swayok\Html\Form\FormInput;

class Captcha extends FormInput {

    public function buildOpenTag() {
        return '';
    }

    public function buildCloseTag() {
        return '';
    }

    public function buildContent() {
        return $this->content;
    }
}