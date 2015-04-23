<?php

namespace App\Utils\Html;

/**
 * Class Tag
 * Attributes:
 * @property string $accessKey
 * @property bool $contentEditable
 * @property string $contextMenu
 * @property string $class
 * @property string $dir
 * @property string $id
 * @property bool $hidden
 * @property string $lang
 * @property bool $spellCheck
 * @property string $style
 * @property int $tabindex
 * @property string $title
 * @property string $href
 * @property bool $nohref
 * @property string|int $width
 * @property string|int $height
 *
 * @property string $acceptCharset
 * @property string $action
 * @property bool $autoComplete
 * @property string $method
 * @property string $name
 * @property bool $noValidate
 * @property string $target
 * @property string $encType
 *
 * @property string $for
 *
 * @property string $value
 * @property string $placeholder
 * @property int $maxlength
 * @property int $rows
 * @property int $cols
 * @property bool $checked
 * @property bool $selected
 * @property bool $multiple
 * @property int $size
 *
 * @property string $src
 * @property string $alt
 *
 * @property int $colspan
 * @property int $rowspan
 *
 * @method string|$this accessKey() accessKey($value = null)
 * @method bool|$this contentEditable() contentEditable($value = null)
 * @method string|$this contextMenu() contextMenu($value = null)
 * @method string|$this class() class($value = null)
 * @method string|$this dir() dir($value = null)
 * @method string|$this id() id($value = null)
 * @method bool|$this hidden() hidden($value = null)
 * @method string|$this lang() lang($value = null)
 * @method bool|$this spellCheck() spellCheck($value = null)
 * @method string|$this style() style($value = null)
 * @method int|$this tabindex() tabindex($value = null)
 * @method string|$this title() title($value = null)
 * @method string|$this href() href($value = null)
 * @method string|$this nohref() nohref($value = null)
 * @method int|string|$this width() width($value = null)
 * @method int|string|$this height() height($value = null)
 *
 * @method string|$this acceptCharset() acceptCharset($value = null)
 * @method string|$this action() action($value = null)
 * @method bool|$this autoComplete() autoComplete($value = null)
 * @method string|$this method() method($value = null)
 * @method string|$this name() name($value = null)
 * @method bool|$this noValidate() noValidate($value = null)
 * @method string|$this target() target($value = null)
 * @method string|$this encType() encType($value = null)
 *
 * @method string|$this for() for($value = null)
 *
 * @method string|$this value() value($value = null)
 * @method string|$this placeholder() placeholder($value = null)
 * @method int|$this maxlength() maxlength($value = null)
 * @method int|$this rows() rows($value = null)
 * @method int|$this cols() cols($value = null)
 * @method bool|$this checked() checked($value = null)
 * @method bool|$this selected() selected($value = null)
 * @method bool|$this multiple() multiple($value = null)
 * @method int|$this size() size($value = null)
 *
 * @method int|Tag colspan() colspan($value = null)
 * @method int|Tag rowspan() rowspan($value = null)
 *
 * @method int|Tag src() src($value = null)
 * @method int|Tag alt() alt($value = null)
 *
 * Events:
 * @property string $onBlur
 * @property string $onChange
 * @property string $onClick
 * @property string $onDblClick
 * @property string $onFocus
 * @property string $onKeyDown
 * @property string $onKeyPress
 * @property string $onKeyUp
 * @property string $onLoad
 * @property string $onMouseDown
 * @property string $onMouseMove
 * @property string $onMouseOut
 * @property string $onMouseOver
 * @property string $onMouseUp
 * @property string $onReset
 * @property string $onSelect
 * @property string $onSubmit
 * @property string $onUnload
 * @property string $type
 *
 * @method string|$this onBlur() onBlur($value = null)
 * @method string|$this onChange() onChange($value = null)
 * @method string|$this onClick() onClick($value = null)
 * @method string|$this onDblClick() onDblClick($value = null)
 * @method string|$this onFocus() onFocus($value = null)
 * @method string|$this onKeyDown() onKeyDown($value = null)
 * @method string|$this onKeyPress() onKeyPress($value = null)
 * @method string|$this onKeyUp() onKeyUp($value = null)
 * @method string|$this onLoad() onLoad($value = null)
 * @method string|$this onMouseDown() onMouseDown($value = null)
 * @method string|$this onMouseMove() onMouseMove($value = null)
 * @method string|$this onMouseOut() onMouseOut($value = null)
 * @method string|$this onMouseOver() onMouseOver($value = null)
 * @method string|$this onMouseUp() onMouseUp($value = null)
 * @method string|$this onSelect() onSelect($value = null)
 * @method string|$this onUnload() onUnload($value = null)
 * @method string|$this onSubmit() onSubmit($value = null)
 * @method string|$this onReset() onReset($value = null)
 * @method string|$this type() type($value = null)
 *
 * Quick Tags
 * @method static $this dl($attributes = array())
 * @method static $this dt($attributes = array())
 * @method static $this dd($attributes = array())
 * @method static $this div($attributes = array())
 * @method static $this span($attributes = array())
 * @method static $this nav($attributes = array())
 * @method static $this a($attributes = array())
 * @method static $this p($attributes = array())
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
    protected $excludeAttributes = array();
    protected $content = '';
    static protected $quickTags = array(
        'dl', 'dt', 'dd',
        'div', 'span', 'a', 'p', 'nav',
        'ul', 'ol', 'li',
        'option', 'img', 'pre',
        'table', 'tr', 'td', 'th', 'thead', 'tbody',
        'script', 'h1', 'h2', 'h3', 'h4', 'h5'
    );

    /**
     * @param array $attributes
     * @return $this
     */
    static public function get($attributes = array()) {
        $class = get_called_class();
        return new $class($attributes);
    }

    public function __construct($attributes = array(), $tagName = null) {
        if (!empty($tagName)) {
            $this->tagName = $tagName;
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
        foreach ($attributes as $name => $value) {
            $this->$name = $value; //< this will trigger __set() where custom processing can be done
        }
    }

    /**
     * Get or set attributes
     * @param null|array $attributes
     * @param bool $replace - true: existing attributes will be raplaced | false: $attributes will be merged with existing
     * @return array|$this
     */
    public function attributes($attributes = null, $replace = false) {
        if (!is_array($attributes)) {
            return $this->attributes;
        } else {
            $this->attributes = $replace ? $attributes : array_merge($this->attributes, $attributes);
            return $this;
        }
    }

    /**
     * Append css class to 'class' attribute
     * @param string|array $classes - string: 'class1' or 'class1 class2 ...' | array: list of css classes
     * @return $this
     */
    public function addClass($classes) {
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
     * Set tag content
     * @param null|string $content - text or html
     * @return $this
     */
    public function content($content = null) {
        if ($content === null) {
            return $this->content;
        } else {
            $this->content = empty($content) && !is_numeric($content) ? '' : $content;
            return $this;
        }
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
     * @param $name
     * @param null $value
     * @return $this
     */
    public function data($name, $value = null) {
        if ($value === null) {
            return isset($this->attributes['data-' . strtolower($name)])
                ? $this->attributes['data-' . strtolower($name)]
                : null;
        } else {
            $this->attributes['data-' . strtolower($name)] = $value;
            return $this;
        }
    }

    /**
     * Build tag
     * @return string - html
     */
    public function build() {
        return $this->buildOpenTag() . $this->buildContent() . $this->buildCloseTag();
    }

    public function buildOpenTag() {
        return '<' . $this->tagName . self::buildAttributes($this->attributes, $this->excludeAttributes) . '>';
    }

    public function buildCloseTag() {
        return $this->short ? '' : '</' . $this->tagName . '>';
    }

    public function buildContent() {
        return $this->short ? '' : $this->content;
    }

    static protected function buildAttributes($attributes, $exclude = array()) {
        $ret = array();
        if (isset($attributes['name']) && is_int($attributes['name'])) {
            unset($attributes['name']);
        }
        if (array_key_exists('value', $attributes) && ($attributes['value'] !== '') && !in_array('value', $exclude)) {
//            $ret[] = 'value="' . htmlspecialchars(Translator::autoFind($attributes['value']), ENT_QUOTES, 'UTF-8', false) . '"';
            $ret[] = 'value="' . htmlspecialchars($attributes['value'], ENT_QUOTES, 'UTF-8', false) . '"';
            unset($attributes['value']);
        }
        foreach ($attributes as $name => $value) {
            if ((!empty($value) || is_numeric($value)) && !is_array($value) && !in_array($name, $exclude)) {
//                $ret[] = $name . '="' . htmlspecialchars(is_bool($value) ? $name : Translator::autoFind($value), ENT_QUOTES, 'UTF-8', false) . '"';
                $ret[] = $name . '="' . htmlspecialchars(is_bool($value) ? $name : $value, ENT_QUOTES, 'UTF-8', false) . '"';
            }
        }
        return ' ' . implode(' ', $ret) . ' ';
    }

    public function __set($attribute, $value) {
        $attribute = strtolower($attribute);
        if (isset($this->attributesMap[$attribute])) {
            $attribute = $this->attributesMap[$attribute];
        }
        $this->attributes[$attribute] = $value;
    }

    public function __get($attribute) {
        $attribute = strtolower($attribute);
        if (isset($this->attributesMap[$attribute])) {
            $attribute = $this->attributesMap[$attribute];
        }
        return (isset($this->attributes[$attribute])) ? $this->attributes[$attribute] : null;
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
        if (in_array($name, self::$quickTags)) {
            return self::__callStatic($name, $args);
        }
        if (isset($this->attributesMap[$name])) {
            $name = $this->attributesMap[$name];
        }
        if (count($args) <= 1) {
            if (isset($this->attributes[$name]) && count($args) == 0) {
                return $this->attributes[$name];
            } else if (count($args) == 1) {
                $this->attributes[$name] = $args[0];
            } else {
                throw new HtmlTagException('What are you trying to do???');
            }
        } else {
            throw new HtmlTagException('What are you trying to do???');
        }
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
            return self::tag($tagName, $attributes);
        }
        return null;
    }

    /**
     * @param string $tagName
     * @param array $attributes
     * @return $this
     */
    public static function tag($tagName, $attributes = array()) {
        return new Tag($attributes, $tagName);
    }

    /**
     * @return string
     * @throws HtmlTagException
     */
    public function __toString() {
        return $this->build();
    }
}