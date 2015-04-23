<?php

namespace Html\Form\Input;

abstract class TimeBase extends DateTimeBase {

    public $dateFormat = 'H:i';
    public $emptyValue = '00:00';

    protected function loadValue() {
        // catch invalid value
        if (!empty($this->attributes['value']) && !$this->isDate($this->attributes['value'])) {
            unset($this->value);
        }
        // format value if set
        if (!empty($this->attributes['value'])) {
            $this->value = $this->toFormattedDate($this->value);
        }
        // format default value if set and use it as value if value in sot set
        if (!empty($this->default)) {
            if ($this->isDate($this->default)) {
                // value not set but default value provided
                $this->attributes['default'] = $this->default;
                if (empty($this->attributes['value'])) {
                    $this->value = $this->toFormattedDate($this->attributes['default']);
                }
            } else {
                unset($this->default);
            }
        }
        if (empty($this->attributes['value'])) {
            $this->attributes['value'] = $this->emptyValue;
        }
    }
}