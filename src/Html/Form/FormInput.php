<?php

namespace App\Utils\Html\Form;

use App\Utils\Html\Tag;

class FormInput extends Tag {
    public $tagName = 'input';
    public $short = true;
    /** @var Form */
    public $form = false;
    /** @var bool|string */
    public $label = false;
    /** @var bool|array */
    public $options = false;
    /** @var null|string */
    public $default = null;
    /** @var null|string */
    public $help = null;
    /** @var null|string */
    public $tooltip = null;
    /** @var bool */
    public $security = true;
    /** @var bool|array ('file' => 'string.tpl', 'type' => 'view|element', 'data' => array()) */
    protected $ddContentTemplate = false;

    /**
     * @param Form $form
     * @param string $name
     * @param array $attributes
     */
    public function __construct(Form $form, $name, $attributes = array()) {
        $this->form = $form;
        if (!is_int($name) && !isset($attributes['name'])) {
            $attributes['name'] = $name;
        }
        if (isset($attributes['label'])) {
            $this->label = $attributes['label'];
            unset($attributes['label']);
        }
        if (isset($attributes['options'])) {
            $this->options = $attributes['options'];
            unset($attributes['options']);
        }
        if (isset($attributes['help'])) {
            $this->help = $attributes['help'];
            unset($attributes['help']);
        }
        if (isset($attributes['tooltip'])) {
            $this->tooltip = $attributes['tooltip'];
            unset($attributes['tooltip']);
        }
        if (array_key_exists('security', $attributes)) {
            $this->security = !empty($attributes['security']);
            unset($attributes['security']);
        }
        $this->default = isset($attributes['default']) ? $attributes['default'] : null;
        unset($attributes['default']);
        parent::__construct($attributes);
        if (!isset($this->default) && isset($this->value)) {
            $this->default = isset($default) ? $default : $this->value;
        }
    }

    public function label($value = null) {
        if ($value === null) {
            return $this->label;
        } else {
            $this->label = empty($value) ? '' : $value;
            return $this;
        }
    }

    public function value($value = null, $replaceExisting = true) {
        if ($value === null) {
            return $this->value;
        } else {
            if ($replaceExisting || !isset($this->attributes['value'])) {
                $this->value = $value;
            }
            return $this;
        }
    }

    /**
     * Compare 2 values strictly but with converting of $targetValue to data type of $srcValue
     * @param mixed $srcValue
     * @param mixed $targetValue
     * @return bool
     */
    static protected function compareValues($srcValue, $targetValue) {
        if (is_array($srcValue) && !is_array($targetValue)) {
            foreach ($srcValue as $value) {
                if (self::compareValues($value, $targetValue)) {
                    return true;
                }
            }
        } else if ($srcValue === $targetValue) {
            return true;
        } else if (is_bool($targetValue) && is_numeric($srcValue) && in_array($srcValue, array(0, 1, '0', '1'))) {
            return ($srcValue ? true : false) === $targetValue;
        } else if (is_bool($srcValue) && is_numeric($targetValue) && in_array($targetValue, array(0, 1, '0', '1'))) {
            return ($targetValue ? true : false) === $srcValue;
        } else if (is_string($srcValue)) {
            return $srcValue  === '' . $targetValue;
        } else if ((is_bool($srcValue) || is_int($srcValue)) && is_string($targetValue) && is_numeric($targetValue)) {
            return intval($srcValue) === intval($targetValue);
        } else if (is_float($srcValue) && is_numeric($srcValue)) {
            return floatval($srcValue) === floatval($targetValue);
        }
        return false;
    }

    public function __set($attribute, $value) {
        switch (strtolower($attribute)) {
            case 'value':
                if ($value === null && isset($this->default)) {
                    $this->attributes['value'] = $this->default;
                } else {
                    $this->attributes['value'] = $value;
                }
                $this->form->value($this->name, $this->attributes['value'], false);
                break;
            default:
                parent::__set($attribute, $value);
        }
    }

