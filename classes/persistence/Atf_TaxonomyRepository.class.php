<?php

class Atf_TaxonomyRepository extends Agp_MultiSelectRepository {
    
    public $entityClass ='Agp_TaxonomyEntity';
    
    public function refreshRepository($taxonomy) {
        $data = array();                        
        /**
         *  Terms
         */
        $taxonomies = array( $taxonomy );
        $args = array(
            'hide_empty'    => false,
            'fields'        => 'all', 
            'hierarchical'  => true
        );             

        $terms = get_terms( $taxonomies, $args );

        if (!is_wp_error($terms) && is_array($terms)) {
            $data = array_merge($data, $terms);
        }
        
        parent::refresh($data);
    }

}
