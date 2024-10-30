<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/* WP_Term_Query order/orderby attributes */
$order = 'ASC';   
if(isset($settings['order'])){
    switch($settings['order']){
        case 'name':
            $orderby = 'name';
            break;
        case 'date_desc':
            $orderby = 'date';
            $order = 'DESC';
            break;
        default: 
            $orderby = 'date';
    }    
}
else{
    $orderby = 'date';
}
?>


<div id="catdisp-<?php echo (isset($settings['id'])?$settings['id']:'admin-view');?>">
    <div class="catdisp-box">
        <?php
            $categories    = get_terms(
                array(
                    'taxonomy'    => $settings['categdisp_taxonomy'],
                    'include'     => array_values($settings['select_categs']),
                    'hide_empty'  => false,
                    'orderby' => $orderby,
                    'order' => $order,
                )
            );

            // Randomize Term Array if orderby = Random
            if(isset($settings['order']) && $settings['order']=='rand'){
                shuffle( $categories );
            }

            /* Check if columns need to have same height*/
            $eq_height = false;
            if(isset($settings['_catdisp-inbox_eq-col-height']) && $settings['_catdisp-inbox_eq-col-height']=='1'){
                $eq_height = true;
            }

            if(!empty($categories)  && ! is_wp_error( $categories ) ){ 
                $categ_icons = array();
                if(isset($settings['categ_icons']) && !empty($settings['categ_icons']) ){
                    $categ_icons = json_decode(stripslashes($settings['categ_icons']),1);
                }
                echo '<div class="row">';
                foreach($categories as $key => $category){
                    if(array_key_exists($category->term_id, $categ_icons) && $categ_icons[$category->term_id] !=''){
                        $fa_icon = $categ_icons[$category->term_id];
                    }
                    else{
                        $fa_icon = get_term_meta ( $category->term_id, 'categdisp_icon', true );
                    }
                    if( $eq_height ){
                        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">';
                            echo '<div class="d-flex flex-column h-100">';
                                echo '<a class="catdisp-inbox d-block h-100" href="'.get_term_link($category->term_id).'">';
                                    echo '<div class="d-table w-100 h-100">';
                                        echo '<div class="d-table-cell align-middle">';
                                            echo '<div class="catdisp-icon"><i class="'.$fa_icon .'"></i></div>';
                                            echo '<h4 class="catdisp-title">'.$category->name.'</h4>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</a>';  
                            echo '</div>';
                        echo '</div>';
                    }
                    else{
                        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">';
                            echo '<a class="catdisp-inbox d-block" href="'.get_term_link($category->term_id).'">';
                                echo '<div class="catdisp-icon"><i class="'.$fa_icon .'"></i></div>';
                                echo '<h4 class="catdisp-title">'.$category->name.'</h4>';
                            echo '</a>';  
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            elseif(is_wp_error( $categories )){
                echo 'An error occured! Message: '.$categories->get_error_message();
            }
        ?>
    </div>
</div>