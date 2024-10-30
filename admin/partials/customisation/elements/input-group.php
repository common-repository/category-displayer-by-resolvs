<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="input-group<?php echo ' '.esc_attr($_POST['data']['class']);?><?php echo ($_POST['data']['has-hover']=='1')?' has-hover':'';?>">
    <label class="form-label element-title <?php echo ($_POST['data']['type']=='icon_picker' || $_POST['data']['type']=='image-align')?'d-none':'';?>">
        <?php echo esc_attr($_POST['data']['label']);?>

        <?php if($_POST['data']['has-hover']=='1'){ ?>
        <span class="categdisp_hover_settings">
            <a class="categdisp_hover no-wrap"><i class="fas fa-mouse-pointer"></i>Hover</a>
        </span>
        <?php } ?>

        <?php if(isset($_POST['data']['tooltip']) && $_POST['data']['tooltip'] !=''){ ?>
        <span class="categdisp_hover_settings">
            <a class="categdisp_settings_tooltip">?</a>
        </span>
        <p class="categdisp_hover_info my-0 d-none"><small><?php echo esc_attr($_POST['data']['tooltip']);?></small></p>
        <?php } ?>
        
    </label>
    <div class="form-control-holder <?php echo ($_POST['data']['type']=='input_toggl')?'form-control border-0 on-off-radio':'';?>">
    <?php

    switch($_POST['data']['type']){
        case 'select':
            // echo '<pre>'.print_r($_POST['data']['values'],1).'</pre>';
            echo '<select data-fieldname="'.esc_attr($_POST['data']['name']).'" name="rscdForm['.esc_attr($_POST['data']['name']).']" class="form-control w-100">';

            if(!empty($_POST['data']['values'])){
                foreach($_POST['data']['values'] as $key => $option){
                    echo '<option value="'.(esc_attr($key)?:'').'">'.esc_attr($option).'</option>';
                }
            }
            echo '</select>';
            break;

        case 'input_text':
            echo '<input type="text" data-fieldname="'.esc_attr($_POST['data']['name']).'" name="rscdForm['.esc_attr($_POST['data']['name']).']" class="form-control">';
            break;

        case 'input_color':
            echo '<input type="text" data-fieldname="'.esc_attr($_POST['data']['name']).'" name="rscdForm['.esc_attr($_POST['data']['name']).']" class="form-control cpa-color-picker"  data-alpha="true">';
            break;
        
        case 'font-style': ?>
            <ul class="radio-checkbox-img m-0 form-label">
                <li  class="form-control border-0">
                    <label>
                        <input type="checkbox" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>font-style" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>font-style]" value="italic">
                        <div class="text-white" style="font-style: italic;">t</div>
                    </label>
                </li>
                <li  class="form-control border-0">
                    <label>
                        <input type="checkbox" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>text-decoration" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>text-decoration]" value="underline">
                        <div class="text-white" style="text-decoration: underline;">t</div>
                    </label>
                </li> 
                <li  class="form-control border-0">
                    <label>
                        <input type="checkbox" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>text-decoration" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>text-decoration]" value="line-through">
                        <div class="text-white" style="text-decoration: line-through;">t</div>
                    </label>
                </li>
            </ul>
            <?php break;

        case 'text-alignment': ?>
            <ul class="radio-checkbox-img m-0 form-label">
                <li class="form-control border-0">
                    <label>
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['name']); ?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']); ?>]" value="left">
                        <div alt="f206" class="dashicons dashicons-editor-alignleft text-white"></div>
                    </label>
                </li>
                <li class="form-control border-0">
                    <label>
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['name']); ?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']); ?>]" value="center">
                        <div alt="f207" class="dashicons dashicons-editor-aligncenter text-white"></div>
                    </label>
                </li>
                <li class="form-control border-0">
                    <label>
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['name']); ?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']); ?>]" value="right">
                        <div alt="f208" class="dashicons dashicons-editor-alignright text-white"></div>
                    </label>
                </li>
                <li class="form-control border-0">
                    <label>
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['name']); ?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']); ?>]" value="justify">
                        <div alt="f214" class="dashicons dashicons-editor-justify text-white"></div>
                    </label>
                </li>
            </ul>
        <?php break;

        case 'input_toggl': ?>
            <div class="toggl-input mx-0">
                <input type="checkbox" data-fieldname="<?php echo esc_attr($_POST['data']['name']);?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']);?>]" value="<?php echo esc_attr($_POST['data']['values']);?>" class="toggl-input-checkbox <?php echo($_POST['data']['has_slider']=='1')?'settings_has_slidedown':'';?>" 
                data-slidedown="<?php echo esc_attr($_POST['data']['slide_down']);?>" id="<?php echo esc_attr($_POST['data']['name']);?>" tabindex="0">
                <label class="toggl-input-label" for="<?php echo esc_attr($_POST['data']['name']);?>"></label>
            </div>
        
        <?php  break;

        case 'icon_picker':?>
            <div class="iconpicker-container">
                <input data-placement="bottomRight" value="" autocomplete="off" class="icp icp-auto w-100 icp-single_categs" placeholder="Choose an icon"  type="text" data-fieldname="<?php echo esc_attr($_POST['data']['name']);?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']);?>]"/>
                <span class="input-group-addon"></span>
            </div>
        <?php break;

        case 'image-align': ?>
            <ul class="radio-checkbox-img m-0">
                <li>
                    <label>
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['name']);?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']);?>]" value="left">
                        <div class="text-white text-center image-alignment image-alignment_left">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" class=""></path>
                            </svg>
                        </div>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['name']);?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']);?>]" value="none">
                        <div class="text-white text-center image-alignment image-alignment_center">
                            <svg id="Component_88_1" data-name="Component 88 – 1" xmlns="http://www.w3.org/2000/svg" width="12.659" height="22.179" viewBox="0 0 16.659 26.179">
                                <rect id="Rectangle_213" data-name="Rectangle 213" width="22.179" height="12.659" rx="2" transform="translate(2 24.179) rotate(-90)" fill="#fff"></rect>
                            </svg>
                        </div>
                    </label>
                </li>
                <li>
                    <label>
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['name']);?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']);?>]" value="right">
                        <div class="text-white text-center image-alignment image-alignment_right">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="currentColor" d="M313.941 216H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12h301.941v46.059c0 21.382 25.851 32.09 40.971 16.971l86.059-86.059c9.373-9.373 9.373-24.569 0-33.941l-86.059-86.059c-15.119-15.119-40.971-4.411-40.971 16.971V216z" class=""></path>
                            </svg>
                        </div>
                    </label>
                </li>
            </ul>
        <?php break;

        case 'single_image': ?>
            <a href="#" class="categdisp-upl">Upload image</a>
            <a href="#" class="categdisp-rmv" style="display:none">Remove image</a>
            <input type="hidden" data-fieldname="<?php echo esc_attr($_POST['data']['name']);?>" name="rscdForm[<?php echo esc_attr($_POST['data']['name']);?>]" value="" class="categdisp_single_image">
        <?php break;

        default:

    }
?>


    </div>
</div>