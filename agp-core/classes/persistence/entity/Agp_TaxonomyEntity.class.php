<?php

class Agp_TaxonomyEntity extends Agp_Entity {
    private $term_id;
    private $name;
    private $slug;
    private $term_group;
    private $term_order;
    private $term_taxonomy_id;
    private $taxonomy;
    private $description;
    private $parent;
    private $count;
    private $object_id;
    
    public function __construct($data) {
        $default = array(
            'ID' => $data->term_id, 
            'term_id' => $data->term_id,
            'name' => NULL,
            'slug' => NULL,
            'term_group' => NULL,
            'term_order' => NULL,
            'term_taxonomy_id' => NULL,
            'taxonomy' => NULL,
            'description' => NULL,
            'parent' => NULL,
            'count' => NULL,
            'object_id' => NULL,
        );

        parent::__construct($data, $default); 
    }
    
    public function getTerm_id() {
        return $this->term_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getTerm_group() {
        return $this->term_group;
    }

    public function getTerm_order() {
        return $this->term_order;
    }

    public function getTerm_taxonomy_id() {
        return $this->term_taxonomy_id;
    }

    public function getTaxonomy() {
        return $this->taxonomy;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getParent() {
        return $this->parent;
    }

    public function getCount() {
        return $this->count;
    }

    public function getObject_id() {
        return $this->object_id;
    }

    public function setTerm_id($term_id) {
        $this->term_id = $term_id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    public function setTerm_group($term_group) {
        $this->term_group = $term_group;
        return $this;
    }

    public function setTerm_order($term_order) {
        $this->term_order = $term_order;
        return $this;
    }

    public function setTerm_taxonomy_id($term_taxonomy_id) {
        $this->term_taxonomy_id = $term_taxonomy_id;
        return $this;
    }

    public function setTaxonomy($taxonomy) {
        $this->taxonomy = $taxonomy;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }

    public function setCount($count) {
        $this->count = $count;
        return $this;
    }

    public function setObject_id($object_id) {
        $this->object_id = $object_id;
        return $this;
    }
}
