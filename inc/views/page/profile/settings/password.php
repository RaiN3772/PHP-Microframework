<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Log In Options</h3>
        </div>
    </div>
    <div class="card-body border-top p-9">
        <div class="d-flex flex-wrap align-items-center mb-10">
            <div id="signin_password">
                <div class="fs-6 fw-bold mb-1">Password</div>
                <div class="fw-semibold text-gray-600">************</div>
            </div>
            <div id="signin_password_edit" class="flex-row-fluid d-none">
                <form id="signin_change_password" class="form" novalidate="novalidate" method="post" action="/profile/<?= $profile->id; ?>/password">
                    <div class="row mb-1">
                        <div class="col-lg-4">
                            <div class="fv-row mb-0">
                                <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Current Password</label>
                                <input type="password" class="form-control form-control-lg form-control-solid" name="currentpassword" id="currentpassword" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="fv-row mb-0">
                                <label for="newpassword" class="form-label fs-6 fw-bold mb-3">New Password</label>
                                <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword" id="newpassword" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="fv-row mb-0">
                                <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Confirm New Password</label>
                                <input type="password" class="form-control form-control-lg form-control-solid" name="confirmpassword" id="confirmpassword" />
                            </div>
                        </div>
                    </div>
                    <div class="form-text mb-5">Password must be at least <?=$setting->get('minimum_password_length');?> character and contain symbols</div>
                    <div class="d-flex">
                        <button id="password_submit" type="button" class="btn btn-primary me-2 px-6">Update Password</button>
                        <button id="password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                    </div>
                </form>
            </div>
            <div id="signin_password_button" class="ms-auto">
                <button class="btn btn-light btn-active-light-primary">Reset Password</button>
            </div>
        </div>
    </div>
</div>