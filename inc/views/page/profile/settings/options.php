<?php $options = $database->query("SELECT * FROM `user_settings` WHERE `user_id` = :user_id", [':user_id' => $profile->id])->fetch(); ?>
<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Options</h3>
        </div>
    </div>

    <form class="form" method="post" action="/profile/<?= $profile->id; ?>/options">
        <div class="card-body border-top p-9">
        <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">Private Profile</label>
                <div class="col-lg-8 fv-row">
                    <div class="d-flex align-items-center mt-3">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input rounded-pill" type="checkbox" name="private"
                                <?= $options['private'] == 'on' ? ' checked' : '' ?> />
                            <label class="form-check-label">Enable</label>
                        </div>
                    </div>
                    <div class="form-text">Enable this option to hide your profile from others</div>
                </div>
            </div>

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">Hide Email</label>
                <div class="col-lg-8 fv-row">
                    <div class="d-flex align-items-center mt-3">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input rounded-pill" type="checkbox" name="hide_email"
                                <?= $options['hide_email'] == 'on' ? ' checked' : '' ?> />
                            <label class="form-check-label">Enable</label>
                        </div>
                    </div>
                    <div class="form-text">Enable this option to hide your email from others</div>
                </div>
            </div>

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">Hide Online Status</label>
                <div class="col-lg-8 fv-row">
                    <div class="d-flex align-items-center mt-3">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input rounded-pill" type="checkbox" name="hide_online"
                                <?= $options['hide_online'] == 'on' ? ' checked' : '' ?> />
                            <label class="form-check-label">Enable</label>
                        </div>
                    </div>
                    <div class="form-text">Enable this option to hide your online status from others</div>
                </div>
            </div>

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-semibold fs-6">Hide Login Date</label>
                <div class="col-lg-8 fv-row">
                    <div class="d-flex align-items-center mt-3">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input rounded-pill" type="checkbox" name="hide_login"
                                <?= $options['hide_login'] == 'on' ? ' checked' : '' ?> />
                            <label class="form-check-label">Enable</label>
                        </div>
                    </div>
                    <div class="form-text">Enable this option to hide your last login date from others</div>
                </div>
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
            <button type="submit" class="btn btn-primary" id="profile_options_Submit">Save Changes</button>
        </div>
    </form>
</div>