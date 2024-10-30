<?php if ( ! defined( 'ABSPATH' ) ) exit; 
$is_edit = false;

$id = sanitize_text_field($_GET['ID']);
if(isset($_GET['action']) && $_GET['action']=='edit'){
    if(isset($_GET['ID']) && $_GET['ID']!=''){
        global $wpdb;

        $get_shortcode = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}categs_shortcodes WHERE ID = %d", $id ), OBJECT );
        
        if(!empty($get_shortcode)){
            $is_edit = true;
            $saved_settings = unserialize(($get_shortcode->settings));
        }
        else{
            echo '<p>'.__('Wrong shortcode ID', $this->plugin_name).'</p>';
            exit;
        }
    }
    else{
        echo '<p>'.__('Empty shortcode ID', $this->plugin_name).'</p>';
        exit;
    }
}
?>

<div class="wrap wrap-categs-shortcodes">
    <h2></h2>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-1">
            <div id="validate-shortcode-submit" class="notice">
                
            </div>

            <?php $is_error = ''; ?>

            <form action="<?php echo 'admin.php?page='.$shortcodes_view;?>" method="POST" id="categdisp_shortcode">
                <div class="flex-row flex-column-w1400">
                    <div class="flex-column flex-basis-0">

                        <!-- Shorcode name -->
                        <section>
                            <h2 class="wp-heading-inline"><?php  _e( 'Shortcode name', $plugin_name );?></h2>
                            <div class="flex-row">
                                <div class="flex-column">
                                <div class="box-card bg-white radius-10 grey-box-shadow">
                                        <div class="p-0">
                                            <input type="text" id="catdis-short-title" name="rscdForm[title]" class="bg-white border-0 w-100 input-lg radius-10" value="<?php echo $is_edit?$get_shortcode->title:'' ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!--Select category or sub category to be displayed -->
                        <section>
                            <h2 class="wp-heading-inline"><?php  _e( 'Select category or sub category to be displayed', $plugin_name );?></h2>
                            <div class="flex-row flex-column-w782">
                                <div class="flex-column col-2-3 full-col-w782">
                                    <div class="box-card bg-white radius-10 grey-box-shadow h-100">
                                        <div class="headline bg-yellow text-white font-weight-600 px-15"><?php  _e('Categories settings', $plugin_name );?> </div>
                                        <div class="taxonomy-list p-15" id="split_taxonomies">

                                        <?php
                                        $args = array(
                                            'public'   => true,
                                            'show_ui' => '1',
                                            'object_type' => ['post'],
                                        );
                                       
                                        $args = apply_filters('catdisp_filter_taxonomies_arguments', $args);
                                        
                                        $get_taxonomies = get_taxonomies($args, 'objects');
                       
                                        if( !empty($get_taxonomies) ){
                                            
                                            echo '<label class="pr-15">Choose Taxonomy</label>';
                                            echo '<select name="rscdForm[categdisp_taxonomy]" id="categdisp_taxonomy">';
                                                echo '<option value="">Choose one</option>';
                                                foreach($get_taxonomies as $tax_name => $get_tax){
                                                    if($tax_name == $saved_settings['categdisp_taxonomy']){
                                                        $selected = 'selected="selected"';
                                                       
                                                    }
                                                    else{
                                                        $selected = '';
                                                    }
                                                    echo '<option value="'.$tax_name.'" '.$selected.'>'.$get_tax->label.'</option>';
                                                }
                                            echo '</select>';
                                        }
                                        else{
                                            echo 'No taxonomy was found';
                                        }

                                        if($is_edit){
                                            $allow_taxonomy = true;
                                            $allow_taxonomy = apply_filters('catdisp_edit_allow_taxonomy',$saved_settings['categdisp_taxonomy']);
                                           
                                            if($allow_taxonomy != '1'){
                                                $tax_not_allowed = apply_filters('catdisp_edit_taxonomy_not_allowed', '');
                                                $is_error .= '<p class="error">'.$saved_settings['categdisp_taxonomy'].' '.$tax_not_allowed.'</p>';
                                            }
                                            $allow_template = true;
                                            $allow_template = apply_filters('catdisp_edit_allow_template',$get_shortcode->tpl_id);
                                           
                                            if($allow_template != '1'){
                                                $template_not_allowed = apply_filters('catdisp_edit_template_not_allowed', '');
                                                $is_error .= '<p class="error">'.$get_shortcode->tpl_id.' '.$template_not_allowed.'</p>';
                                            }

                                        }


                                        ?>
                                        </div>
                                        <div class="categs-list">
                                            <?php  if( !empty($get_taxonomies) ){ ?>
                                                <label>
                                                    <input type="radio" name="rscdForm[categs_settings]" value="cat" <?php if($is_edit){checked('cat',$saved_settings['categs_settings']);}?>>
                                                    Display categories
                                                </label>
                                                <label>
                                                    <input type="radio" name="rscdForm[categs_settings]" value="sub-cat" <?php if($is_edit){checked('sub-cat',$saved_settings['categs_settings']);}?>>
                                                    Display sub-categories
                                                </label>

                                                <div id="categs_settings">
                                                <?php
                                                if($is_edit && $is_error==''){
                                                    if(!empty($saved_settings['select_categs'])){
                                                        $select_categs = $saved_settings['select_categs'];
                                                        $Category_Displayer_Admin = new Category_Displayer_Admin($plugin_name, $version, $plugin_dir_path, $plugin_dir_url);

                                                        $generate_dropdown_args = array(
                                                            'type' => $saved_settings['categs_settings'],
                                                            'taxonomy' => $saved_settings['categdisp_taxonomy']
                                                        );
                                                        $select_taxonomy = $Category_Displayer_Admin->hierarchical_dropdown_taxonomy($generate_dropdown_args);

                                                        foreach($select_categs as $category){
                                                            $select_taxonomy = str_replace( 'value="'.$category.'"',  'value="'.$category.'" selected="selected"', $select_taxonomy );

                                                        }
                                                        echo $select_taxonomy;
                                                    }
                                                }
                                                ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-column col-1-3 full-col-w782">
                                    <div class="box-card">
                                        <div class="headline text-black font-weight-600 "><?php _e( 'Display order', $plugin_name );?></div>
                                        <div class="categs-list display-order">
                                           <ul class="checkbox-holder m-0 p-0">
                                                <li class="checkbox-holder text-black">
                                                    <input id="date-ASC" type="radio" value="date_asc" name="rscdForm[order]" <?php if($is_edit && isset($saved_settings['order'])){checked('date_asc',$saved_settings['order']);}?>>
                                                    <label for="date-ASC"><?php _e( 'Chronological ASC', $plugin_name );?></label>
                                                </li>
                                                <li class="checkbox-holder text-black">
                                                    <input id="name-ASC" type="radio" value="name" name="rscdForm[order]" <?php if($is_edit && isset($saved_settings['order'])){checked('name',$saved_settings['order']);}?>">
                                                    <label for="name-ASC"><?php _e( 'Alphabetical', $plugin_name );?></label>
                                                </li>
                                                <li class="checkbox-holder text-black">
                                                    <input id="date-DESC" type="radio" value="date_desc" name="rscdForm[order]" <?php if($is_edit && isset($saved_settings['order'])){checked('date_desc',$saved_settings['order']);}?>>
                                                    <label for="date-DESC"><?php _e( 'Chronological DESC', $plugin_name );?></label>
                                                </li>
                                                <li class="checkbox-holder text-black">
                                                    <input id="order-RAND" type="radio" value="rand" name="rscdForm[order]" <?php if($is_edit && isset($saved_settings['order'])){checked('rand',$saved_settings['order']);}?>>
                                                    <label for="order-RAND"><?php _e( 'Random', $plugin_name );?></label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section><!--end Select category or sub category to be displayed -->
                    </div>

                    <div class="flex-column flex-basis-0">
                        <!--Layout options-->
                        <section>
                            <h2 class="wp-heading-inline d-inline-block"><?php  _e( 'Layout options', $plugin_name );?> </h2>
                            <div class="flex-row">
                                <div class="flex-column">
                                    <div class="box-card bg-white radius-10 grey-box-shadow layout-templates-holder">
                                        <div class="p-15">
                                        <?php
                                            $installed_tpl_multidim = array( 'free' => array(), 'pro' => array() );

                                            $installed_tpl_multidim['free'] = get_option('catdisp_templates');
                                            $installed_tpl_multidim = apply_filters('catdisp_filter_pro_templates', $installed_tpl_multidim);
                                            $installed_tpl = array();
                                            $installed_tpl = array_merge($installed_tpl_multidim['free'], $installed_tpl_multidim['pro']);
                                            $is_slider = false;
                                            ?>
                                            <div class="flex-row layout-templates <?php if(count($installed_tpl)>2){echo 'templates-slideshow';$is_slider=true;}?>">
                                            <?php
                                            $template_allowed = true;
                                            if($is_edit && !in_array($get_shortcode->tpl_id, $installed_tpl) ){
                                                $template_allowed = apply_filters('catdisp_shortcode_allow_pro', $get_shortcode->tpl_id);
                                            }

                                            if( !$template_allowed ){
                                                $installed_tpl_pro = get_option('catdisp_templates_pro');
                                                
                                                if($installed_tpl_pro !==false ){
                                                    /* PRO template set without a license */
                                                    if(array_key_exists($get_shortcode->tpl_id, $installed_tpl_pro)){
                                                        $template_url = str_replace($plugin_name,$plugin_name.'-pro', $plugin_dir_url);
                                                        ?>
                                                        <div class="flex-column flex-basis-0 col-1-2 layout-template active">
                                                            <div class="shortcode-template unavailable-theme">
                                                                <div class="flex-column">
                                                                    <img src="<?php echo $template_url.'templates/'.$get_shortcode->tpl_id.'/screenshot.png';?>" class="radius-7 grey-box-shadow">
                                                                </div>
                                                            </div>
                                                            <div class="flex-row flex-column-w1400 unavailable-theme">
                                                                <div class="flex-column">
                                                                    <h3 class="layout-name d-inline-block"><?php echo $installed_tpl_pro[$get_shortcode->tpl_id]['title'];?></h3>
                                                                </div>
                                                                <div class="flex-column">
                                                                    <label class="use-layout alignright radius-3 d-inline-block text-white bg-yellow grey-box-shadow no-wrap btn-sm cursor-pointer"
                                                                        data-tpl_id="<?php echo $get_shortcode->tpl_id;?>"
                                                                        data-tpl_cust="<?php echo htmlspecialchars(json_encode($installed_tpl_pro[$get_shortcode->tpl_id]['cust']), ENT_QUOTES, 'UTF-8');?>"
                                                                        data-tpl_default="<?php echo htmlspecialchars(json_encode($installed_tpl_pro[$get_shortcode->tpl_id]['default']), ENT_QUOTES, 'UTF-8');?>"
                                                                        >
                                                                        <?php echo __('Use this layout',$this->plugin_name);?>
                                                                    </label>
                                                                    <input type="radio" class="d-none" value="<?php echo $get_shortcode->tpl_id;?>" name="rscdForm[tpl_id]" data-tpl_type="<?php echo $saved_settings['type'];?>" disabled>
                                                                </div>
                                                            </div>
                                                            <p class="text-red">
                                                            <?php 
                                                            $Category_Displayer_Admin = new Category_Displayer_Admin($plugin_name, $version, $plugin_dir_path, $plugin_dir_url);
                                                            do_action('catdisp_unavailable_template', array($Category_Displayer_Admin,'catdisp_unavailable_template_callback'));
                                                            ?></p>
                                                            <div class="clear"></div>
                                                        </div> 
                                                    
                                                    

                                                    <?php
                                                    }
                                                }
                                            }

                                            if (!empty($installed_tpl)) {
                                                    
                                                uasort($installed_tpl, function($a, $b) {
                                                    return $a['order'] <=> $b['order'];
                                                });
                                                foreach ($installed_tpl as $tpl_id => $tpl) {
                                                    if ($is_edit) {
                                                
                                                        if ($get_shortcode->tpl_id == $tpl_id) {
                                                            $layout_boxes = $installed_tpl[$tpl_id]['cust'];
                                                            $active = 'active';
                                                            $checked = 'checked="checked"';
                                                        } else {
                                                            $active = '';
                                                            $checked = '';
                                                        }
                                                    } 
                                                
                                                    /* Is free template of pro */
                                                    if(array_key_exists($tpl_id,$installed_tpl_multidim['pro']) && defined('CATEGORY_DISPLAYER_PRO_DIR_URL')){
                                                        $assets_url = CATEGORY_DISPLAYER_PRO_DIR_URL;
                                                        $tpl_type = 'pro';
                                                    }
                                                    else{
                                                        $assets_url = $plugin_dir_url;   
                                                        $tpl_type = 'free';
                                                    }
                                                    ?>
                                                    
                                                    <div class="flex-column flex-basis-0 col-1-2 layout-template <?php echo $is_edit?$active:'';?>">
                                                        <div class="shortcode-template">
                                                            <div class="flex-column">
                                                                <img src="<?php echo $assets_url.'templates/'.$tpl_id.'/screenshot.png';?>" class="radius-7 grey-box-shadow">
                                                            </div>
                                                        </div>
                                                        <div class="flex-row flex-column-w1400">
                                                            <div class="flex-column">
                                                                <h3 class="layout-name d-inline-block"><?php echo $tpl['title'];?></h3>
                                                            </div>
                                                            <div class="flex-column">
                                                                <label class="use-layout alignright radius-3 d-inline-block text-white bg-yellow grey-box-shadow no-wrap btn-sm cursor-pointer"
                                                                    data-tpl_id="<?php echo $tpl_id;?>"
                                                                    data-tpl_cust="<?php echo htmlspecialchars(json_encode($tpl['cust']), ENT_QUOTES, 'UTF-8');?>"
                                                                    data-tpl_default="<?php echo htmlspecialchars(json_encode($tpl['default']), ENT_QUOTES, 'UTF-8');?>"
                                                                    >
                                                                    <?php echo __('Use this layout',$this->plugin_name);?>
                                                                </label>
                                                                <input type="radio" class="d-none" value="<?php echo $tpl_id;?>" name="rscdForm[tpl_id]" <?php echo $is_edit?$checked:'';?> data-tpl_type="<?php echo $tpl_type;?>">
                                                            </div>
                                                        </div>
                                                        <p><?php echo $tpl['desc'];?></p>
                                                        <div class="clear"></div>
                                                    </div> 
                                                <?php
                                                }
                                            } 
                                            else {
                                                echo '<div class="flex-column flex-basis-0">';
                                                echo '<p> '.__('There are no templates installed', $this->plugin_name). '</p>';
                                                echo '<p>Go ahead and <a href="admin.php?page='.$shortcodes_library.'">'.__('install your first template', $this->plugin_name). '</a> from our template library.</p>';
                                                echo '</div>';
                                            }
                                            
                                            ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- END Layout options-->
                    </div>
                </div>

                <div class="flex-row flex-column-w1400">
                    <div class="flex-column flex-basis-0">
                        <div class="shortcodes-customisation left-customisation children">
                            <?php
                                // require_once('customisation/1-customise-text.php');
                                // require_once('customisation/2-customise-box.php');
                                // require_once('customisation/3-customise-image.php');
                                // require_once('customisation/4-customise-button.php');
                                // require_once('customisation/5-customise-inbox.php');
                            ?>
                            </div>
                        </div>
                    <div class="flex-column flex-basis-0">
                        <div class="shortcodes-customisation right-customisation children">
                        </div>
                    </div>
                </div>

                <div class="flex-row shortcode-footer-setion flex-column-w1400">
                    <div class="flex-column flex-basis-0">
                        <?php if($is_edit){ ?>
                            <!--Copy paste shortcode-->
                            <section>
                                <h2 class="wp-heading-inline d-inline-block"><?php  _e( 'Shortcode', $plugin_name );?> <span class="font-weight-400"><?php  _e( '(copy and paste the code below to your page)', $plugin_name );?></span></h2>
                                <div class="flex-row">
                                    <div class="flex-column">
                                        <div class="box-card bg-white radius-10 grey-box-shadow">
                                            <div class="p-0">
                                                <div class="flex-row">
                                                    <div class="flex-column">
                                                        <input type="text" id="categs-shortcode-value" class="alignleft bg-white border-0 input-lg w-100" value='[category_displayer id="<?php echo $get_shortcode->ID;?>"]'>
                                                    </div>
                                                    <div class="flex-column flex-grow-0">
                                                        <a id="copy-shortcode" class="bg-yellow radius-10 text-white grey-box-shadow d-inline-block alignright no-wrap btn-lg cursor-pointer"><?php  _e( 'Copy shortcode', $plugin_name );?></a>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>  <!-- END Copy paste shortcode -->
                            <?php } ?>
                        </div>
                    <div class="flex-column flex-basis-0">
                        <!-- Save -->
                        <section>
                            <h2 class="opacity-0">Reset/Preview/Save</h2>
                            <input type="hidden" name="action" value="<?php echo $is_edit?'edit_shortcode':'add_shortcode';?>">
                            <input type="hidden" name="catdisp_security" value="<?php echo wp_create_nonce("catdisp_save_nonce");?>">
                            <input type="hidden" name="rscdForm[layout_boxes]" id="layout_boxes" value="<?php if($is_edit){echo stripslashes(htmlspecialchars(json_encode($layout_boxes), ENT_QUOTES, 'UTF-8'));} else{ echo htmlspecialchars(json_encode(array("text","box")), ENT_QUOTES, 'UTF-8'); }?>">
                            <?php
                            if($is_edit){
                                $saved_settings_js = $saved_settings;
                                unset($saved_settings_js['categdisp_taxonomy']);
                                unset($saved_settings_js['categs_settings']);
                                unset($saved_settings_js['select_categs']);
                                unset($saved_settings_js['taxonomy']);
                                unset($saved_settings_js['catdisp_security']);
                                unset($saved_settings_js['order']);
                                echo '<input type="hidden" id="saved_settings" name="rscdForm[saved_settings]" value="'.htmlspecialchars(json_encode($saved_settings_js), ENT_QUOTES, 'UTF-8').'">';
                                echo '<input type="hidden" id="shortcode_id" name="rscdForm[shortcode_id]" value="'.$get_shortcode->ID.'">';
                                
                            }
                            ?>
                            <input type="hidden" id="is_error" name="rscdForm[is_error]" value='<?php echo $is_error;?>'>
                            <button type="submit" class="text-white bg-yellow radius-10 grey-box-shadow alignright no-wrap btn-lg border-0  font-weight-600" ><?php  _e( 'Save settings', $plugin_name );?><span class="catdisp-load"></span></button>
                            <button type="button" class="text-white bg-yellow radius-10 grey-box-shadow no-wrap btn-lg border-0 alignright cursor-pointer shortcode-preview  font-weight-600">Preview<span class="catdisp-load"></span></button>
                            <button type="button" class="no-wrap btn-lg border-0 alignright cursor-pointer shortcode-reset-style  font-weight-600">Reset Style<span class="catdisp-load"></span></button>
                            <div class="clear"></div>
                        </section>
                    </div>
                </div>
                    
            </form>
            <!--preview modal-->
            <section class="preview-modal">
                <div class="preview-modal-body bg-white radius-10 grey-box-shadow">
                    <div class="preview-modal-content"></div>
                    <div class="preview-modal-footer"><button type="button" class="text-white bg-yellow radius-10 grey-box-shadow no-wrap btn-lg border-0 alignright cursor-pointer shortcode-preview-close">Close</button></div>
                </div>
            </section>
            <!--end preview modal-->
        </div>
        <br class="clear">
    </div>

</div>

<?php
if(function_exists('add_thickbox')) { add_thickbox(); }

?>
<div id="modal_preview_shortcode" style="display:none;"></div>
