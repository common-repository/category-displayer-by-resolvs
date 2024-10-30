<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>

<div class="wrap wrap-categs-shortcodes">
    <h2></h2>

<?php
if( isset($_GET['action']) && ($_GET['action']=='edit') ){
    require_once('shortcodes-add-edit.php');
}
else{ ?>
    <!-- View shortcodes -->
    <h1 class="wp-heading-inline"><?php  _e( 'Shortcodes', $plugin_name );?></h1> 
    <a href="admin.php?page=<?php echo $shortcodes_create;?>" class="page-title-action"><?php  _e( 'Create New Shortcode', $plugin_name );?></a>
    <?php
    $shortcodes = new Category_Displayer_List();
    ?>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-1">
            <div id="categs-shortcode-view">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <?php
                        $shortcodes->prepare_items();
                        $shortcodes->display(); ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>

<?php    
}
?>

</div>