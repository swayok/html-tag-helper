<?php

namespace App\Utils\Html\Form\Input;
use App\Utils\Html\HtmlTagException;

/**
 * Class FormDate
 * @property string $enabler
 * @property string $field
 *
 * @method string|$this enabler() enabler($value = null)
 * @method string|$this field() field($value = null)
 */
class Date extends DateTimeBase {

    public $dateClass = 'date-input-container';
    public $dateTimeClass = 'datetime-input-container';

    public function buildOpenTag() {
        $this->processDateAttributes();
        $this->processEnabler();
        $backup = $this->attributes;
        // filter attributes to show only required ones
        $this->attributes = array_intersect_key(
            $this->attributes,
            array('id' => '', 'name' => '', 'class' => '', 'data-min' => '', 'data-max' => '', 'data-enabler' => '')
        );
        $this->addClass($this->withTime ? $this->dateTimeClass : $this->dateClass)
            ->data('type', $this->withTime ? 'datetime' : 'date');
        $this->id; //< make id if not set
        unset($this->attributes['name']); //< needed only for id
        $openTag = parent::buildOpenTag();
        $this->attributes = $backup;
        return $this->getHiddenInput($this->name) . $openTag;
    }

    public function buildContent() {
        throw new HtmlTagException('not implemented');
//        return Renderer::getCurrent()->element('datepicker', array('settings' => $this->attributes));
    }
}