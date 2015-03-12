(function($) {  
    $(document).ready(function() { 

        $('body').on("click", ".taxonomy-filter-item", function(event) {
            var self = this;
            var id = $(this).data('item');
            var params = $(this).closest('.taxonomy-filter');

            var data = {};
            data.action = 'setActiveTerm';
            data.nonce = ajax_atf.ajax_nonce,
            data.term_id = id; 
            data.taxonomy = params.data('taxonomy');                         
            data.post_type = params.data('post_type');                         
            data.is_ajax = params.data('is_ajax');
            data.is_multi_select = params.data('is_multi_select');                         
            data.content_selector = params.data('content_selector');                         
            data.name = params.data('name');                         

            if (data.is_ajax) {
                event.preventDefault();
                
                $.ajax({
                    url: ajax_atf.ajax_url,
                    type: 'POST' ,
                    data: data,
                    dataType: 'html',
                    cache: false,
                    success: function() {
                        $.ajax({
                            url: "",
                            type: 'POST' ,
                            dataType: 'html',
                            cache: false,
                            success: function(data) {
                                $(params.data('content_selector')).html($(data).find(params.data('content_selector')).html());                    
                                
                                if (params.data('is_multi_select')) {
                                    $(self).closest('.taxonomy-filter-item').toggleClass('active', '');    
                                } else {
                                    $(self).closest('.taxonomy-filter').find('.taxonomy-filter-item').removeClass('active');
                                    $(self).closest('.taxonomy-filter-item').addClass('active');    
                                }
                            }
                        });  
                    }
                });                   
            }
        });                
    });
})(jQuery);


