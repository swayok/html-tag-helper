<?php

namespace Swayok\Html;

/**
 * Class Tag
 * Attributes:
 * @property-read string $accessKey
 * @property-read bool $contentEditable
 * @property-read string $contextMenu
 * @property-read string $class
 * @property-read string $dir
 * @property-read string $id
 * @property-read bool $hidden
 * @property-read string $lang
 * @property-read bool $spellCheck
 * @property-read string $style
 * @property-read int $tabindex
 * @property-read string $title
 * @property-read string $href
 * @property-read bool $nohref
 * @property-read string|int $width
 * @property-read string|int $height
 *
 * @property-read string $acceptCharset
 * @property-read string $action
 * @property-read bool $autoComplete
 * @property-read string $method
 * @property-read string $name
 * @property-read bool $noValidate
 * @property-read string $target
 * @property-read string $encType
 *
 * @property-read string $for
 *
 * @property-read string $value
 * @property-read string $placeholder
 * @property-read int $maxlength
 * @property-read int $rows
 * @property-read int $cols
 * @property-read bool $checked
 * @property-read bool $selected
 * @property-read bool $multiple
 * @property-read int $size
 *
 * @property-read string $src
 * @property-read string $alt
 *
 * @property-read int $colspan
 * @property-read int $rowspan
 *
 * @method $this setAccessKey($value)
 * @method $this setContentEditable($value)
 * @method $this setContextMenu($value)
 * @method $this setClass($value)
 * @method $this setDir($value)
 * @method $this setId($value)
 * @method $this setHidden($value)
 * @method $this setLang($value)
 * @method $this setSpellCheck($value)
 * @method $this setStyle($value)
 * @method $this setTabindex($value)
 * @method $this setTitle($value)
 * @method $this setHref($value)
 * @method $this setNohref($value)
 * @method $this setWidth($value)
 * @method $this setHeight($value)
 *
 * @method $this setAcceptCharset($value)
 * @method $this setAction($value)
 * @method $this setAutoComplete($value)
 * @method $this setMethod($value)
 * @method $this setName($value)
 * @method $this setNoValidate($value)
 * @method $this setTarget($value)
 * @method $this setEncType($value)
 *
 * @method $this setFor($value)
 *
 * @method $this setValue($value)
 * @method $this setPlaceholder($value)
 * @method $this setMaxlength($value)
 * @method $this setRows($value)
 * @method $this setCols($value)
 * @method $this setChecked($value)
 * @method $this setSelected($value)
 * @method $this setMultiple($value)
 * @method $this setSize($value)
 *
 * @method $this setColspan($value)
 * @method $this setRowspan($value)
 *
 * @method $this setSrc($value)
 * @method $this setAlt($value)
 *
 * From and Inputs:
 * @property-read string $onBlur
 * @property-read string $onChange
 * @property-read string $onClick
 * @property-read string $onDblClick
 * @property-read string $onFocus
 * @property-read string $onKeyDown
 * @property-read string $onKeyPress
 * @property-read string $onKeyUp
 * @property-read string $onLoad
 * @property-read string $onMouseDown
 * @property-read string $onMouseMove
 * @property-read string $onMouseOut
 * @property-read string $onMouseOver
 * @property-read string $onMouseUp
 * @property-read string $onReset
 * @property-read string $onSelect
 * @property-read string $onSubmit
 * @property-read string $onUnload
 * @property-read string $type
 *
 * @method $this setOnBlur($value)
 * @method $this setOnChange($value)
 * @method $this setOnClick($value)
 * @method $this setOnDblClick($value)
 * @method $this setOnFocus($value)
 * @method $this setOnKeyDown($value)
 * @method $this setOnKeyPress($value)
 * @method $this setOnKeyUp($value)
 * @method $this setOnLoad($value)
 * @method $this setOnMouseDown($value)
 * @method $this setOnMouseMove($value)
 * @method $this setOnMouseOut($value)
 * @method $this setOnMouseOver($value)
 * @method $this setOnMouseUp($value)
 * @method $this setOnSelect($value)
 * @method $this setOnUnload($value)
 * @method $this setOnSubmit($value)
 * @method $this setOnReset($value)
 * @method $this setType($value)
 *
 * Quick Tags
 * @method static $this dl($attributes = array())
 * @method static $this dt($attributes = array())
 * @method static $this dd($attributes = array())
 * @method static $this div($attributes = array())
 * @method static $this span($attributes = array())
 * @method static $this nav($attributes = array())
 * @method static $this a($attributes = array())
 * @method static $this button($attributes = array())
 * @method static $this p($attributes = array())
 * @method static $this i($attributes = array())
 * @method static $this ul($attributes = array())
 * @method static $this ol($attributes = array())
 * @method static $this li($attributes = array())
 * @method static $this tr($attributes = array())
 * @method static $this td($attributes = array())
 * @method static $this th($attributes = array())
 * @method static $this table($attributes = array())
 * @method static $this thead($attributes = array())
 * @method static $this tbody($attributes = array())
 * @method static $this option($attributes = array())
 * @method static $this img($attributes = array())
 * @method static $this pre($attributes = array())
 * @method static $this script($attributes = array())
 * @method static $this h1($attributes = array())
 * @method static $this h2($attributes = array())
 * @method static $this h3($attributes = array())
 * @method static $this h4($attributes = array())
 * @method static $this h5($attributes = array())
 */
