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
class DateRange extends DateTimeBase {

    public $short = false;
    public $tagName = 'div';
    public $dateFormat = 'Y-m-d';

    public $dateClass = 'date-range-input-container';
    public $dateTimeClass = 'datetime-range-input-container';

    /**
     * process next attributes:
     * - field1
     * - field2
     * - name
     */
    public function buildOpenTag() {
        if (empty($this->attributes['field1']) && empty($this->attributes['field2'])) {
            throw new HtmlTagException('FormDateRange input requires attributes: [field1] and [field2]');
        } else if (empty($this->attributes['field1'])) {
            $this->attributes['field1'] = $this->attributes['name'];
        } else if (empty($this->attributes['field2'])) {
            $this->attributes['field2'] = $this->attributes['name'];
        }
        $this->processDateAttributes();
        $this->processEnabler();
        $backup = $this->attributes;
        // filter attributes to show only required ones
        $this->attributes = array_intersect_key(
            $this->attributes,
            array('id' => '', 'name' => '', 'class' => '', 'data-min' => '', 'data-max' => '', 'data-enabler' => '')
        );
        $this->addClass($this->withTime ? $this->dateTimeClass : $this->dateClass)
            ->setAttribute('data-type', $this->withTime ? 'datetime-range' : 'date-range');
        $this->id; //< make id if not set
        unset($this->attributes['name']); //< needed only for id
        $openTag = parent::buildOpenTag();
        $this->attributes = $backup;
        return $openTag . $this->getHiddenInput($this->attributes['field1']) . $this->getHiddenInput($this->attributes['field2']);
    }

    /**
     * process next attributes:
     * - field1
     * - field2
     * - name
     * - value
     * - field1_label
     * - field2_label
     * todo: -with_time
     */
    public function buildContent() {
        throw new HtmlTagException('not implemented');
        // backup
        /*$backup = $this->attributes;
        // 1st picker
        $this->attributes['value'] = $this->form->value($this->attributes['field1']);
        $this->attributes['name'] = $this->attributes['field1'];
        unset($this->attributes['label']);
        $this->processDateAttributes();
        if (!empty($this->attributes['field1_label'])) {
            $this->attributes['label'] = $this->attributes['field1_label'];
        }
        $this->attributes['class'] = 'starting-date';
        $picker1 = Renderer::getCurrent()->element('datepicker', array('settings' => $this->attributes));
        // 2nd picker
        $this->attributes['value'] = $this->form->value($this->attributes['field2']);
        $this->attributes['name'] = $this->attributes['field2'];
        $this->processDateAttributes();
        unset($this->attributes['label']);
        if (!empty($this->attributes['field2_label'])) {
            $this->attributes['label'] = $this->attributes['field2_label'];
        }
        $this->attributes['class'] = 'ending-date';
        $picker2 = Renderer::getCurrent()->element('datepicker', array('settings' => $this->attributes));
        // restore
        $this->attributes = $backup;
        return $picker1 . $picker2;*/
    }
}