<?php 
    $args = $params;
    $label = !empty($args->fields['fields'][$args->field]['label']) ? $args->fields['fields'][$args->field]['label'] : '';
    $class = !empty($args->fields['fields'][$args->field]['class']) ? $args->fields['fields'][$args->field]['class'] : ''; 
    $note = !empty($args->fields['fields'][$args->field]['note']) ? $args->fields['fields'][$args->field]['note'] : '';
    $atts = !empty($args->fields['fields'][$args->field]['atts']) ? $args->fields['fields'][$args->field]['atts'] : '';
    if (is_array($atts)) {
        $atts_s = '';
        foreach ($atts as $key => $value) {
            $atts_s .= $key . '="' . $value . '"';
        }
        $atts = $atts_s;
    }
    
    $list = $args->fieldSet[$args->fields['fields'][$args->field]['fieldSet']];
?>
<tr>
    <th scope="row"><?php echo $label;?></th>
    <td>
        <select <?php echo $atts;?><?php echo !empty($class) ? ' class="'.$class.'"': '';?> id="<?php echo "{$args->key}[{$args->field}]"; ?>" name="<?php echo "{$args->key}[{$args->field}]"; ?>" >
            <?php 
                foreach( $list as $k => $v ):
                    $selected = !empty($args->data[$args->field]) && $args->data[$args->field] == $k;
            ?>
                    <option value="<?php echo $k; ?>"<?php selected( $selected );?>><?php echo $v;?></option>
            <?php 
                endforeach; 
            ?>
        </select>
        <?php if (!empty($note)): ?><p class="description"><?php echo $note;?></p><?php endif;?>
    </td>
</tr>    