<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>

<div class="wrap wrap-categs-shortcodes">
    <h2></h2>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">

            <h1 class="wp-heading-inline"><?php  _e( 'Settings', $plugin_name );?></h1>

            <section>
                <form method="POST" id="categdisp_settings" action="">
                    <?php
                    $get_settings = get_option('catdisp_general_settings');
                    $custom_css = '';
                    if($get_settings){
                        $get_settings = maybe_unserialize($get_settings);
                    }


                    do_action('catdisp_extra_settings_fields');
                    ?>
                                            
                    <!-- Google Fonts -->
                    <div class="flex-row mb-20 mt-30">
                        <div class="flex-column fixed-column-w">
                            <label class="font-weight-600 lg-label"><?php  _e( 'Google fonts', $plugin_name );?></label>
                        </div>
                        <div class="flex-column">
                            <div class="onoffswitch">
                                <input type="checkbox" name="enable-googlefonts" class="onoffswitch-checkbox" id="enable-googlefonts" value="1" tabindex="0"
                                <?php if(isset($get_settings['enable-googlefonts']) && $get_settings['enable-googlefonts']=='1'){echo 'checked';} ?> >
                                <label class="onoffswitch-label" for="enable-googlefonts"></label>
                            </div>
                        </div>
                    </div>
                    <!-- END Google Fonts -->

                    <!-- Bootstrap -->
                    <div class="flex-row mb-10">
                        <div class="flex-column fixed-column-w">
                            <label class="font-weight-600 lg-label"><?php  _e( 'Include bootstrap', $plugin_name );?></label>
                        </div>
                        <div class="flex-column">
                            <div class="onoffswitch">
                                <input type="checkbox" name="enable-bootstrap" class="onoffswitch-checkbox" id="enable-bootstrap" value="1" tabindex="0"
                                <?php if(isset($get_settings['enable-bootstrap']) && $get_settings['enable-bootstrap']=='1'){echo 'checked';} ?> >
                                <label class="onoffswitch-label" for="enable-bootstrap"></label>
                            </div>
                            <small><?php _e('Whether to include or not bootstrap 4.5 in frontend',$plugin_name);?></small>
                        </div>
                    </div>
                    <!-- END Bootstrap -->

                    <div class="flex-row">
                        <div class="flex-column">
                            <input type="hidden" name="action" value="catdisp_save_general_settings">
                            <a class="border-0 cursor-pointer text-white bg-yellow radius-10 grey-box-shadow no-wrap d-inline-block btn-lg formsubmit"><?php  _e( 'Save settings', $plugin_name );?></a>
                        </div>
                    </div>
                </form>
            </section>

            <section>
                <!-- Uninstall action -->
                <div class="flex-row">
                    <div class="flex-column">
                    <label>
                        <input type="checkbox" id="catdisp_removefiles_ondelete" name="catdisp_removefiles_ondelete" value="true"
                        <?php if(get_option('catdisp_removefiles_ondelete')=='true'){echo 'checked="checked"';} ;?>>
                        <?php  _e( 'Remove all files and database related to the plugin when plugin is being uninstalled.', $plugin_name );?>
                    </label>
                    </div>
                </div>
                <!-- END Uninstall action -->
            </section>

            <?php if ($should_show_pro_banner) { ?>
            <section>
                <!-- Activate PRO version -->
                <div class="flex-row">
                    <!-- <div class="flex-column"> -->
                        <!-- <div class="flex-row">
                            <div class="flex-column">
                                <label class="font-weight-600 lg-label"><?php  //_e( 'Activate PRO version', $plugin_name );?></label>
                            </div>
                        </div> -->
                        <!-- <div class="flex-row"> -->
                            <!-- <div class="flex-column flex-grow-0">
                                <input type="text" class="bg-white border-0 grey-box-shadow radius-10 serial-nb" placeholder="Enter your serial number here" >
                            </div>
                            <div class="flex-column flex-grow-0">
                                <a class="text-white bg-yellow radius-10 grey-box-shadow no-wrap d-inline-block btn-lg" id="activate-license"><?php  //_e( 'Activate', $plugin_name );?></a>
                            </div> -->
                            <div class="flex-column flex-grow-0">
                                <a class="text-white bg-blue radius-10 grey-box-shadow no-wrap d-inline-block btn-lg" id="buy-pro-version" href="<?php echo $pro_version;?>">
                                    <?php  _e( 'Buy PRO version', $plugin_name );?>
                                </a>
                            </div>
                        <!-- </div> -->
                    <!-- </div> -->
                </div>
                <!-- END Activate PRO version -->
            </section>
            <?php } ?>
        </div>
    </div>

</div>
