<?php

namespace Html\Form\Input;

use Html\Form\FormInput;

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