    public function __get($attribute) {
        switch (strtolower($attribute)) {
            case 'value':
                $this->attributes['value'] = $this->form->value($this->name);
                if ($this->attributes['value'] === null && isset($this->default)) {
                    $this->attributes['value'] = $this->default;
                }
                return $this->attributes['value'];
            case 'id':
                $this->attributes['id'] = $this->buildId();
                return $this->attributes['id'];
            default:
                return parent::__get($attribute);
        }
    }

    public function buildLabel() {
        $label = '';
        if (!empty($this->label)) {
            $label = new FormLabel(array('for' => $this->buildId()));
            $label = $label->content($this->label)->build();
        }
        return $label;
    }

    public function buildId() {
        if (!array_key_exists('id', $this->attributes) || $this->attributes['id'] === null) {
            return !$this->name
                ? ''
                : ($this->form->id ? $this->form->id : $this->form->name . '-form') . '-' . str_replace('_', '-', $this->name);
        } else if ($this->attributes['id'] !== false) {
            return $this->attributes['id'];
        } else {
            return '';
        }
    }

    public function buildOpenTag() {
        $this->id; //< will build id if it is not set in $this->attributes
        $error = $this->form->getError($this->name);
        if (!empty($error)) {
            $this->addClass('error');
        }
        return parent::buildOpenTag();
    }

    public function buildCloseTag() {
        $error = $this->form->getError($this->name);
        if (!empty($error)) {
            $error = $this->div()->class('error-text')->content($error);
        }
        return parent::buildCloseTag() . $error;
    }

    public function buildHelp() {
        if (!empty($this->help)) {
            return $this->div()->class('input-help')->content($this->help);
        }
        return '';
    }

    public function buildTooltip($withIcon = true, $text = null) {
        if (!empty($this->tooltip)) {
            if (empty($text)) {
                $text = $this->tooltip;
            }
            return ($withIcon ? Tag::div()->class('input-tooltip-icon') : '')
                . $this->div()->class('input-tooltip')->content($text);
        }
        return '';
    }

    public function buildDlRow() {
        return $this->buildDt() . ' ' . $this->buildDd() . "\n";
    }

    public function buildDt() {
        return $this->dt()->content($this->buildLabel())->build();
    }

    public function getDdElements() {
        return array('input' => $this->build(), 'tooltip' => $this->buildTooltip(), 'help' => $this->buildHelp());
    }

    /*public function buildDd() {
        if (empty($this->ddContentTemplate)) {
            $ddElements = $this->getDdElements();
            $ddContent = $ddElements['input'] . $ddElements['tooltip'] . $ddElements['help'];
        } else {
            $tplData = $this->ddContentTemplate['data'];
            $tplData['input'] = $this;
            $tplData['form'] = $this->form;
            switch ($this->ddContentTemplate['type']) {
                case 'element':
                    $ddContent = Renderer::getCurrent()->element($this->ddContentTemplate['file'], $tplData);
                    break;
                case 'view':
                    $ddContent = Renderer::getCurrent()->renderSilent(false, $this->ddContentTemplate['file'], false, false, $tplData);
                    break;
                default:
                    throw new ViewException('Unknown template type [' . $this->ddContentTemplate['type'] . '] detected in FormInputBase:buildDd()');
            }
        }
        return $this->dd()->content($ddContent);
    }*/

    public function buildDd() {
        $ddElements = $this->getDdElements();
        $ddContent = $ddElements['input'] . $ddElements['tooltip'] . $ddElements['help'];
        return $this->dd()->content($ddContent);
    }

    public function setDdContentTemplate($tplFileName, $tplType, $tplData = array()) {
        $this->ddContentTemplate = array(
            'file' => $tplFileName,
            'type' => empty($tplType) || !in_array($tplType, array('view', 'element')) ? 'view' : strtolower($tplType),
            'data' => is_array($tplData) ? $tplData : array()
        );
    }

    public function removeDdContentTemplate() {
        $this->ddContentTemplate = false;
    }
}