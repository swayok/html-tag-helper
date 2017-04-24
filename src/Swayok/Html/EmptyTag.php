<?php

namespace Swayok\Html;

class EmptyTag extends Tag {

    public function __construct() {
    }

    public function build() {
        return '';
    }
}