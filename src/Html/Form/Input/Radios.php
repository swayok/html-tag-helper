<?php

namespace App\Utils\Html\Form\Input;

use App\Utils\Html\Form\FormInput;
use App\Utils\Html\Form\Label;

class Radios extends FormInput {

    public $tagName = 'div';
    public $short = false;
    public $default = false;
    protected $hideAttributes = array('value', 'checked');
    protected $inputs = array();

    public function buildOpenTag() {
        $backup = $this->attributes;
        $this->attributes = array_diff_key($this->attributes, array_flip($this->hideAttributes));
        $this->addClass('radios');
        $ret = parent::buildOpenTag();
        $this->attributes = $backup;
        return $ret;
    }

    public function buildContent() {
        $ret = '';
        $radios = $this->createInputs();
        foreach ($radios as $inputInfo) {
            $ret .= self::div($inputInfo['input']->build() . "\n" . $inputInfo['label']->build())
                ->class('radio-button-container')->build() . "\n";
        }
        return $ret;
    }

    /**
     * @return array
     */
    public function createInputs() {
        $radios = array();
        if ($this->options) {
            $index = 1;
            foreach ($this->options as $value => $label) {
                $id = $this->id . $index;
                $index++;
                $radio = new FormInput($this->form, $this->name, array(
                    'type' => 'radio',
                    'value' => $value,
                    'multiple' => true,
                    'id' => $id
                ));
                $label = new Label(array('content' => $label, 'for' => $id));
                $this->inputs[] = array($radio, $label);
                if (isset($this->attributes['value']) && self::compareValues($this->attributes['value'], $value)) {
                    $radio->checked = true;
                }
                $radios[] = array('label' => $label, 'input' => $radio);
            }
        }
        return $radios;
    }
}