<?php if ( ! defined( 'ABSPATH' ) ) exit; 
$target = $_POST['data']['target'];
?>
<p class="mt-0">Disable on</p>
<div class="flex-row">
    <div class="flex-column flex-grow-0">
        <div class="disable-icon">
            <svg id="Component_86_1" data-name="Component 86 – 1" xmlns="http://www.w3.org/2000/svg" width="51" height="37" viewBox="0 0 51 37">
                <rect id="Rectangle_192" data-name="Rectangle 192" width="17" height="4" transform="translate(18 33)" fill="#d5d5d5"/>
                <rect id="Rectangle_191" data-name="Rectangle 191" width="51" height="32" rx="2" fill="#d5d5d5"/>
            </svg>
        </div>
        <label><input type="checkbox" data-fieldname="<?php echo esc_attr($target.'responsive_desktop_display');?>" name="rscdForm[<?php echo esc_attr($target.'responsive_desktop_display');?>]" value="none">Desktop</label>
    </div>
    <div class="flex-column flex-grow-0">
        <div class="disable-icon">
            <svg id="Component_87_1" data-name="Component 87 – 1" xmlns="http://www.w3.org/2000/svg" width="42.574" height="27.369" viewBox="0 0 42.574 27.369">
                <rect id="Rectangle_211" data-name="Rectangle 211" width="42.574" height="27.369" rx="2" fill="#d5d5d5"/>
            </svg>
        </div>
        <label><input type="checkbox" data-fieldname="<?php echo esc_attr($target.'responsive_tablet_display');?>" name="rscdForm[<?php echo esc_attr($target.'responsive_tablet_display');?>]" value="none">Tablet</label>
    </div>
    <div class="flex-column flex-grow-0">
        <div class="disable-icon">
            <svg id="Component_88_1" data-name="Component 88 – 1" xmlns="http://www.w3.org/2000/svg" width="16.659" height="26.179" viewBox="0 0 16.659 26.179">
                <rect id="Rectangle_213" data-name="Rectangle 213" width="26.179" height="16.659" rx="2" transform="translate(0 26.179) rotate(-90)" fill="#d5d5d5"/>
            </svg>
        </div>
        <label><input type="checkbox" data-fieldname="<?php echo esc_attr($target.'responsive_mobile_display');?>" name="rscdForm[<?php echo esc_attr($target.'responsive_mobile_display');?>]" value="none">Mobile</label>
    </div>
</div>