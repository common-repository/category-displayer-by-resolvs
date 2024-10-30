<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section data-cust="<?php echo esc_attr($_POST['data']['data-cust']);?>">
    <h2 class="wp-heading-inline d-inline-block accordion-btn cursor-pointer w-100">
        <span class="element-title"><?php echo esc_html($_POST['data']['title']);?> </span>
        <a class="d-inline-block alignright text-white no-wrap cursor-pointer">
            <div class="burger"></div>
            <div class="burger"></div>
            <div class="burger"></div>
        </a>
    </h2>
    <div class="tpl-settings-wrap">
        <div class="flex-row tpl-settings ">
            <div class="flex-column">
                <div class="box-card bg-white radius-10 grey-box-shadow h-100">
                    <div class="p-15">   
                        <div class="sub-sections children">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>