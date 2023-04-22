<div class="accordion-item mb-10">
    <div class="accordion-header" id="platform-configuration">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#platform"
            aria-expanded="false" aria-controls="platform"><span class="fw-bold m-0 fs-3">Platform
                Configuration</span></button>
    </div>
    <div id="platform" class="card accordion-collapse collapse" aria-labelledby="platform-configuration"
        data-bs-parent="#accordionsettings">
        <div class="accordion-body">
            <form id="platform_settings" class="form" method="post" action="/admin/settings">
                <div class="card-body p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Platform Name</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="website_name"
                                class="form-control form-control-lg form-control-solid" placeholder="Platform name"
                                value="<?= $setting->get('website_name'); ?>" />
                            <div class="form-text">
                                <?= $setting->description('website_name'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Platform Description</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="website_description" class="form-control form-control-lg form-control-solid"
                                rows="3"
                                placeholder="Platform Description"><?= $setting->get('website_description'); ?></textarea>
                            <div class="form-text">
                                <?= $setting->description('website_description'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Platform Favicon</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="favicon_url"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Paste the URL of the Favicon"
                                value="<?= $setting->get('favicon_url'); ?>" />
                            <div class="form-text">
                                <?= $setting->description('favicon_url'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Platform Logo</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="logo_url" class="form-control form-control-lg form-control-solid"
                                placeholder="Paste the URL of the Logo" value="<?= $setting->get('logo_url'); ?>" />
                            <div class="form-text">
                                <?= $setting->description('logo_url'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Default User Avatar</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="default_avatar"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Paste the URL of the default avatar"
                                value="<?= $setting->get('default_avatar'); ?>" />
                            <div class="form-text">
                                <?= $setting->description('default_avatar'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Default User Folder</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="user_folder"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Paste the URL of the default folder"
                                value="<?= $setting->get('user_folder'); ?>" />
                            <div class="form-text">
                                <?= $setting->description('user_folder'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Date Formatting</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="date_format"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Paste the URL of the default folder"
                                value="<?= $setting->get('date_format'); ?>" />
                            <div class="form-text">
                                <?= $setting->description('date_format'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Default Role</label>
                        <div class="col-lg-8 fv-row">
                            <select name="default_role" aria-label="Select a Role" data-control="select2"
                                data-placeholder="Select a Role.." class="form-select form-select-solid form-select-lg">
                                <?php foreach ($database->query("SELECT * FROM roles")->fetchAll() as $role): ?>
                                    <option value="<?= $role['role_id']; ?>"
                                        <?= $setting->get('default_role') == $role['role_id'] ? ' selected' : '' ?>><?= secure($role['role_title']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">
                                <?= $setting->description('default_role'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-6"></div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Deactivate Platform</label>
                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input rounded-pill" type="checkbox" name="deactivate_website"<?= $setting->get('deactivate_website') == 'on' ? ' checked' : '' ?> />
                                    <label class="form-check-label">Enable</label>
                                </div>
                            </div>
                            <div class="form-text"><?= $setting->description('deactivate_website'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Deactiviation Message</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="deactivate_website_msg"
                                class="form-control form-control-lg form-control-solid" rows="3"
                                placeholder="Platform Description"><?= $setting->get('deactivate_website_msg'); ?></textarea>
                            <div class="form-text">
                                <?= $setting->description('deactivate_website_msg'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                    <button type="submit" class="btn btn-primary" id="web_submit">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>