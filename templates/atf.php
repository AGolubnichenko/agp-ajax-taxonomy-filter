<?php 
$widget_id = $params;
$widget = Atf()->getWidgetRepository()->findById($widget_id);
if (!empty($widget)) :
    $taxonomyRepository = $widget->getTaxonomyRepository();
    if ($taxonomyRepository->getCount() > 0) : 
        $settings = $widget->getSettings();
        $terms = $taxonomyRepository->getAll();
        if (!empty($terms)) :
    ?>    
        <ul class="taxonomy-filter" 
            data-taxonomy="<?php echo esc_attr($settings->getTaxonomy());?>" 
            data-post_type="<?php echo esc_attr($settings->getPost_type());?>"
            data-is_ajax="<?php echo esc_attr($settings->getIs_ajax());?>"
            data-is_multi_select="<?php echo esc_attr($settings->getIs_multi_select());?>"
            data-content_selector="<?php echo esc_attr($settings->getContent_selector());?>"
            data-name="<?php echo esc_attr($taxonomyRepository->getName());?>"
        >
        <?php
            foreach($terms as $term) :
                if (!empty($term)) :
                    $link = ($term->getTerm_id() > 0) ? get_term_link(get_term($term->getTerm_id(), $term->getTaxonomy())) : get_post_type_archive_link( $settings->getPost_type() );
                    if (!empty($link)) :        
        ?>    
                <li class="taxonomy-filter-item<?php echo ($taxonomyRepository->isActive($term)) ? ' active' : '';?>" data-item="<?php echo $term->getTerm_id(); ?>">
                    <a href="<?php echo $link;?>" title="<?php echo $term->getName(); ?>"><?php echo $term->getName();?></a>
                </li>
        <?php
                    endif;
                endif;
            endforeach;
        ?>
        </ul>
    <?php 
        endif;
    endif;
endif;




