<?php

namespace Html\Form;

use Html\Form\Input\Captcha;
use Html\Form\Input\Checkbox;
use Html\Form\Input\Date;
use Html\Form\Input\DateRange;
use Html\Form\Input\File;
use Html\Form\Input\Hidden;
use Html\Form\Input\Image;
use Html\Form\Input\Radios;
use Html\Form\Input\SecurityToken;
use Html\Form\Input\Select;
use Html\Form\Input\TextArea;
use Html\Form\Input\Time;
use Html\Form\Input\TimeRange;
use Html\Form\Input\Triggers;
use Html\HtmlTagException;
use Html\Security;
use Html\Tag;
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
    protected $security = true;

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
     * @param bool $security
     * @throws HtmlTagException
     */
    public function __construct($name, $values = array(), $type = self::TYPE_URL_ENCODED, $security = true) {
        $this->name = $name;
        $this->enableSecurity($security);
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
                $this->_inputs[$name]->setValue($this->getInputValue($name));
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
    public function getInputValue($name, $value = null, $updateInputValue = true) {
        if ($value === null) {
            return isset($this->values[$name]) ? $this->values[$name] : null;
        } else {
            $this->values[$name] = $value;
            if ($updateInputValue && isset($this->_inputs[$name])) {
                $this->_inputs[$name]->setValue($value);
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
    public function setErrors($errors = array()) {
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
    public function setInputs($inputs) {
        foreach ($inputs as $name => $attributes) {
            if (!isset($attributes['type'])) {
                $attributes['type'] = 'text';
            }
            $this->addInput($name, $attributes);
        }
        return $this;
    }

    /**
     * Create or get input
     * @param string $name
     * @return FormInput
     * @throws HtmlTagException
     */
    public function getInput($name) {
        if (!isset($this->_inputs[$name])) {
            throw new HtmlTagException("Form input with [$name] not exists");
        }
        return $this->_inputs[$name];
    }

    /**
     * Add input to form
     * @param string $name
     * @param array $attributes
     * @return Form
     * @throws HtmlTagException
     */
    public function addInput($name, array $attributes = array()) {
        if (isset($this->_inputs[$name])) {
            throw new HtmlTagException("Duplicate input [$name]");
        }
        $attributes['type'] = isset($attributes['type']) ? strtolower($attributes['type']) : 'text';
        switch ($attributes['type']) {
            case 'textarea':
                $this->_inputs[$name] = new TextArea($this, $name, $attributes);
                break;
            case 'select':
                $this->_inputs[$name] = new Select($this, $name, $attributes);
                break;
            case 'checkbox':
                $this->_inputs[$name] = new Checkbox($this, $name, $attributes);
                break;
            case 'radios':
                $this->_inputs[$name] = new Radios($this, $name, $attributes);
                break;
            case 'trigger':
            case 'triggers':
                $this->_inputs[$name] = new Triggers($this, $name, $attributes);
                break;
            case 'hidden':
                $this->_inputs[$name] = new Hidden($this, $name, $attributes);
                break;
            case 'captcha':
                $this->_inputs[$name] = new Captcha($this, $name, $attributes);
                break;
            case 'image':
                $this->_inputs[$name] = new Image($this, $name, $attributes);
                $this->encType = self::TYPE_FILE;
                break;
            case 'file':
                $this->_inputs[$name] = new File($this, $name, $attributes);
                $this->encType = self::TYPE_FILE;
                break;
            case 'content':
                $this->_inputs[$name] = new FormCustomContent($this, $name, $attributes);
                break;
            case 'date':
                $this->_inputs[$name] = new Date($this, $name, $attributes);
                break;
            case 'daterange':
                $this->_inputs[$name] = new DateRange($this, $name, $attributes);
                break;
            case 'time':
                $this->_inputs[$name] = new Time($this, $name, $attributes);
                break;
            case 'timerange':
                $this->_inputs[$name] = new TimeRange($this, $name, $attributes);
                break;
            case 'datetime':
                $attributes['with_time'] = true;
                $this->_inputs[$name] = new Date($this, $name, $attributes);
                break;
            case 'datetimerange':
                $attributes['with_time'] = true;
                $this->_inputs[$name] = new DateRange($this, $name, $attributes);
                break;
            default:
                $this->_inputs[$name] = new FormInput($this, $name, $attributes);
        }
        // set input value if possible
        if ($this->getInputValue($name) !== null && !isset($this->_inputs[$name]->value)) {
            if (get_class($this->_inputs[$name]) == 'FormImage') {
                $values = $this->getInputValue($name);
                $paths = $this->getInputValue($name . '_path');
                if (!empty($paths) && is_array($paths) && !empty($values) && is_array($values)) {
                    foreach ($values as $version => $url) {
                        $values[$version . '_path'] = $paths[$version];
                    }
                }
                $this->_inputs[$name]->setValue($values);
            } else {
                $this->_inputs[$name]->setValue($this->getInputValue($name));
            }
        }
        return $this;
    }

    /**
     * Add submit button to form
     * @param array $attributes
     * @return Form
     */
    public function setSubmitInput($attributes = null) {
        if (!is_array($attributes)) {
            return $this->submitButton;
        } else {
            $attributes['type'] = 'submit';
            $this->submitButton = new FormInput($this, '', $attributes);
            return $this;
        }
    }

    /**
     * @param bool $useDl
     * @return string
     */
    public function build($useDl = true) {
        return $this->buildOpenTag() . $this->buildContent($useDl) . $this->buildCloseTag();
    }

    /**
     * @return string
     */
    public function buildOpenTag() {
        if (empty($this->attributes['method'])) {
            $this->attributes['method'] = 'get';
        }
        return parent::buildOpenTag();
    }

    /**
     * @return string
     */
    public function buildCloseTag() {
        return $this->buildSecurity() . parent::buildCloseTag();
    }

    /**
     * @param bool $enable
     * @return Form
     */
    public function enableSecurity($enable) {
        $this->security = !!$enable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSecurityEnabled() {
        return $this->security;
    }

    /**
     * @return string
     */
    public function buildSecurity() {
        if ($this->security) {
            $formName = new Hidden($this, Security::FORM_NAME, array('value' => $this->name));
            $token = new SecurityToken($this, Security::TOKEN);
            $timestamp = new Hidden($this, Security::TIMESTAMP, array('value' => Security::getTimestamp()));
            return $token . $timestamp . $formName;
        } else {
            return '';
        }
    }

    /**
     * @param bool $useDl
     * @return string
     */
    public function buildContent($useDl = true) {
        $ret = '';
        foreach ($this->_inputs as $name => $input) {
            if (!in_array($name, array(Security::TIMESTAMP, Security::TOKEN))) {
                $ret .= $useDl ? $input->buildDlRow() : $input->build();
            }
        }
        if ($useDl) {
            $ret = $this->dl()->setContent($ret)->build();
        }
        $ret .= $this->buildSubmit();
        return $ret;
    }

    /**
     * @return string
     */
    public function buildSubmit() {
        if (!empty($this->submitButton)) {
            return $this->div(array('class' => 'submit'))->setContent($this->submitButton->build())->build();
        }
        return '';
    }

}