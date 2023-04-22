<div class="accordion-item mb-10">
  <div class="accordion-header" id="profile-configuration">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#profile"
      aria-expanded="false" aria-controls="register"><span class="fw-bold m-0 fs-3">Profile Configuration</span></button>
  </div>
  <div id="profile" class="card accordion-collapse collapse" aria-labelledby="register-profile"
    data-bs-parent="#accordionsettings">
    <div class="accordion-body">
      <form id="profile_settings" class="form" method="post" action="/admin/settings">
        <div class="card-body p-9">

        <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Deactivate Profiles</label>
            <div class="col-lg-8 fv-row">
              <div class="d-flex align-items-center mt-3">
                <div class="form-check form-switch form-check-custom form-check-solid">
                  <input class="form-check-input rounded-pill" type="checkbox" name="deactivate_profiles"<?= $setting->get('deactivate_profiles') == 'on' ? ' checked' : '' ?> />
                  <label class="form-check-label">Enable</label>
                </div>
              </div>
              <div class="form-text"><?= $setting->description('deactivate_profiles'); ?></div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Allow Username Change</label>
            <div class="col-lg-8 fv-row">
              <div class="d-flex align-items-center mt-3">
                <div class="form-check form-switch form-check-custom form-check-solid">
                  <input class="form-check-input rounded-pill" type="checkbox" name="allow_username_change"<?= $setting->get('allow_username_change') == 'on' ? ' checked' : '' ?> />
                  <label class="form-check-label">Enable</label>
                </div>
              </div>
              <div class="form-text"><?= $setting->description('allow_username_change'); ?></div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Allow Display name Change</label>
            <div class="col-lg-8 fv-row">
              <div class="d-flex align-items-center mt-3">
                <div class="form-check form-switch form-check-custom form-check-solid">
                  <input class="form-check-input rounded-pill" type="checkbox" name="allow_name_change"<?= $setting->get('allow_name_change') == 'on' ? ' checked' : '' ?> />
                  <label class="form-check-label">Enable</label>
                </div>
              </div>
              <div class="form-text"><?= $setting->description('allow_name_change'); ?></div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Allow Email Address Change</label>
            <div class="col-lg-8 fv-row">
              <div class="d-flex align-items-center mt-3">
                <div class="form-check form-switch form-check-custom form-check-solid">
                  <input class="form-check-input rounded-pill" type="checkbox" name="allow_email_change"<?= $setting->get('allow_email_change') == 'on' ? ' checked' : '' ?> />
                  <label class="form-check-label">Enable</label>
                </div>
              </div>
              <div class="form-text"><?= $setting->description('allow_email_change'); ?></div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Allowed Image Size</label>
            <div class="col-lg-8 fv-row">
              <input type="number" name="allowed_image_size" class="form-control form-control-lg form-control-solid" value="<?= $setting->get('allowed_image_size'); ?>" />
              <div class="form-text"><?= $setting->description('allowed_image_size'); ?></div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Allowed Image types</label>
            <div class="col-lg-8 fv-row">
              <input type="text" name="allowed_images_type" class="form-control form-control-lg form-control-solid" value="<?= $setting->get('allowed_images_type'); ?>" />
              <div class="form-text"><?= $setting->description('allowed_images_type'); ?></div>
            </div>
          </div>

        <div class="card-footer d-flex justify-content-end py-6 px-9">
          <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
          <button type="submit" class="btn btn-primary" id="profile_submit">Save Changes</button>
        </div>
      </form>

    </div>
  </div>
</div>