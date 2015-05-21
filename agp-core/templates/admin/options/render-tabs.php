<?php
$args = $params;

if (!empty($args->tabs) && count($args->tabs) > 1) {
    echo '<h2 class="nav-tab-wrapper">';
    foreach ( $args->tabs as $tab_key => $tab_data ) {
        $tab_caption = $tab_data['title'];
        $active = $args->key == $tab_key ? 'nav-tab-active' : '';
        echo '<a class="nav-tab ' . $active . '" href="?page=' . $args->settings->getPage() . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
    }
    echo '</h2>';            
} elseif (!empty($args->tabs)) {
    echo '<h2>';
    foreach ( $args->tabs as $tab_key => $tab_data ) {
        $tab_caption = $tab_data['title'];                
        echo $tab_caption;
    }
    echo '</h2>';            
} else {
    echo '<h2>Settings</h2>';
}