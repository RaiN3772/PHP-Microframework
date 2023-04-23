<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
    </div>

    <form class="form" method="post" action="/profile/<?= $profile->id; ?>/settings" enctype="multipart/form-data">
        <div class="card-body border-top p-9">
            <div class="row mb-6">
                <div class="col-lg-4">
                    <label class="col-form-label fw-semibold fs-6">Avatar</label>
                    <div class="form-text">Allowed file types:<?= $setting->get('allowed_images_type'); ?>.</div>
                    <div class="form-text">Maximum Avatar Size:<?= $setting->get('allowed_image_size'); ?>MB.</div>
                </div>
                <div class="col-lg-8">
                    <div class="image-input image-input-circle" data-kt-image-input="true" style="background-image: url(<?= $setting->get('default_avatar'); ?>)">
                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?= $profile->avatar; ?>)"></div>
                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change avatar">
                            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                        </label>
                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
                            <i class="ki-outline ki-cross fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
            <?php if ($profile->allow_name_change()): ?>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Display Name</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="display_name" class="form-control form-control-lg form-control-solid" value="<?= secure($profile->name); ?>" />
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($profile->allow_username_change()): ?>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">User Name</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="username" class="form-control form-control-lg form-control-solid" value="<?= secure($profile->username); ?>" />
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($profile->allow_email_change()): ?>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email Address</label>
                    <div class="col-lg-8 fv-row">
                        <input type="email" name="email" class="form-control form-control-lg form-control-solid" value="<?= $profile->email; ?>" />
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm Password</label>
                <div class="col-lg-8 fv-row">
                    <input type="password" name="confirm_password" class="form-control form-control-lg form-control-solid" placeholder="Please Confirm your password" />
                </div>
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
            <button type="submit" class="btn btn-primary" id="profile_details_Submit">Save Changes</button>
        </div>
    </form>
</div>
