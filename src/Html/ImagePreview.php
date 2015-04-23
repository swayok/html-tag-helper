<?php

namespace App\Utils\Html;

class ImagePreview extends Tag{
    public $tagName = 'div';

    public function buildOpenTag() {
        $this->addClass('image-previews');
        return parent::buildOpenTag();
    }

    public function buildContent() {
        $files = $this->content;
        $content = '';
        if (empty($files)) {
        } else if (is_string($files)) {
            $content = $this->buildImgPreview($files);
            // single image
        } else if (is_array($files)) {
            foreach ($files as $value) {
                $content.= $this->buildImgPreview($value);
            }
        }
        return $content;
    }

    protected function buildImgPreview($fileUrl) {
//        return $this->div()->class('image-preview')->content($this->img()->src(Router::neverCachedUrl($fileUrl)));
        return $this->div()->class('image-preview')->content($this->img()->src($fileUrl));
    }
}