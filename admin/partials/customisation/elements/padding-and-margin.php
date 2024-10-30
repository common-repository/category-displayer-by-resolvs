<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div id="<?php echo esc_attr($_POST['data']['id']); ?>">
    <div class="flex-row narrow">
        <div class="flex-column flex-basis-0">
            <div class="input-group flex-direction-col has-hover">
                <label class="form-label mt-0 font-weight-600">
                    Margins
                    <span class="categdisp_hover_settings">
                        <a class="categdisp_hover no-wrap"><i class="fas fa-mouse-pointer"></i>Hover</a>
                    </span>
                </label>
                <div class="flex-row narrow">
                    <div class="flex-column flex-basis-0 right-separator">
                        <div class="input-group">
                            <label class="form-label">Top</label>
                            <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>margin-top" name="rscdForm[<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>margin-top]" class="form-control">
                        </div>
                    </div>
                    <div class="flex-column flex-basis-0">
                        <div class="input-group">
                            <label class="form-label">Bottom</label>
                            <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>margin-bottom" name="rscdForm[<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>margin-bottom]" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="flex-row narrow">
                    <div class="flex-column flex-basis-0  right-separator">
                        <div class="input-group">
                            <label class="form-label">Left</label>
                            <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>margin-left" name="rscdForm[<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>margin-left]" class="form-control">
                        </div>
                    </div>
                    <div class="flex-column flex-basis-0">
                        <div class="input-group">
                            <label class="form-label">Right</label>
                            <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>margin-right" name="rscdForm[<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>margin-right]" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-column flex-basis-0">
            <div class="input-group flex-direction-col has-hover">
                <label class="form-label mt-0 font-weight-600">
                    Paddings
                    <span class="categdisp_hover_settings">
                        <a class="categdisp_hover no-wrap"><i class="fas fa-mouse-pointer"></i>Hover</a>
                    </span>
                </label>
                <div class="flex-row narrow">
                    <div class="flex-column flex-basis-0 right-separator">
                        <div class="input-group">
                            <label class="form-label">Top</label>
                            <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>padding-top" name="rscdForm[<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>padding-top]" class="form-control">
                        </div>
                    </div>
                    <div class="flex-column flex-basis-0">
                        <div class="input-group">
                            <label class="form-label">Bottom</label>
                            <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>padding-bottom" name="rscdForm[<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>padding-bottom]" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="flex-row narrow">
                    <div class="flex-column flex-basis-0  right-separator">
                        <div class="input-group">
                            <label class="form-label">Left</label>
                            <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>padding-left" name="rscdForm[<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>padding-left]" class="form-control">
                        </div>
                    </div>
                    <div class="flex-column flex-basis-0">
                        <div class="input-group">
                            <label class="form-label">Right</label>
                            <input type="text" data-fieldname="<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>padding-right" name="rscdForm[<?php echo esc_attr($_POST['data']['target']).esc_attr($_POST['data']['target_tab']); ?>padding-right]" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
