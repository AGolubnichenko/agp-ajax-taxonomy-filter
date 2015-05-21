<?php
$obj = !empty($params['obj']) ? $params['obj'] : NULL;
$post_id = !empty($params['post_id']) ? $params['post_id'] : NULL;

if ( !empty($obj) && !empty($post_id) ) :
    $data = $obj->getData($post_id);
    $id = $obj->getId();
    $index = $obj->getMaxRow($post_id);
?>
    <script type="text/javascript">
        agp_repeater.rp_<?php echo $id;?>={};
        agp_repeater.rp_<?php echo $id;?>.index=<?php echo $index; ?>;
    </script>
    <div class="agp-repeater" id="agp-repeater-<?php echo $id?>" data-id="<?php echo $id?>">
        <table class="widefat striped" width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead>
                <?php echo $obj->getHeaderTemplateAdmin(); ?>
            </thead>        
            <tbody>
                <tr class="agp-row agp-row-template" style="display: none;">
                    <?php echo $obj->getRowTemplateAdmin(array('id' => $id, 'row' => 0, 'data' => $data)); ?>                    
                </tr>
                <?php
                if (!empty($data)):
                    foreach ($data as $key => $value) :
                ?>
                    <tr class="agp-row">
                        <?php echo $obj->getRowTemplateAdmin(array('id' => $id, 'row' => $key, 'data' => $value)); ?>
                    </tr>
                <?php
                    endforeach;
                else:
                ?>
                    <tr class="agp-row">                    
                        <?php echo $obj->getRowTemplateAdmin(array('id' => $id, 'row' => $index)); ?>
                    </tr>
                <?php
                endif; 
                ?>
            </tbody>
        </table>
        <p class="agp-actions">
            <a class="button agp-add-row" href="javascript:void(0);">Add New</a>
        </p>    
    </div>
<?php
endif;