<?php

namespace Html\Form\Input;
use Html\HtmlTagException;

/**
 * Class FormDate
 * @property string $enabler
 * @property string $field
 *
 * @method string|$this enabler() enabler($value = null)
 * @method string|$this field() field($value = null)
 */
class TimeRange extends TimeBase {

    public function buildOpenTag() {
        if (empty($this->attributes['field1']) && empty($this->attributes['field2'])) {
            throw new HtmlTagException('FormTimeRange input requires attributes: [field1] and [field2]');
        } else if (empty($this->attributes['field1'])) {
            $this->attributes['field1'] = $this->attributes['name'];
        } else if (empty($this->attributes['field2'])) {
            $this->attributes['field2'] = $this->attributes['name'];
        }
        $this->processEnabler();
        $backup = $this->attributes;
        // filter attributes to show only required ones
        $this->attributes = array_intersect_key(
            $this->attributes,
            array('id' => '', 'name' => '', 'class' => '', 'data-enabler' => '')
        );
        $this->addClass('time-range-input-container')->setAttribute('data-type', 'time-range');
        $this->id; //< make id if not set
        unset($this->attributes['name']); //< needed only for id
        $openTag = parent::buildOpenTag();
        $this->attributes = $backup;
        return $this->getHiddenInput($this->attributes['field1']) . $this->getHiddenInput($this->attributes['field2']) . $openTag;
    }

    /**
     * process next attributes:
     * - field1
     * - field2
     * - name
     * - value
     * - field1_label
     * - field2_label
     */
    public function buildContent() {
        throw new HtmlTagException('not implemented');
        // backup
        /*$backup = $this->attributes;
        // 1st picker
        $settings = array(
            'field1' => $this->attributes['field1'],
            'field2' => $this->attributes['field2'],
        );
        // labels
        if (!empty($this->attributes['field1_label'])) {
            $settings['label1'] = $this->attributes['field1_label'];
        }
        if (!empty($this->attributes['field2_label'])) {
            $settings['label2'] = $this->attributes['field2_label'];
        }
        // value 1
        $this->attributes['value'] = $this->form->value($settings['field1']);
        $this->setValue();
        $settings['value1'] = $this->attributes['value'];
        // value 2
        $this->attributes['value'] = $this->form->value($settings['field2']);
        $this->setValue();
        $settings['value2'] = $this->attributes['value'];
        // assemble
        $range = Renderer::getCurrent()->element('time_range', array('settings' => $settings));
        // restore
        $this->attributes = $backup;
        return $range;*/
    }
}