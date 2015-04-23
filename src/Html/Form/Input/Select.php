<?php

namespace App\Utils\Html\Form\Input;

use App\Utils\Html\Form\FormInput;

class Select extends FormInput {

    public $tagName = 'select';
    public $short = false;
    protected $excludeAttributes = array('value');

    public function buildContent() {
        $ret = '';
        if (empty($this->attributes['required'])) {
            $ret = $this->option(array('value' => ''))->content('')->build() . "\n";
        }
        if (!empty($this->options)) {
            if (is_array($this->options)) {
                foreach ($this->options as $value => $label) {
                    $option = $this->option(array('value' => $value, 'content' => $label));
                    if ($value === 'NULL' && !isset($this->attributes['value'])) {
                        $option->selected = true;
                    } else if (isset($this->attributes['value']) && self::compareValues($this->attributes['value'], $value)) {
                        $option->selected = true;
                    }
                    $ret .= $option->build() . "\n";
                }
            } else {
                if (isset($this->attributes['value'])) {
                    $this->options = preg_replace('%(value=(?:\'|")' . preg_quote($this->attributes['value'], '%') . '(?:\'|"))%is', '$1 selected', $this->options);
                }
                $ret .= $this->options;
            }
        }
        return $ret;
    }
}