<?php

namespace Swayok\Html\Form\Input;

use Swayok\Html\Form\FormInput;

abstract class DateTimeBase extends FormInput {

    public $short = false;
    public $tagName = 'div';
    public $dateFormat = 'Y-m-d';
    public $timeFormat = 'H:i';
    public $timeFormatFull = 'H:i:s';
    public $valueFormat = 'auto';
    protected $withTime = false;
    protected $withSeconds = false;

    public $dateClass = 'date';
    public $dateTimeClass = 'datetime';

    /**
     * process next attributes:
     * - date_format
     * - value
     * - default
     * - min_date
     * - max_date
     * - with_time
     */
    protected function processDateAttributes() {
        // test if time part required
        if (!empty($this->attributes['with_time'])) {
            $this->withTime = true;
        }
        if (!empty($this->attributes['with_seconds'])) {
            $this->withSeconds = true;
            $this->timeFormat = $this->timeFormatFull;
        }
        // get date format
        if (!empty($this->attributes['date_format'])) {
            $this->dateFormat = $this->attributes['date_format'];
        }
        // get time format
        if (!empty($this->attributes['time_format'])) {
            $this->timeFormat = $this->attributes['time_format'];
        }
        // get value format
        if (!empty($this->attributes['value_format'])) {
            $this->valueFormat = $this->attributes['value_format'];
        } else if ($this->withTime) {
            $this->valueFormat = $this->dateFormat . ' ' . $this->timeFormat;
        } else {
            $this->valueFormat = $this->dateFormat;
        }
        $valueTs = 0;
        // catch invalid value
        if (!empty($this->attributes['value']) && !$this->isDate($this->attributes['value'])) {
            unset($this->value);
        }
        // format value if set
        if (!empty($this->attributes['value'])) {
            $this->value = $this->toFormattedDate($this->value);
            $valueTs = strtotime($this->attributes['value']);
        }
        // format default value if set and use it as value if value in sot set
        if (!empty($this->default)) {
            if ($this->isDate($this->default)) {
                // value not set but default value provided
                $this->attributes['default'] = $this->default;
                if (empty($this->attributes['value'])) {
                    $this->value = $this->toFormattedDate($this->attributes['default']);
                    $valueTs = strtotime($this->attributes['value']);
                }
            } else {
                unset($this->default);
            }
        }
        // set data-min attribute and normalize value
        if (!empty($this->attributes['max_date']) && $this->isDate($this->attributes['max_date'])) {
            $maxDate = $this->toFormattedDate($this->attributes['max_date']);
            $this->setAttribute('data-max', $maxDate);
            if (empty($this->attributes['value']) || !$valueTs || $valueTs > strtotime($maxDate)) {
                $this->value($maxDate);
            }
        }
        // set data-min attribute and normalize value
        if (!empty($this->attributes['min_date'])) {
            $minDate = $this->toFormattedDate($this->attributes['min_date']);
            $this->setAttribute('data-min', $minDate);
            if (empty($this->attributes['value']) || $valueTs < strtotime($minDate)) {
                $this->value($minDate);
            }
        }
        // set special values
        if (empty($this->attributes['value'])) {
            $this->attributes['value'] = '';
        }
        $this->attributes['value_date'] = date($this->dateFormat, strtotime($this->attributes['value']));
        $this->attributes['value_time'] = date($this->timeFormat, strtotime($this->attributes['value']));
    }

    protected function processEnabler() {
        if (!empty($this->attributes['enabler'])) {
            $this->setAttribute('data-enabler', $this->attributes['enabler']);
        }
    }

    public function isDate($value) {
        return preg_match('%^\d{6,}$%is', $value) || strtotime($value) > 0;
    }

    public function toFormattedDate($value) {
        if (!preg_match('%^\d{6,}$%is', $value)) {
            $value = strtotime($value);
        }
        return date($this->valueFormat, $value);
    }

    protected function getHiddenInput($name) {
        return self::create(array('type' => 'hidden', 'name' => $name, 'value' => $this->value), 'input');
    }
}