<?php

class Atf_WidgetSettingsEntity extends Agp_Entity {
    private $title;
    private $post_type;
    private $taxonomy;
    private $is_ajax;
    private $is_multi_select;
    private $content_selector;
    
    public function __construct($data) {
        $default = array(
            'ID' => uniqid(),
            'title' => NULL,
            'post_type' => NULL,
            'taxonomy' => NULL,
            'is_ajax' => NULL,
            'is_multi_select' => NULL,
            'content_selector' => NULL,
        );

        parent::__construct($data, $default); 
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function getPost_type() {
        return $this->post_type;
    }

    public function getTaxonomy() {
        return $this->taxonomy;
    }

    public function getIs_ajax() {
        return $this->is_ajax;
    }

    public function getIs_multi_select() {
        return $this->is_multi_select;
    }

    public function getContent_selector() {
        return $this->content_selector;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setPost_type($post_type) {
        $this->post_type = $post_type;
        return $this;
    }

    public function setTaxonomy($taxonomy) {
        $this->taxonomy = $taxonomy;
        return $this;
    }

    public function setIs_ajax($is_ajax) {
        $this->is_ajax = $is_ajax;
        return $this;
    }

    public function setIs_multi_select($is_multi_select) {
        $this->is_multi_select = $is_multi_select;
        return $this;
    }

    public function setContent_selector($content_selector) {
        $this->content_selector = $content_selector;
        return $this;
    }


}