class Tag {
    public $tagName = 'div';
    public $short = false;
    protected $attributesMap = array();
    protected $attributes = array();
    protected $renderedAttributes = array();
    protected $excludeAttributes = array();
    protected $content = '';
    static protected $quickTags = array(
        'dl', 'dt', 'dd',
        'div', 'span', 'a', 'p', 'nav',
        'ul', 'ol', 'li',
        'option', 'img', 'pre',
        'table', 'tr', 'td', 'th', 'thead', 'tbody',
        'script', 'h1', 'h2', 'h3', 'h4', 'h5',
        'button'
    );


    /**
     * @param array $attributes
     * @param null|string $tagName
     * @return $this
     * @throws \Swayok\Html\HtmlTagException
     */
    static public function create($attributes = array(), $tagName = null) {
        return new static($attributes, $tagName);
    }

    /**
     * @param array $attributes
     * @param null $tagName
     * @throws HtmlTagException
     */
    public function __construct($attributes = array(), $tagName = null) {
        if (!empty($tagName)) {
            $this->tagName = strtolower($tagName);
        }
        if (!is_string($this->tagName) || !preg_match('%^[a-zA-Z][a-zA-Z0-9-]*$%is', $this->tagName)) {
            throw new HtmlTagException("Invalid HTML tag name [$this->tagName]");
        }
        if (!is_array($attributes)) {
            $this->content = $attributes;
            $attributes = array();
        } else if (isset($attributes['content'])) {
            $this->content = $attributes['content'];
        }
        unset($attributes['content']);
        $this->attributes = array();
        // 'name' attribute first!
        if (isset($attributes['name'])) {
            $this->name = $attributes['name'];
        }
        unset($attributes['name']);
        $this->setAttributes($attributes);
    }

