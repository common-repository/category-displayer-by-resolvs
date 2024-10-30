<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="input-group<?php echo ' '.esc_attr($_POST['data']['class']);?><?php echo (esc_attr($_POST['data']['has-hover'])=='1')?' has-hover':'';?>">
    <label class="form-label element-title <?php echo (esc_attr($_POST['data']['type'])=='icon_picker' || esc_attr($_POST['data']['type'])=='image-align')?'d-none':'';?>">
        <?php echo esc_attr($_POST['data']['label']);?>

       

        <?php if(isset($_POST['data']['tooltip']) && $_POST['data']['tooltip'] !=''){ ?>
        <span class="categdisp_hover_settings">
            <a class="categdisp_settings_tooltip">?</a>
        </span>
        <p class="categdisp_hover_info my-0 d-none"><small><?php echo esc_html($_POST['data']['tooltip']);?></small></p>
        <?php } ?>
        
    </label>
    <div class="form-control-holder catdisp-font-family">
    <?php
	 if(isset($_POST['data']['enable_googlefonts']) && $_POST['data']['enable_googlefonts']){
        echo '<select data-fieldname="'.esc_attr($_POST['data']['name']).'" name="rscdForm['.esc_attr($_POST['data']['name']).']" class="form-control w-100 fontfamily-sel2">';
            $json_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyArTrahADnC9G8Ck447fIANH810O5nLQlk&sort=popularity';
            $get_json = file_get_contents($json_url, false);
            $json = json_decode($get_json, false);
            // echo '<pre>'.print_r($json,1).'</pre>';
            if($json->items){
                $items = $json->items;
                echo '<option value="inherit">Use theme default</option>';
                foreach($items as $font){
                    if($font->variants){
                        $font_variants = $font->variants;
                        foreach($font_variants as $font_variant){
                            if(strpos($font_variant,'italic')!== false){continue;}
                            echo '<option value="'.$font->family.'##'.$font_variant.'">'.$font->family.' '. $font_variant.'</option>';
                        }
                    }
                    else{
                        echo '<option value="'.$font->family.'">'.$font->family.'</option>';
                    }
                }
            }
    }
    else{
        echo '<select data-fieldname="'.esc_attr($_POST['data']['name']).'" name="rscdForm['.esc_attr($_POST['data']['name']).']" class="form-control w-100 fontfamily-sel2">';
        echo '<option value="inherit">Use theme default</option>';
        echo '</select>';
    }
        
    ?>

    </div>
</div>