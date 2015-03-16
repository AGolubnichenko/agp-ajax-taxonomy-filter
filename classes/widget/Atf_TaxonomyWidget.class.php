<?php

class Atf_TaxonomyWidget extends WP_Widget {
    
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 'description' => __( "Filter by terms of a preset taxonomy") );
		parent::__construct('atf_taxonomy_widget', __('AGP Ajax Taxonomy Filter'), $widget_ops);
        
        add_action( "wp_ajax_atf_post_type_select", array($this, 'doAtfPostTypeSelect') );
        add_action( "wp_ajax_nopriv_atf_post_type_select", array($this, 'doAtfPostTypeSelect'));        
	}
    
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        //if  (!$instance['is_ajax'] || is_post_type_archive($instance['post_type'])) {
            echo $args['before_widget'];
            if (!empty( $instance['title'])) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
            }
            echo Atf()->getTemplate('atf', $this->id);                
            echo $args['after_widget'];
        //}
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = !empty($instance['title']) ? $instance['title'] : '';
        $post_type = !empty($instance['post_type']) ? $instance['post_type'] : 'post';        
        $taxonomy = !empty($instance['taxonomy']) ? $instance['taxonomy'] : '';                
        $is_ajax = !empty( $instance['is_ajax'] ) ? (bool) $instance['is_ajax'] : false;
        $is_multi_select = !empty( $instance['is_multi_select'] ) ? (bool) $instance['is_multi_select'] : false;
        $content_selector = !empty($instance['content_selector']) ? $instance['content_selector'] : '';
    ?>
        <p><?php $this->renderTitleField($title); ?></p>
        <p><?php $this->renderPostTypeField($post_type); ?></p>        
        <p><?php $this->renderTaxonomyField($post_type, $taxonomy); ?></p>        
        <p>
            <?php $this->renderIsAjaxField($is_ajax); ?>
            <br>
            <span class="is_ajax_relations" style="display:<?php echo ($is_ajax) ? 'block' : 'none';?>;" >
                <?php $this->renderIsMultiSelectField($is_multi_select); ?>
            </span>
        </p>        
        <p class="is_ajax_relations" style="display:<?php echo ($is_ajax) ? 'block' : 'none';?>;">
            <?php $this->renderContentSelectorField($content_selector); ?>
        </p>            
        <?php $this->initJS();?>           
    <?php    
	}
    
	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
        
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags( $new_instance['title'] ) : '';
        $instance['post_type'] = (!empty($new_instance['post_type'])) ? strip_tags( $new_instance['post_type'] ) : '';
        $instance['taxonomy'] = (!empty($new_instance['taxonomy'])) ? strip_tags( $new_instance['taxonomy'] ) : '';        
        $instance['is_ajax'] = (!empty($new_instance['is_ajax'])) ? 1 : 0;        
        $instance['is_multi_select'] = (!empty($new_instance['is_multi_select']) && $instance['is_ajax']) ? 1 : 0;                
        $instance['content_selector'] = (!empty($new_instance['content_selector']) && $instance['is_ajax']) ? strip_tags( $new_instance['content_selector'] ) : '';                        

		return $instance;
	}    
    
    public function renderTitleField ($title) {
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">    
    <?php    
    }    
    
    public function renderPostTypeField ($post_type) {
        $args = array( 'public'   => true, '_builtin' => false);
        $output = 'names'; 
        $operator = 'and'; 
        $types = array_merge( array('post'), get_post_types( $args, $output, $operator ));    
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php _e( 'Post Type:' ); ?></label>
        <select data-number="<?php echo $this->number;?>" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" class="post-type-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>">
        <?php foreach ( $types as $type ) : ?>
            <option value="<?php echo esc_attr( $type ); ?>"<?php selected( $post_type, $type ); ?>><?php echo $type; ?></option>
        <?php endforeach; ?>
        </select>        
    
    <?php    
    }
    
    public function renderTaxonomyField ($post_type, $current_taxonomy = '') {
        $taxonomies = get_object_taxonomies( $post_type, 'names' );
        if (empty($current_taxonomy) && !empty($taxonomies)) {
            $current_taxonomy = $taxonomies[0];
        }
        
    ?>    
        <label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php _e( 'Taxonomy / Category:' ); ?></label>
        <select id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" class="taxonomy-select widefat" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>">
        <?php foreach ( $taxonomies as $tax ) : ?>
            <option value="<?php echo esc_attr( $tax ); ?>"<?php selected( $current_taxonomy, $tax ); ?>><?php echo $tax; ?></option>
        <?php endforeach; ?>
        </select>
    <?php    
    }
    
    
    public function renderContentSelectorField ($content_selector) {
    ?>
        <label for="<?php echo esc_attr( $this->get_field_id( 'content_selector' ) ); ?>"><?php _e( 'Ajax Content Selector:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'content_selector' ); ?>" name="<?php echo $this->get_field_name( 'content_selector' ); ?>" type="text" value="<?php echo esc_attr( $content_selector ); ?>">    
    <?php            
    }
    
    public function renderIsAjaxField($is_ajax) {
    ?>
        <input id="<?php echo esc_attr( $this->get_field_id( 'is_ajax' ) ); ?>" class="checkbox is_ajax_select" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'is_ajax' ) ); ?>"<?php checked( $is_ajax ); ?>>
        <label for="<?php echo esc_attr( $this->get_field_id( 'is_ajax' ) ); ?>"><?php _e( 'Ajax  (It works only for custom post type archive)' ); ?></label>        
    <?php    
    }
    
    public function renderIsMultiSelectField($is_multi_select) {
    ?>
        <input id="<?php echo esc_attr( $this->get_field_id( 'is_multi_select' ) ); ?>" class="checkbox is_multi_select_select" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'is_multi_select' ) ); ?>"<?php checked( $is_multi_select ); ?>>
        <label for="<?php echo esc_attr( $this->get_field_id( 'is_multi_select' ) ); ?>"><?php _e( 'Multi Selection' ); ?></label>        
    <?php    
    }
    
    public function initJS() {
    ?>
    <script>
        (function($) {  
            $(".post-type-select").unbind('change');
            $(".post-type-select").bind('change', function(event) {
                event.preventDefault();
                var taxonomy_selector = $(this).closest('form').find('.taxonomy-select');
                
                data = {};
                data.action = 'atf_post_type_select';
                data.nonce = "<?php echo wp_create_nonce('ajax_atf_widget_nonce');?>";
                data.post_type =  $(this).find(':selected').eq(0).val();
                data.number = $(this).data('number');

                $.ajax({
                    url: "<?php echo admin_url( 'admin-ajax.php' );?>",
                    type: 'POST' ,
                    data: data,
                    dataType: 'html',
                    cache : false,
                    success: function(data, text) {
                        $(taxonomy_selector).closest('p').html(data);
                    }
                });                        
            });
            
            $(".is_ajax_select").unbind('change');
            $(".is_ajax_select").bind('change', function(event) {
                event.preventDefault();
                var checked = $(this).attr('checked') == 'checked';
                if (checked) {
                    $(this).closest('form').find('.is_ajax_relations').fadeIn(400);
                } else {
                    $(this).closest('form').find('.is_ajax_relations').fadeOut(400);
                }

            });            
                    
        })(jQuery);
    </script>    
	<?php 
    }

    public function doAtfPostTypeSelect () {
        if (check_ajax_referer('ajax_atf_widget_nonce', 'nonce', false)) {
            $post_type = $_POST['post_type'];
            $number = $_POST['number']; 
            $obj = new Atf_TaxonomyWidget();
            $obj->number = $number;
            $obj->renderTaxonomyField($post_type);
        } else {
            http_response_code(500);
        }
        die();
    }
}

    