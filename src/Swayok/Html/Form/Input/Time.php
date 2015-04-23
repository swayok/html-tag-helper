<?php

namespace Swayok\Html\Form\Input;
use Swayok\Html\HtmlTagException;

/**
 * Class FormDate
 * @property string $enabler
 * @property string $field
 *
 * @method string|$this enabler() enabler($value = null)
 * @method string|$this field() field($value = null)
 */
class Time extends TimeBase {

    public $short = true;
    public $tagName = 'input';

    public function buildOpenTag() {
        $this->loadValue();
        $this->processEnabler();
        if ($this->withSeconds) {
            $this->setAttribute('data-show-seconds', '1');
        }
        $backup = $this->attributes;
        // filter attributes to show only required ones
        $this->attributes = array_intersect_key(
            $this->attributes,
            array('id' => '', 'name' => '', 'class' => '', 'type' => '', 'data-enabler' => '', 'value' => '')
        );
        $this->setType('text')->setClass('time-input')->setAttribute('data-type', 'time');
        $this->id; //< make id if not set
        unset($this->attributes['name']); //< needed only for id
        $openTag = parent::buildOpenTag();
        $this->attributes = $backup;
        return $this->getHiddenInput($this->name) . $openTag;
    }
}