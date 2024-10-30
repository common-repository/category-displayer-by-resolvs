<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>

<div class="wrap wrap-categs-shortcodes">
    <h2></h2>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <h1 class="wp-heading-inline"><?php  _e( 'Extensions library', $plugin_name );?></h1> 
            <div class="flex-row">
                <div class="flex-column flex-basis-0">
                    <div class="box-extension bg-white radius-10 grey-box-shadow h-100">
                        <div class="p-15">
                            <div class="flex-row">
                                <div class="flex-column">
                                    <img src="<?php echo $admin_location;?>images/divi-logo.svg">
                                </div>
                                <div class="flex-column">
                                    <h3>Extension for Divi</h3>
                                    <small class="Alignleft">ver <?php echo $version;?></small>
                                    <a class="alignright">Learn more</a>
                                    <div class="clear"></div>
                                    <p class="license-status">License status: <span class="font-weight-600">Inactive</span></p>

                                    <label class="text-grey w-100">Enter your license code to activate</label>
                                    <input type="text" placeholder="xxxx-xxxx-xxxx-xxxx" class="bg-grey rounded-3 w-100 border-0 license-key" id="divi-license">

                                    <label class="text-grey w-100">Enter email address</label>
                                    <input type="text" placeholder="Email address used for purchasing extensions" class="bg-grey rounded-3 w-100 border-0">

                                    <a class="radius-3 d-inline-block text-white bg-yellow grey-box-shadow no-wrap btn-sm activate-extension no-wrap">Activate</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-column flex-basis-0">
                    <div class="box-extension bg-white radius-10 grey-box-shadow">
                        <div class="p-15">
                            <div class="flex-row">
                                <div class="flex-column">
                                    <img src="<?php echo $admin_location;?>images/elementor-logo.svg">
                                </div>
                                <div class="flex-column">
                                    <h3>Extension for Elementor</h3>
                                    <small class="Alignleft">ver <?php echo $version;?></small>
                                    <a class="alignright">Learn more</a>
                                    <div class="clear"></div>
                                    <p class="license-status">License status: <span class="font-weight-600">Inactive</span></p>

                                    <label class="text-grey w-100">Enter your license code to activate</label>
                                    <input type="text" placeholder="xxxx-xxxx-xxxx-xxxx" class="bg-grey rounded-3 w-100 border-0 license-key" id="elementor-license">

                                    <label class="text-grey w-100">Enter email address</label>
                                    <input type="text" placeholder="Email address used for purchasing extensions" class="bg-grey rounded-3 w-100 border-0">

                                    <a class="radius-3 d-inline-block text-white bg-yellow grey-box-shadow no-wrap btn-sm activate-extension no-wrap">Activate</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-column flex-basis-0">
                    <div class="box-extension bg-white radius-10 grey-box-shadow">
                        <div class="p-15">
                            <div class="flex-row">
                                <div class="flex-column">
                                    <img src="<?php echo $admin_location;?>images/gutenberg-logo.svg">
                                </div>
                                <div class="flex-column">
                                    <h3>Extension for Gutenberg</h3>
                                    <small class="Alignleft">ver <?php echo $version;?></small>
                                    <a class="alignright">Learn more</a>
                                    <div class="clear"></div>
                                    <p class="license-status">License status: <span class="font-weight-600">Inactive</span></p>

                                    <label class="text-grey w-100">Enter your license code to activate</label>
                                    <input type="text" placeholder="xxxx-xxxx-xxxx-xxxx" class="bg-grey rounded-3 w-100 border-0 license-key" id="elementor-license">

                                    <label class="text-grey w-100">Enter email address</label>
                                    <input type="text" placeholder="Email address used for purchasing extensions" class="bg-grey rounded-3 w-100 border-0">

                                    <a class="radius-3 d-inline-block text-white bg-yellow grey-box-shadow no-wrap btn-sm activate-extension no-wrap">Activate</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>