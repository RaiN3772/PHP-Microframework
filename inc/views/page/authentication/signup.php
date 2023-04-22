<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= secure($page['title']); ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="<?=$page['platform']['favicon'];?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="body" class="auth-bg">
    <script type="text/javascript" src="/assets/js/custom/theme.js"></script>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">
                        <form class="form w-100" novalidate="novalidate" id="sign_up_form" action="/register" method="post">
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
                                <div class="text-gray-500 fw-semibold fs-6"><?= secure($page['title']); ?></div>
                            </div>
                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Username" name="username" autocomplete="off" class="form-control bg-transparent" />
                            </div>
                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                            </div>

                            <div class="fv-row mb-8" data-kt-password-meter="true">
                                <div class="mb-1">
                                    <div class="position-relative mb-3">
                                        <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                            <i class="ki-outline ki-eye-slash fs-2"></i>
                                            <i class="ki-outline ki-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                </div>
                                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                            </div>
                            <div class="fv-row mb-8">
                                <input placeholder="Repeat Password" name="confirm_password" type="password" autocomplete="off" class="form-control bg-transparent" />
                            </div>
                            <div class="d-grid mb-10">
                                <button type="submit" id="sign_up_submit" class="btn btn-primary">
                                    <span class="indicator-label">Sign up</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account? <a href="/auth" class="link-primary fw-semibold ms-2">Log in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(assets/media/misc/auth-bg.png)">
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="<?= $page['platform']['url']; ?>" class="mb-0 mb-lg-12"><img alt="Logo" src="<?= $page['platform']['logo']; ?>" class="h-75px" /></a>
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7"><?= $page['platform']['name']; ?></h1>
                    <div class="d-none d-lg-block text-white fs-base text-center"><?= $page['platform']['description']; ?></div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/js/custom/authentication-signup.js"></script>
    <?php
    echo isset($_SESSION["toastr"]) && !empty($_SESSION["toastr"]) ?
    '<script>toastr.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['msg'] . '")</script>' : '';
    unset($_SESSION["toastr"]);
    ?>
</body>
</html>