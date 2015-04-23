<?php

namespace App\Utils\Html\Form;

use App\Utils\Html\HtmlTagException;
use App\Utils\Html\Security;
use App\Utils\Html\Tag;
use PeskyORM\DbObject;

class Form extends Tag {
    public $tagName = 'form';

    const TYPE_PLAIN = 'text/plain';
    const TYPE_URL_ENCODED = 'application/x-www-form-urlencoded';
    const TYPE_FILE = 'multipart/form-data';

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    protected $attributesMap = array(
        'acceptcharset' => 'accept-charset',
    );

    /** @var FormInput[] */
    protected $_inputs = array();
    /** @var FormInput */
    protected $submitButton = '';
    /** @var array */
    protected $values = array();
    /** @var array */
    protected $inputErrors = array();
    /** @var bool */
    public $secure = true;

    /**
     * Create new Form
     * @param string $name
     * @param array|DbObject|null $values
     * @param string $type - type of form (enctype), one of Form::TYPE_* (default: Form::TYPE_URL_ENCODED)
     * @param bool $secure - true: enables form security fields (see Security clas)
     * @return Form
     */
    static public function create($name, $values = array(), $type = self::TYPE_URL_ENCODED, $secure = true) {
        $form = new Form($name, $values, $type, $secure);
        return $form;
    }

    /**
     * @param string $name
     * @param array|DbObject|null $values
     * @param string $type
     * @param bool $secure
     * @throws HtmlTagException
     */
    public function __construct($name, $values = array(), $type = self::TYPE_URL_ENCODED, $secure = true) {
        $this->name = $name;
        $this->secure = $secure;
        if (!empty($type) && $type !== self::TYPE_URL_ENCODED) {
            $this->encType = $type;
        }
        if ($values instanceof DbObject) {
            $this->values = $values->toStrictArray();
        } else if (is_array($values)) {
            $this->values = $values;
        } else {
            throw new HtmlTagException('Invalid form values passed');
        }
    }

    /**
     * Get or set all values
     * @param null|array $values
     * @return Form|array
     */
    public function values($values = null) {
        if (!is_array($values)) {
            return $this->values;
        } else {
            $this->values = $values;
            foreach ($this->_inputs as $name => $object) {
                $this->_inputs[$name]->value = $this->value($name);
            }
            return $this;
        }
    }

    /**
     * Get or set single value
     * @param string $name
     * @param null|mixed $value
     * @param boolean $updateInputValue - true: will trigger input value update
     * @return Form|null
     */
    public function value($name, $value = null, $updateInputValue = true) {
        if ($value === null) {
            return isset($this->values[$name]) ? $this->values[$name] : null;
        } else {
            $this->values[$name] = $value;
            if ($updateInputValue && isset($this->_inputs[$name])) {
                $this->_inputs[$name]->value = $value;
            }
            return $this;
        }
    }

    /**
     * Get values of all hidden inputs
     * @return array
     */
    public function getHiddenValues() {
        $ret = array();
        foreach ($this->_inputs as $name => $object) {
            if ($name !== Security::TOKEN && $object->type == 'hidden' && $object->security) {
                $ret[$name] = $object->value();
            }
        }
        return $ret;
    }

    /**
     * Set input errors
     * @param array $errors
     * @return Form
     */
    public function errors($errors = array()) {
        $this->inputErrors = $errors;
        return $this;
    }

    /**
     * Get error by input name
     * @param $inputName
     * @return string - empty string if no error
     */
    public function getError($inputName) {
        return empty($this->inputErrors[$inputName]) ? '' : $this->inputErrors[$inputName];
    }

    /**
     * create many inputs
     * @param array $inputs
     * @return Form
     */
    public function inputs($inputs) {
        foreach ($inputs as $name => $attributes) {
            if (!isset($attributes['type'])) {
                $attributes['type'] = 'text';
            }
            $this->input($name, $attributes);
        }
        return $this;
    }

