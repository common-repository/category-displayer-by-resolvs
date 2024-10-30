<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="flex-row flex-column-w782">
    <div class="flex-column col-2-3 box-shadow-rows full-col-w782">
        <div class="flex-row wider-row box-shadow-row">
            <div class="flex-column">
                <label class="box_shadow_settings aligncenter text-blue">
                    <label class="box_shadow_icon d-flex">
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-style" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-style]" class="box_shadow_switcher" value="shadow_style_1"
                                        data-settings ='{"<?php echo esc_attr($_POST['data']['target']);?>shadow-position":"none", 
                                        "<?php echo esc_attr($_POST['data']['target']);?>horizontal-position":"", 
                                        "<?php echo esc_attr($_POST['data']['target']);?>vertical-position":"",
                                        "<?php echo esc_attr($_POST['data']['target']);?>blur-strength":"",
                                        "<?php echo esc_attr($_POST['data']['target']);?>spread-strength":"",
                                        "<?php echo esc_attr($_POST['data']['target']);?>shadow-color":""
                                         }'>
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ban" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-ban fa-w-16 fa-1x"><path fill="currentColor" d="M256 8C119.034 8 8 119.033 8 256s111.034 248 248 248 248-111.034 248-248S392.967 8 256 8zm130.108 117.892c65.448 65.448 70 165.481 20.677 235.637L150.47 105.216c70.204-49.356 170.226-44.735 235.638 20.676zM125.892 386.108c-65.448-65.448-70-165.481-20.677-235.637L361.53 406.784c-70.203 49.356-170.226 44.736-235.638-20.676z" class=""></path></svg>
                    </label>
                </label>
            </div>
            <div class="flex-column">
                <label class="box_shadow_settings aligncenter">
                    <label class="box_shadow_icon bg-white w-100" style="box-shadow: 0 0 15px 0px #95a7b7;">
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-style" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-style]" class="box_shadow_switcher" value="shadow_style_2"
                                            data-settings ='{"<?php echo esc_attr($_POST['data']['target']);?>shadow-position":"outer", 
                                                            "<?php echo esc_attr($_POST['data']['target']);?>horizontal-position":"0", 
                                                            "<?php echo esc_attr($_POST['data']['target']);?>vertical-position":"0",
                                                            "<?php echo esc_attr($_POST['data']['target']);?>blur-strength":"15px",
                                                            "<?php echo esc_attr($_POST['data']['target']);?>spread-strength":"0",
                                                            "<?php echo esc_attr($_POST['data']['target']);?>shadow-color":"#bdbdbd"
                                                            }'>
                    </label>
                </label>
            </div>
            <div class="flex-column">
                <label class="box_shadow_settings aligncenter">
                    <label class="box_shadow_icon bg-white w-100" style="box-shadow: 5px 5px 10px 0px #95a7b7">
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-style" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-style]" class="box_shadow_switcher" value="shadow_style_3"
                                            data-settings ='{"<?php echo esc_attr($_POST['data']['target']);?>shadow-position":"outer", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>horizontal-position":"5px", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>vertical-position":"5px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>blur-strength":"10px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>spread-strength":"0",
                                                "<?php echo esc_attr($_POST['data']['target']);?>shadow-color":"#bdbdbd"
                                                }'>
                    </label>
                </label>
            </div>
            <div class="flex-column">
                <label class="box_shadow_settings aligncenter">
                    <label class="box_shadow_icon bg-white w-100" style="box-shadow: 0px 10px 10px -5px #95a7b7">
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-style" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-style]"  class="box_shadow_switcher" value="shadow_style_4"
                                            data-settings ='{"<?php echo esc_attr($_POST['data']['target']);?>shadow-position":"outer", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>horizontal-position":"0", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>vertical-position":"10px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>blur-strength":"10px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>spread-strength":"-5px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>shadow-color":"#bdbdbd"
                                                }'>
                    </label>
                </label>
            </div>
        </div>
        <div class="flex-row wider-row box-shadow-row">
            <div class="flex-column">
                <label class="box_shadow_settings aligncenter text-blue">
                    <label class="box_shadow_icon bg-white w-100" style="box-shadow: 5px 5px 0px 0px #95a7b7">
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-style" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-style]"  class="box_shadow_switcher" value="shadow_style_5"
                                            data-settings ='{"<?php echo esc_attr($_POST['data']['target']);?>shadow-position":"outer", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>horizontal-position":"5px", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>vertical-position":"5px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>blur-strength":"0",
                                                "<?php echo esc_attr($_POST['data']['target']);?>spread-strength":"0",
                                                "<?php echo esc_attr($_POST['data']['target']);?>shadow-color":"#bdbdbd"
                                                }'>
                    </label>
                </label>
            </div>
            <div class="flex-column">
                <label class="box_shadow_settings aligncenter">
                    <label class="box_shadow_icon bg-white w-100" style="box-shadow: 0px 3px 0px 6px #95a7b7">
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-style" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-style]"  class="box_shadow_switcher" value="shadow_style_6"
                                            data-settings ='{"<?php echo esc_attr($_POST['data']['target']);?>shadow-position":"outer", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>horizontal-position":"0", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>vertical-position":"3px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>blur-strength":"0",
                                                "<?php echo esc_attr($_POST['data']['target']);?>spread-strength":"6px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>shadow-color":"#bdbdbd"
                                                }'>
                    </label>
                </label>
            </div>
            <div class="flex-column">
                <label class="box_shadow_settings aligncenter">
                    <label class="box_shadow_icon bg-white w-100" style="box-shadow: inset 0px 0px 15px 0px #95a7b7;">
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-style" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-style]"  class="box_shadow_switcher" value="shadow_style_7"
                                            data-settings ='{"<?php echo esc_attr($_POST['data']['target']);?>shadow-position":"inset", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>horizontal-position":"0", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>vertical-position":"0",
                                                "<?php echo esc_attr($_POST['data']['target']);?>blur-strength":"15px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>spread-strength":"0",
                                                "<?php echo esc_attr($_POST['data']['target']);?>shadow-color":"#bdbdbd"
                                                }'>
                    </label>
                </label>
            </div>
            <div class="flex-column">
                <label class="box_shadow_settings aligncenter">
                    <label class="box_shadow_icon bg-white w-100" style="box-shadow: -5px -5px 0px 0px #95a7b7">
                        <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-style" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-style]"  class="box_shadow_switcher" value="shadow_style_8"
                        data-settings ='{"<?php echo esc_attr($_POST['data']['target']);?>shadow-position":"outer", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>horizontal-position":"-5px", 
                                                "<?php echo esc_attr($_POST['data']['target']);?>vertical-position":"-5px",
                                                "<?php echo esc_attr($_POST['data']['target']);?>blur-strength":"0",
                                                "<?php echo esc_attr($_POST['data']['target']);?>spread-strength":"0",
                                                "<?php echo esc_attr($_POST['data']['target']);?>shadow-color":"#bdbdbd"
                                                }'>
                    </label>
                </label>
            </div>
        </div>
    </div>
    <div class="flex-column col-1-3 full-col-w782">
        <div class="input-group">
            <label class="form-label">Shadow Position</label>
            <div class="form-control-holder">
                <select class="form-control w-100" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-position" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-position]">
                    <option value="none">No Shadow</option>
                    <option value="outer">Outer Shadow</option>
                    <option value="inset">Inner Shadow</option>
                </select>
            </div>
        </div>
        <div class="input-group">
            <label class="form-label">Shadow color</label>
            <div class="form-control-holder">
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>shadow-color" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>shadow-color]" class="form-control cpa-color-picker">
            </div>
        </div>
        <div class="input-group">
            <label class="form-label">Horizontal position</label>
            <div class="form-control-holder">
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>horizontal-position" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>horizontal-position]" class="form-control">
            </div>
        </div>
        <div class="input-group">
            <label class="form-label">Vertical position</label>
            <div class="form-control-holder">
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>vertical-position" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>vertical-position]" class="form-control">
            </div>
        </div>
        <div class="input-group">
            <label class="form-label">Blur strength</label>
            <div class="form-control-holder">
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>blur-strength" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>blur-strength]" class="form-control">
            </div>
        </div>
        <div class="input-group">
            <label class="form-label">Spread strength</label>
            <div class="form-control-holder">
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>spread-strength" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>spread-strength]" class="form-control">
            </div>
        </div>
    </div>
</div>
                           