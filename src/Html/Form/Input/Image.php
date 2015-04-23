<?php

namespace App\Utils\Html\Form\Input;

use App\Utils\Html\Form\Form;
use App\Utils\Html\Form\FormInput;
use App\Utils\Html\ImagePreview;

class Image extends FormInput {

    /** @var bool|array */
    protected $preview = false;
    /** @var bool|array */
    protected $files = false;
    protected $fileTypes = 'image/png, image/jpeg';

    public function __construct(Form $form, $name, $attributes = array()) {
        $attributes['type'] = 'file';
        if (!empty($attributes['images'])) {
            $this->preview = $attributes['images'];
        }
        unset($attributes['images']);
        parent::__construct($form, $name, $attributes);
    }

    public function buildOpenTag() {
        if (!empty($this->attributes['value'])) {
            $this->files = $this->attributes['value'];
        }
        if (empty($this->attributes['accept'])) {
            $this->attributes['accept'] = $this->fileTypes;
        }
        if ($this->hasFileUploaded()) {
            $this->attributes['required'] = false;
        }
        unset($this->attributes['value']);
        $openTag = parent::buildOpenTag(); //< created input id
        $cleanBtn = $this->a()
            ->class('clean-input icon-delete')
            ->content('Clean')
            ->href("javascript: Form.cleanFileInput('{$this->id}') && void(0)");
        return $cleanBtn . $openTag;
    }

    protected function hasFileUploaded() {
        return !empty($this->preview) && !empty($this->files);
    }

    public function buildCloseTag() {
        $previewBlock = '';
        if ($this->hasFileUploaded()) {
            $filesToShow = array_intersect_key($this->files, array_flip($this->preview));
            if (!empty($filesToShow)) {
                foreach ($filesToShow as $version => $url) {
                    if (
                        array_key_exists($version . '_path', $this->files)
                        && (
                            empty($this->files[$version . '_path'])
                            || !file_exists($this->files[$version . '_path'])
                        )
                    ) {
                        unset($filesToShow[$version]);
                    }
                }
            }
            $previewBlock = !empty($filesToShow) ? ImagePreview::get()->content($filesToShow) : '';
        }
        return $previewBlock . parent::buildCloseTag();
    }
}