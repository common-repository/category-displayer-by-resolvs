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
    <div class="catdisp-box" >
        <?php
            $categories = get_terms(
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

            if(!empty($categories) && !is_wp_error( $categories ) ){ 
                $categ_imgs = array();
                if(isset($settings['categ_imgs']) && !empty($settings['categ_imgs']) ){
                    $categ_imgs = json_decode(stripslashes($settings['categ_imgs']),1);
                }
                
                $img_class = '';
                if( isset($settings['_catdisp-img_img-alignment']) && !empty($settings['_catdisp-img_img-alignment']) ){
                    $img_class .= ' float-'.$settings['_catdisp-img_img-alignment'];
                }

                $catdisp_img_c_class = ( strpos($img_class, 'float-none') !==false )?'text-center':'';
                $img_class .= ( strpos($img_class, 'float-none') !==false )? ' mx-auto':'';
                
                echo '<div class="row">';
                foreach($categories as $key => $category){
                    if(array_key_exists($category->term_id, $categ_imgs) && $categ_imgs[$category->term_id] !=''){
                    $img_id = $categ_imgs[$category->term_id];
                    }
                    else{
                        $img_id = get_term_meta ( $category->term_id, 'categdisp_img_id', true );
                    }
                    if($eq_height){
                        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">';
                            echo '<div class="d-flex flex-column h-100">';
                                echo '<a class="catdisp-inbox d-block h-100" href="'.get_term_link($category->term_id).'">';
                                    echo '<div class="d-table w-100 h-100">';
                                        echo '<div class="d-table-cell align-middle">';
                                            echo '<div class="catdisp-img-container '.$catdisp_img_c_class.'">';
                                                if($img_id){
                                                    $img_data = wp_get_attachment_image_src($img_id, 'thumbnail');
                                                    echo '<img src="'.$img_data[0].'" class="catdisp-img '.$img_class.'">';
                                                    echo '<div class="clearfix"></div>';
                                                }
                                            echo '</div>';
                                            echo '<h4 href="'.get_term_link($category->term_id).'" class="catdisp-title">'.$category->name.'</h4>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</a>';  
                            echo '</div>';
                        echo '</div>';
                    }
                    else{
                        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">';
                            echo '<a class="catdisp-inbox d-block" href="'.get_term_link($category->term_id).'">';
                                echo '<div class="catdisp-img-container '.$catdisp_img_c_class.'">';
                                if($img_id){
                                    $img_data = wp_get_attachment_image_src($img_id, 'thumbnail');
                                    echo '<img src="'.$img_data[0].'" class="catdisp-img '.$img_class.'">';
                                    echo '<div class="clearfix"></div>';
                                }
                                echo '</div>';
                                echo '<h4 href="'.get_term_link($category->term_id).'" class="catdisp-title">'.$category->name.'</h4>';
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