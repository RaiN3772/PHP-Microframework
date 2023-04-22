<div class="card mb-5 mb-xl-10">
    <div class="card-header">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
        <?php if ($profile->id == $user->id()): ?>
            <a href="/profile/<?= $profile->id; ?>/settings" class="btn btn-sm btn-primary align-self-center">Edit Profile</a>
        <?php endif ?>
    </div>
    <div class="card-body p-9">
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Name</label>
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800"><?= secure($profile->name); ?></span>
            </div>
        </div>
        <?php if (!$profile->hideLogin()): ?>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Last Login</label>
            <div class="col-lg-8">
                <span class="fw-semibold text-gray-800 fs-6"><?= format_date($profile->last_login); ?></span>
            </div>
        </div>
        <?php endif;?>
        <?php if (!$profile->hideOnline()): ?>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Last Online</label>
            <div class="col-lg-8">
                <span class="fw-semibold text-gray-800 fs-6"><?= format_date($profile->last_online); ?></span>
            </div>
        </div>
        <?php endif; ?>
        <div class="row mb-7">
            <label class="col-lg-4 fw-semibold text-muted">Registeration Date</label>
            <div class="col-lg-8">
                <span class="fw-semibold text-gray-800 fs-6"><?= format_date($profile->created_date); ?></span>
            </div>
        </div>
    </div>
</div>

<?php if ($user->hasPermission('manage_users')): ?>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Administrator Options</h3>
            </div>
            <a href="/admin/user/<?= $profile->id; ?>" class="btn btn-sm btn-primary align-self-center">Edit User</a>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">User ID</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= $profile->id; ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">User Name</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= secure($profile->username); ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">User Email</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= $profile->email; ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Regiseration IP Address</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= $profile->register_ip; ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">Last IP Address</label>
                <div class="col-lg-8"><span class="fw-bold fs-6 text-gray-800"><?= $profile->last_ip; ?></span></div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-semibold text-muted">User Roles</label>
                <div class="col-lg-8">
                    <?php foreach ($profile->roles as $role): ?>
                        <span class="badge badge-light-primary me-2"><?= secure($role['role_title']); ?></span>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>