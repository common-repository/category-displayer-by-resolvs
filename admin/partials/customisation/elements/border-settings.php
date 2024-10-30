<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="flex-row">
    <div class="flex-column flex-basis-0">
        <div class="input-group flex-direction-col has-hover">
            <label class="form-label mt-0">
                Border Style
                <span class="categdisp_hover_settings">
                    <a class="categdisp_hover no-wrap"><i class="fas fa-mouse-pointer"></i>Hover</a>
                </span>
            </label>
            <div class="form-control-holder ">
                <ul class="radio-checkbox-img border-style-ul mt-0 form-label">
                    <li class="form-control border-0">
                        <label>
                            <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-type" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-type]" value="all">
                            <div class="box-border-style">
                                <span style="border-width: 2px; border-style:solid;"></span>
                            </div>
                        </label>
                    </li>
                    <li class="form-control border-0">
                        <label>
                            <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-type" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-type]" value="top">
                            <div class="box-border-style">
                                <span style="border-width: 2px 1px 1px; border-style:solid dotted dotted; border-color: #000 #aeb0b3 #aeb0b3;"></span>
                            </div>
                        </label>
                    </li>
                    <li class="form-control border-0">
                        <label>
                            <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-type" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-type]" value="bottom">
                            <div class="box-border-style">
                                <span style="border-width: 1px 1px 2px; border-style: dotted dotted solid; border-color: #aeb0b3 #aeb0b3 #000;"></span>
                            </div>
                        </label>
                    </li>
                    <li class="form-control border-0">
                        <label>
                            <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-type" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-type]" value="left">
                            <div class="box-border-style">
                                <span style="border-width: 1px 1px 1px 2px; border-style: dotted dotted dotted solid; border-color: #aeb0b3 #aeb0b3 #aeb0b3 #000;"></span>
                            </div>
                        </label>
                    </li>
                    <li class="form-control border-0">
                        <label>
                            <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-type" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-type]" value="right">
                            <div class="box-border-style">
                                <span style="border-width: 1px 2px 1px 1px; border-style: dotted solid dotted dotted; border-color: #aeb0b3 #000 #aeb0b3 #aeb0b3;"></span>
                            </div>
                        </label>
                    </li>
                    <li class="form-control border-0">
                        <label>
                            <input type="radio" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-type" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-type]" value="none">
                            <div class="box-border-style">
                                <span style="border-width: 1px; border-style: dotted; border-color: #aeb0b3;"></span>
                            </div>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
        <div class="input-group has-hover">
            <label class="form-label">Border Width
                <span class="categdisp_hover_settings">
                    <a class="categdisp_hover no-wrap"><i class="fas fa-mouse-pointer"></i>Hover</a>
                </span>
            </label>
            <div class="form-control-holder">
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-width" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-width]" class="form-control" >
            </div>
        </div>
        <div class="input-group  has-hover">
            <label class="form-label">Border Color
                <span class="categdisp_hover_settings">
                    <a class="categdisp_hover no-wrap"><i class="fas fa-mouse-pointer"></i>Hover</a>
                </span>
            </label>
            <div class="form-control-holder">
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-color" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-color]" class="form-control cpa-color-picker" >
            </div>
        </div>
    </div>

    <div class="flex-column flex-basis-0">
        <div class="input-group flex-direction-col has-hover">
            <label class="form-label mt-0">
                Rounded Corners Radius
                <span class="categdisp_hover_settings">
                    <a class="categdisp_hover no-wrap"><i class="fas fa-mouse-pointer"></i>Hover</a>
                </span>
            </label>

            <div class="form-control-holder form-control rounded-corners-radius">
                <svg class="rounded-settings" id="Component_92_1" data-name="Component 92 – 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="175.318" height="98.446" viewBox="0 0 175.318 98.446">
                    <defs>
                        <clipPath id="clip-path<?php echo esc_attr($_POST['data']['target']); ?>">
                        <rect id="Rectangle_467" data-name="Rectangle 467" width="70.669" height="39.566" transform="translate(70.669 39.566) rotate(-180)" fill="none"/>
                        </clipPath>
                        <clipPath id="clip-path-2<?php echo esc_attr($_POST['data']['target']); ?>">
                        <rect id="Rectangle_467-2" data-name="Rectangle 467" width="39.663" height="70.498" transform="translate(39.663 70.498) rotate(-180)" fill="none"/>
                        </clipPath>
                    </defs>
                    <g id="Group_400" data-name="Group 400">
                        <g id="Group_384" data-name="Group 384" transform="translate(104.649 0.048)">
                        <g id="Group_383" data-name="Group 383" transform="translate(0)" clip-path="url(#clip-path<?php echo$_POST['data']['target'];?>)">
                            <rect id="Rectangle_466" data-name="Rectangle 466" width="443.883" height="249.126" rx="6" transform="translate(54.479 257.671) rotate(-180)" fill="none" stroke="#bebebe" stroke-miterlimit="10" stroke-width="1"/>
                        </g>
                        </g>
                        <g id="Group_396" data-name="Group 396" transform="translate(0 39.663) rotate(-90)">
                        <g id="Group_383-2" data-name="Group 383" transform="translate(0)" clip-path="url(#clip-path-2<?php echo$_POST['data']['target'];?>)">
                            <rect id="Rectangle_466-2" data-name="Rectangle 466" width="249.126" height="443.883" rx="6" transform="translate(30.576 459.107) rotate(-180)" fill="none" stroke="#bebebe" stroke-miterlimit="10" stroke-width="1"/>
                        </g>
                        </g>
                        <g id="Group_384-2" data-name="Group 384" transform="translate(70.669 98.399) rotate(180)">
                        <g id="Group_383-3" data-name="Group 383" transform="translate(0)" clip-path="url(#clip-path<?php echo$_POST['data']['target'];?>)">
                            <rect id="Rectangle_466-3" data-name="Rectangle 466" width="443.883" height="249.126" rx="6" transform="translate(54.479 257.671) rotate(-180)" fill="none" stroke="#bebebe" stroke-miterlimit="10" stroke-width="1"/>
                        </g>
                        </g>
                        <g id="Group_396-2" data-name="Group 396" transform="translate(175.318 58.784) rotate(90)">
                        <g id="Group_383-4" data-name="Group 383" transform="translate(0)" clip-path="url(#clip-path-2<?php echo esc_attr($_POST['data']['target']);?>)">
                            <rect id="Rectangle_466-4" data-name="Rectangle 466" width="249.126" height="443.883" rx="6" transform="translate(30.576 459.107) rotate(-180)" fill="none" stroke="#bebebe" stroke-miterlimit="10" stroke-width="1"/>
                        </g>
                        </g>
                    </g>
                    <g id="Group_399" data-name="Group 399" transform="translate(34.633 19.438)">
                        <line id="Line_24" data-name="Line 24" y1="58.916" x2="104.973" transform="translate(0 0)" fill="none" stroke="#e2e2e2" stroke-linecap="round" stroke-width="1"/>
                        <path id="Path_228" data-name="Path 228" d="M104.973,58.916,0,0" transform="translate(0 0)" fill="none" stroke="#e2e2e2" stroke-linecap="round" stroke-width="1"/>
                    </g>
                    <rect id="Rectangle_468" data-name="Rectangle 468" width="57" height="29" rx="2" transform="translate(60.16 34.001)" fill="#f2f2f2" class="chain-link-values"/>
                </svg>
                <label for="<?php echo $_POST['data']['target'];?>border-link" class="catdisp-border-link">
                    <input type="checkbox" class="chain-border" value="1" id="<?php echo esc_attr($_POST['data']['target']);?>border-link" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-link" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-link]">
                </label>
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-top-left-radius" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-top-left-radius]" class="rounded-top-left radius-0">
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-bottom-left-radius" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-bottom-left-radius]" class="rounded-bottom-left radius-0" >
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-top-right-radius" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-top-right-radius]" class="rounded-top-right radius-0">
                <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']);?>border-bottom-right-radius" name="rscdForm[<?php echo esc_attr($_POST['data']['target']);?>border-bottom-right-radius]" class="rounded-bottom-right radius-0">
            </div>
            
        </div>
    </div>
</div>