    /**
     * Create or get input
     * @param string $name
     * @param array|null $attributes
     * @return $this|string
     * @throws HtmlTagException
     */
    public function input($name, $attributes = null) {
        if (!is_array($attributes)) {
            if (isset($this->_inputs[$name])) {
                return $this->_inputs[$name];
            } else {
                $attributes = array();
            }
        }
        if (!isset($this->_inputs[$name])) {
            if (!isset($attributes['type'])) {
                $attributes['type'] = 'text';
            }
            switch (strtolower($attributes['type'])) {
                case 'textarea':
                    $this->_inputs[$name] = new FormTextArea($this, $name, $attributes);
                    break;
                case 'select':
                    $this->_inputs[$name] = new FormSelect($this, $name, $attributes);
                    break;
                case 'checkbox':
                    $this->_inputs[$name] = new FormCheckbox($this, $name, $attributes);
                    break;
                case 'radios':
                    $this->_inputs[$name] = new FormRadios($this, $name, $attributes);
                    break;
                case 'trigger':
                case 'triggers':
                    $this->_inputs[$name] = new FormTriggers($this, $name, $attributes);
                    break;
                case 'hidden':
                    $this->_inputs[$name] = new FormHidden($this, $name, $attributes);
                    break;
                case 'captcha':
                    $this->_inputs[$name] = new Captcha($this, $name, $attributes);
                    break;
                case 'image':
                    $this->_inputs[$name] = new FormImage($this, $name, $attributes);
                    $this->encType = self::TYPE_FILE;
                    break;
                case 'file':
                    $this->_inputs[$name] = new FormFile($this, $name, $attributes);
                    $this->encType = self::TYPE_FILE;
                    break;
                case 'content':
                    $this->_inputs[$name] = new FormContent($this, $name, $attributes);
                    break;
                case 'date':
                    $this->_inputs[$name] = new FormDate($this, $name, $attributes);
                    break;
                case 'daterange':
                    $this->_inputs[$name] = new FormDateRange($this, $name, $attributes);
                    break;
                case 'time':
                    $this->_inputs[$name] = new FormTime($this, $name, $attributes);
                    break;
                case 'timerange':
                    $this->_inputs[$name] = new FormTimeRange($this, $name, $attributes);
                    break;
                case 'datetime':
                    $attributes['with_time'] = true;
                    $this->_inputs[$name] = new FormDate($this, $name, $attributes);
                    break;
                case 'datetimerange':
                    $attributes['with_time'] = true;
                    $this->_inputs[$name] = new FormDateRange($this, $name, $attributes);
                    break;
                default:
                    $this->_inputs[$name] = new FormInput($this, $name, $attributes);
            }
        } else {
            throw new HtmlTagException("Duplicate input [$name]");
        }
        if ($this->value($name) !== null && !isset($this->_inputs[$name]->value)) {
            if (get_class($this->_inputs[$name]) == 'FormImage') {
                $values = $this->value($name);
                $paths = $this->value($name . '_path');
                if (!empty($paths) && is_array($paths) && !empty($values) && is_array($values)) {
                    foreach ($values as $version => $url) {
                        $values[$version . '_path'] = $paths[$version];
                    }
                }
                $this->_inputs[$name]->value = $values;
            } else {
                $this->_inputs[$name]->value = $this->value($name);
            }
        }

        return $this->_inputs[$name];
    }

    /**
     * Add input to form
     * @param string $name
     * @param string $type
     * @return Form
     */
    public function addInput($name, $type = 'text') {
        $this->input($name, $type);
        return $this;
    }

    /**
     * Add submit button to form
     * @param array $attributes
     * @return Form
     */
    public function submit($attributes = null) {
        if (!is_array($attributes)) {
            return $this->submitButton;
        } else {
            $attributes['type'] = 'submit';
            $this->submitButton = new FormInput($this, '', $attributes);
            return $this;
        }
    }

    /**
     * inputs can be called like 'iEmail', 'iSubject', etc..
     * @param string $name
     * @param array $args
     * @return $this|mixed
     */
    public function __call($name, $args) {
        if ($name[0] == 'i' && isset($this->_inputs[substr($name, 1)])) {
            return $this->_inputs[substr($name, 1)];
        } else {
            return parent::__call($name, $args);
        }
    }

    public function build($useDl = true) {
        return $this->buildOpenTag() . $this->buildContent($useDl) . $this->buildCloseTag();
    }

    public function buildOpenTag() {
        if (empty($this->attributes['method'])) {
            $this->attributes['method'] = 'get';
        }
        return parent::buildOpenTag();
    }

    public function buildCloseTag() {
        return $this->buildSecurity() . parent::buildCloseTag();
    }

    /**
     * @param bool $enable
     * @return Form
     */
    public function secure($enable = true) {
        $this->secure = !!$enable;
        return $this;
    }

    public function buildSecurity() {
        if ($this->secure) {
            $formName = new FormHidden($this, Security::FORM_NAME, array('value' => $this->name));
            $token = new SecurityTokenInput($this, Security::TOKEN);
            $timestamp = new FormHidden($this, Security::TIMESTAMP, array('value' => Security::getTimestamp()));
            return $token . $timestamp . $formName;
        } else {
            return '';
        }
    }

    public function buildContent($useDl = true) {
        $ret = '';
        foreach ($this->_inputs as $name => $input) {
            if (!in_array($name, array(Security::TIMESTAMP, Security::TOKEN))) {
                $ret .= $useDl ? $input->buildDlRow() : $input->build();
            }
        }
        if ($useDl) {
            $ret = $this->dl()->content($ret)->build();
        }
        $ret .= $this->buildSubmit();
        return $ret;
    }

    public function buildSubmit() {
        if (!empty($this->submitButton)) {
            return $this->div(array('class' => 'submit'))->content($this->submitButton->build())->build();
        }
        return '';
    }

}