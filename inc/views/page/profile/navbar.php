<div class="card mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="<?= $profile->avatar; ?>" alt="image" />
                    <?php if (!$profile->hideOnline()): ?>
                        <?php if ($setting->isOnline($profile->id) == 'online'): ?>
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px" data-bs-toggle="tooltip" title="Online"></div>
                        <?php else: ?>
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-danger rounded-circle border border-4 border-body h-20px w-20px" data-bs-toggle="tooltip" title="Offline"></div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-gray-900 fs-2 fw-bold me-1"><?= secure($profile->name); ?></span>
                            <i class="ki-outline ki-verify fs-1 text-primary"></i>
                        </div>

                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <i class="ki-outline ki-security-user fs-3 me-1"></i><?= $profile->roles[0]['role_title']; ?>
                            </span>
                            <?php if ($profile->id == $user->id() || $user->hasPermission('manage_users')): ?>
                                <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="ki-outline ki-profile-circle fs-3 me-1"></i><?= secure($profile->username); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($profile->id == $user->id() || !$profile->hideEmail()): ?>
                            <span class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                <i class="ki-outline ki-sms fs-3 me-1"></i><?= $profile->email; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Begin Actions 
                    <div class="d-flex my-4">
                        <a href="#" class="btn btn-sm btn-light me-2">
                            <span class="indicator-label">Test</span>
                        </a>
                    </div>
                    -->
                </div>
            </div>
        </div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <li class="nav-item mt-2"><a class="nav-link text-active-primary ms-0 me-10 py-5<?= ($page['current'] == $profile->id) ? ' active' : ''; ?>" href="/profile/<?= $profile->id; ?>">Overview</a></li>
            <?php if ($profile->id == $user->id()): ?>
            <li class="nav-item mt-2"><a class="nav-link text-active-primary ms-0 me-10 py-5<?= ($page['current'] == 'settings') ? ' active' : ''; ?>" href="/profile/<?= $profile->id;?>/settings">Settings</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>