<?php
    $id = isset($params['id']) ? $params['id'] : NULL;
    $row = isset($params['row']) ? $params['row'] : 0;
    $data = !empty($params['data']) ? $params['data'] : NULL;
    if (!empty($id)) :
?>
<td>
    <input class="widefat" type="text" value="<?php echo !empty($data['title']) ? $data['title'] : '' ;?>" id="<?php echo "{$id}_data_{$row}_title";?>" name=<?php echo "{$id}_data[{$row}][title]";?> />    
</td>
<td>
    <input class="widefat" type="text" value="<?php echo !empty($data['description']) ? $data['description'] : '' ;?>" id="<?php echo "{$id}_data_{$row}_description";?>" name=<?php echo "{$id}_data[{$row}][description]";?> />    
</td>
<td class="tbl-actions">
    <a class="button agp-del-row" href="javascript:void(0);">Delete</a>
</td>                
<?php 
    endif;
