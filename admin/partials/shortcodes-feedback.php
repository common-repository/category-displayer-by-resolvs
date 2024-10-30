<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>

<div class="wrap wrap-categs-shortcodes">
    <h2></h2>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="validate-feedback-submit" class="notice d-none"></div>
            <h1 class="wp-heading-inline"><?php  _e( 'Feedback', $plugin_name );?></h1> 
            <section>
                <form action="" method="POST" id="form-feedback">
                    <div class="flex-row mb-20">
                        <div class="flex-column fixed-column-w">
                            <label class="font-weight-600 lg-label">Feedback title</label>
                        </div>
                        <div class="flex-column">
                            <input type="text" name="fdb-title" class="bg-white border-0 grey-box-shadow radius-10 input-lg w-100" id="fdb-title" placeholder="Feedback Title" required>
                        </div>
                    </div>

                    <div class="flex-row mb-20">
                        <div class="flex-column fixed-column-w">
                            <label class="font-weight-600 lg-label">Feedback description</label>
                        </div>
                        <div class="flex-column">
                            <textarea rows="10" name="fdb-desc" class="bg-white radius-10 grey-box-shadow border-0 w-100 input-lg" id="fdb-desc" placeholder="Please describe your feedback here..." required></textarea>
                        </div>
                    </div>

                    <div class="flex-row">
                        <div class="flex-column fixed-column-w">
                        </div>
                        <div class="flex-column">
                            <a id="submit-feedback" class="text-white bg-yellow radius-10 grey-box-shadow no-wrap d-inline-block btn-lg border-0">Submit feedback</a>
                        </div>
                    </div>
                </form>
            </section>
            <!-- <section>
                <div class="flex-row">
                    <div class="flex-column fixed-column-w">
                        <label class="font-weight-600 lg-label">System Status</label>
                    </div>
                    <div class="flex-column">
                        <p class="m-0 font-weight-600 lg-lh sys-status"><span class="icon-status icon-status-ok d-inline-block radius-10"></span>Everything is good</p>
                        <p class="m-0 font-weight-600 lg-lh sys-status"><span class="icon-status icon-status-error d-inline-block radius-10"></span>Warning!</p>
                    </div>
                </div>
            </section> -->
        </div>
    </div>
</div>