<?php

namespace App\Utils\Html\Form\Input;

use App\Utils\Html\Form\FormInput;
use App\Utils\Html\Form\Label;
use App\Utils\Html\Tag;

class Triggers extends FormInput {

    public $tagName = 'div';
    public $short = false;
    public $default = false;
    protected $hideAttributes = array('value', 'checked', 'multiple', 'type', 'name', 'autocomplete');
    protected $passAttributes = array('autocomplete');
    public $multiple = false;
    protected $triggers = array();

    public function buildOpenTag() {
        $backup = $this->attributes;
        $this->multiple = !empty($this->attributes['multiple']);
        $this->id; //< build id
        $this->attributes = array_diff_key($this->attributes, array_flip($this->hideAttributes));
        $this->addClass('triggers')->addClass($this->multiple ? 'multiple' : 'single');
        $ret = parent::buildOpenTag();
        $this->attributes = $backup;
        return $ret;
    }

    public function buildContent() {
        $ret = '';
        $triggers = $this->createInputs();
        foreach ($triggers as $inputInfo) {
            $ret .= Tag::div($inputInfo['input']->build() . "\n" . $inputInfo['label']->build())
                ->class('radio-button-container')->build();
        }
        return $ret;
    }

    /**
     * @return array
     */
    public function createInputs() {
        $triggers = array();
        if ($this->options) {
            $index = 1;
            $defaultAttributes = array_intersect_key($this->attributes, array_flip($this->passAttributes));
            foreach ($this->options as $value => $label) {
                $id = $this->id . $index;
                $index++;
                $localAttributes = array_merge($defaultAttributes, array(
                    'type' => $this->multiple ? 'checkbox' : 'radio',
                    'value' => $value,
                    'label' => $label,
                    'class' => 'trigger-button',
                    'multiple' => $this->multiple,
                    'id' => $id
                ));
                $trigger = new FormInput($this->form, $this->name, $localAttributes);
                $label = new Label(array('content' => $label, 'for' => $id));
                $this->triggers[] = array($trigger, $label);
                if (isset($this->attributes['value']) && self::compareValues($this->attributes['value'], $value)) {
                    $trigger->checked = true;
                }
                $triggers[] = array('label' => $label, 'input' => $trigger);
            }
        }
        return $triggers;
    }
}