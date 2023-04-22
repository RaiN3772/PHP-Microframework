<div class="accordion-item mb-10">
  <div class="accordion-header" id="register-configuration">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#register"
      aria-expanded="false" aria-controls="register"><span class="fw-bold m-0 fs-3">Login & Registeration Configuration</span></button>
  </div>
  <div id="register" class="card accordion-collapse collapse" aria-labelledby="register-configuration"
    data-bs-parent="#accordionsettings">
    <div class="accordion-body">
      <form id="register_settings" class="form" method="post" action="/admin/settings">
        <div class="card-body p-9">

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Deactivate Registration</label>
            <div class="col-lg-8 fv-row">
              <div class="d-flex align-items-center mt-3">
                <div class="form-check form-switch form-check-custom form-check-solid">
                  <input class="form-check-input rounded-pill" type="checkbox" name="deactivate_registration"
                    <?= $setting->get('deactivate_registration') == 'on' ? ' checked' : '' ?> />
                  <label class="form-check-label">Enable</label>
                </div>
              </div>
              <div class="form-text">
                <?= $setting->description('deactivate_registration'); ?>
              </div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Minimum Username Length</label>
            <div class="col-lg-8 fv-row">
              <input type="number" name="min_username" class="form-control form-control-lg form-control-solid"
                value="<?= $setting->get('minimum_username_length'); ?>" />
              <div class="form-text">
                <?= $setting->description('minimum_username_length'); ?>
              </div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Maximum Username Length</label>
            <div class="col-lg-8 fv-row">
              <input type="number" name="max_username" class="form-control form-control-lg form-control-solid"
                value="<?= $setting->get('maximum_username_length'); ?>" />
              <div class="form-text">
                <?= $setting->description('maximum_username_length'); ?>
              </div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Minimum Password Length</label>
            <div class="col-lg-8 fv-row">
              <input type="number" name="min_password" class="form-control form-control-lg form-control-solid" value="<?= $setting->get('minimum_password_length'); ?>" />
              <div class="form-text"><?= $setting->description('minimum_password_length'); ?></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Maximum Password Length</label>
            <div class="col-lg-8 fv-row">
              <input type="number" name="max_password" class="form-control form-control-lg form-control-solid" value="<?= $setting->get('maximum_password_length'); ?>" />
              <div class="form-text"><?= $setting->description('maximum_password_length'); ?>
              </div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label fw-semibold fs-6">Require a complex password</label>
            <div class="col-lg-8 fv-row">
              <div class="d-flex align-items-center mt-3">
                <div class="form-check form-switch form-check-custom form-check-solid">
                  <input class="form-check-input rounded-pill" type="checkbox" name="complex_password"<?= $setting->get('complex_password') == 'on' ? ' checked' : '' ?> />
                  <label class="form-check-label">Enable</label>
                </div>
              </div>
              <div class="form-text"><?= $setting->description('complex_password'); ?></div>
            </div>
          </div>
          <div class="separator separator-dashed my-6"></div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Number of times to allow failed logins</label>
            <div class="col-lg-8 fv-row">
              <input type="number" name="failed_logins" class="form-control form-control-lg form-control-solid" value="<?= $setting->get('failed_logins'); ?>" />
              <div class="form-text"><?= $setting->description('failed_logins'); ?></div>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Time between failed logins</label>
            <div class="col-lg-8 fv-row">
              <input type="number" name="failed_login_time" class="form-control form-control-lg form-control-solid" value="<?= $setting->get('failed_login_time'); ?>" />
              <div class="form-text"><?= $setting->description('failed_login_time'); ?></div>
            </div>
          </div>
        </div>

        <div class="card-footer d-flex justify-content-end py-6 px-9">
          <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
          <button type="submit" class="btn btn-primary" id="register_submit">Save Changes</button>
        </div>
      </form>

    </div>
  </div>
</div>