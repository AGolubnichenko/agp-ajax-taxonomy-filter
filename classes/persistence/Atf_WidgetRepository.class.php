<?php

class Atf_WidgetRepository extends Agp_SingleSelectRepository {
    
    public $entityClass ='Atf_WidgetEntity';

    public function refreshRepository() {
        $data = array();                        

        global $wp_registered_widgets;        
        foreach ($wp_registered_widgets as $widget_data) {
            if (is_active_widget(FALSE, $widget_data['id'], 'atf_taxonomy_widget')) {
                $widget = $widget_data['callback'][0];
                $number = str_replace('atf_taxonomy_widget-', '', $widget_data['id']);
                $settings = $widget->get_settings();
                
                $data[] = array(
                    'ID' => $widget_data['id'],
                    'number' => $number,
                    'widget' => $widget,
                    'settings' => $settings[$number],
                );
            }
        }            
        
        parent::refresh($data);        
    }
}
