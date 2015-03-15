<?php

class Atf_WidgetEntity extends Agp_Entity {
    private $widget;
    private $number;
    private $settings;

    /**
     * Taxonomy Repository
     * 
     * @var Atf_TaxonomyRepository
     */
    private $taxonomyRepository;        
    
    
    public function __construct($data) {
        $default = array(
            'ID' => NULL, 
            'number' => NULL,
            'widget' => NULL,
            'settings' => NULL,
        );

        parent::__construct($data, $default); 
        
        $this->settings = new Atf_WidgetSettingsEntity($this->settings);
        $this->taxonomyRepository = new Atf_TaxonomyRepository();
        $this->taxonomyRepository->setName($this->getId());
        if ($this->settings->getTaxonomy() && taxonomy_exists($this->settings->getTaxonomy())) {
            $this->taxonomyRepository->refreshRepository($this->settings->getTaxonomy());    
        }
    }
    
    public function getTaxonomyRepository() {
        return $this->taxonomyRepository;
    }

    public function getWidget() {
        return $this->widget;
    }

    public function setWidget($widget) {
        $this->widget = $widget;
        return $this;
    }
    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = $number;
        return $this;
    }

    public function getSettings() {
        return $this->settings;
    }

    public function setSettings($settings) {
        $this->settings = $settings;
        return $this;
    }
}