    /**
     * @param array $attributes
     * @param bool $replace
     * @return $this
     */
    public function setAttributes(array $attributes, $replace = false) {
        if ($replace) {
            $this->attributes = array();
        }
        foreach ($attributes as $attrName => $attrValue) {
            $this->setAttribute($attrName, $attrValue);
        }
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     * @throws HtmlTagException
     */
    public function setAttribute($name, $value) {
        if (isset($this->attributesMap[$name])) {
            $name = $this->attributesMap[$name];
        }
        if (!preg_match('%^[a-zA-Z][a-zA-Z0-9-]*$%is', $name)) {
            throw new HtmlTagException("Invalid HTML tag attribure name [$name]");
        }
        $methodName = 'set' . str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
        if (method_exists($this, $methodName)) {
            $this->$methodName($value);
        } else {
            $this->attributes[$name] = $value;
        }
        return $this;
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getAttribute($name) {
        $name = strtolower($name);
        if (isset($this->attributesMap[$name])) {
            $name = $this->attributesMap[$name];
        }
        return (isset($this->attributes[$name])) ? $this->attributes[$name] : null;
    }

    /**
     * @return array
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * Append css class to 'class' attribute
     * @param string|array $classes - string: 'class1' or 'class1 class2 ...' | array: list of css classes
     * @return $this
     */
    public function addClass($classes) {
        if (empty($classes) || (is_string($classes) && trim((string)$classes) === '')) {
            return $this;
        }
        if (empty($this->attributes['class'])) {
            $this->attributes['class'] = is_array($classes) ? implode(' ', $classes) : $classes;
        } else {
            if (!is_array($classes)) {
                $classes = preg_split('%\s+%is', $classes);
            }
            $existing = preg_split('%\s+%is', $this->attributes['class']);
            $this->attributes['class'] = trim(implode(' ', array_unique(array_merge($classes, $existing))));
        }
        return $this;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content) {
        $this->content = empty($content) && !is_numeric($content) ? '' : $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Append new content to existing tag's content
     * @param string $content
     * @return $this
     */
    public function append($content) {
        $this->content .= $content;
        return $this;
    }

    /**
     * Prepend existing tag's content with new content
     * @param string $content
     * @return $this
     */
    public function prepend($content) {
        $this->content = $content . $this->content;
        return $this;
    }

    /**
     * @param string $name - attr name without 'data-' prefix
     * @param string|null $value - null = remove attr
     * @return $this
     */
    public function setDataAttr($name, $value) {
        if ($value === null) {
            unset($this->attributes['data-' . strtolower($name)]);
        } else {
            $this->attributes['data-' . strtolower($name)] = $value;
        }
        return $this;
    }

    /**
     * @param string $name - attr name without 'data-' prefix
     * @return null
     */
    public function getDataAttr($name) {
        return isset($this->attributes['data-' . strtolower($name)])
            ? $this->attributes['data-' . strtolower($name)]
            : null;
    }

    /**
     * Add some already rendered and escaped attribute with value
     * Example: Dot.js insert like '{{? !it.is_active }}disabled{{?}}'
     * @param string $attributeWithValue
     * @return $this
     */
    public function addCustomRenderedAttributeWithValue($attributeWithValue) {
        $this->renderedAttributes[] = $attributeWithValue;
        return $this;
    }

    /**
     * Build tag
     * @return string - html
     */
    public function build() {
        return $this->buildOpenTag() . $this->buildContent() . $this->buildCloseTag();
    }

    /**
     * @return string
     */
    public function buildOpenTag() {
        return '<' . $this->tagName . self::buildAttributes($this->attributes, $this->excludeAttributes, $this->renderedAttributes) . '>';
    }

    /**
     * @return string
     */
    public function buildCloseTag() {
        return $this->short ? '' : '</' . $this->tagName . '>';
    }

    /**
     * @return string
     */
    public function buildContent() {
        return $this->short ? '' : $this->content;
    }

    /**
     * @param array $attributes
     * @param array $exclude
     * @param array $renderedAttributes
     * @return string
     */
    static public function buildAttributes($attributes, $exclude = array(), $renderedAttributes = array()) {
        $ret = $renderedAttributes;
        if (isset($attributes['name']) && is_int($attributes['name'])) {
            unset($attributes['name']);
        }
        if (array_key_exists('value', $attributes) && /*($attributes['value'] !== '') && */!in_array('value', $exclude, true)) {
//            $ret[] = 'value="' . htmlspecialchars(Translator::autoFind($attributes['value']), ENT_QUOTES, 'UTF-8', false) . '"';
            $ret[] = 'value="' . htmlspecialchars($attributes['value'], ENT_QUOTES, 'UTF-8', false) . '"';
            unset($attributes['value']);
        }
        foreach ($attributes as $name => $value) {
            $name = mb_strtolower($name);
            if (!is_string($value) && $value instanceof \Closure) {
                $ret[] = $name . '="' . str_replace('"', '\\"', $value()) . '"';
            } else if ((!empty($value) || is_numeric($value)) && !is_array($value) && !in_array($name, $exclude, true)) {
//                $ret[] = $name . '="' . htmlspecialchars(is_bool($value) ? $name : Translator::autoFind($value), ENT_QUOTES, 'UTF-8', false) . '"';
                if (is_bool($value)) {
                    if ($value) {
                        $ret[] = $name;
                    }
                } else {
                    $ret[] = $name . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false) . '"';
                }
            }
        }
        return ' ' . implode(' ', $ret) . ' ';
    }

    public function __get($attribute) {
        return $this->getAttribute($attribute);
    }

    /**
     * Unset attribute
     * @param string $attribute
     */
    public function __unset($attribute) {
        unset($this->attributes[$attribute]);
    }

    /**
     * Check if attribute value is set
     * @param string $attribute - field name or related object alias
     * @return bool
     */
    public function __isset($attribute) {
        return isset($this->attributes[$attribute]);
    }

    /**
     * @param string $name
     * @param array $args
     * @return $this
     * @throws HtmlTagException
     */
    public function __call($name, $args) {
        $name = strtolower($name);
        if (in_array($name, Tag::$quickTags)) {
            return Tag::__callStatic($name, $args);
        }
        if (count($args) === 1 && preg_match('%^set([a-zA-Z_0-9]+)%is', $name, $nameParts)) {
            $name = $nameParts[1];
        } else {
            throw new HtmlTagException('Method calls should start with "set" and pass 1 argument');
        }
        $this->setAttribute($name, $args[0]);
        return $this;
    }

    /**
     * Create Tag by quick tag name
     * @param string $tagName
     * @param array $args
     * @return $this|null
     */
    public static function __callStatic($tagName, $args) {
        $tagName = strtolower($tagName);
        if (in_array($tagName, self::$quickTags)) {
            $attributes = count($args) ? $args[0] : array();
            return Tag::create($attributes, $tagName);
        }
        return null;
    }

    /**
     * @return string
     * @throws HtmlTagException
     */
    public function __toString() {
        try {
            return $this->build();
        } catch (\Exception $exc) {
            return $exc->getMessage() . "<br>\n" . nl2br($exc->getTraceAsString());
        }
    }
}