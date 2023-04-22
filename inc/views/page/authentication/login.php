<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= secure($page['title']); ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="<?=$page['platform']['favicon'];?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="body" class="auth-bg">
    <script type="text/javascript" src="/assets/js/custom/theme.js"></script>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">
                        <form class="form w-100" novalidate="novalidate" id="authLogin" method="post" action="/auth">
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3">Authentication</h1>
                                <div class="text-gray-500 fw-semibold fs-5">Login to <?= $page['platform']['name']; ?></div>
                            </div>
                            <div class="separator my-14"></div>
                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Username" name="username" autocomplete="off" class="form-control bg-transparent" />
                            </div>
                            <div class="fv-row mb-3">
                                <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
                            </div>
                            <div class="fv-row mb-8">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="rememberme" value="1">
                                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">Remember Me?</span>
                                </label>
                            </div>
                            <!--
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <a href="" class="link-primary">Forgot Password ?</a>
                            </div>
                            -->
                            <div class="d-grid mb-10">
                                <button type="submit" id="authSubmit" class="btn btn-primary">
                                    <span class="indicator-label">Log In</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>

                            <?php if ($setting->get('deactivate_registration') == 'off'): ?>
                            <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
                                <a href="/register" class="link-primary ms-2">Sign up</a>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

            </div>

            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                style="background-image: url(assets/media/misc/auth-bg.png)">
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="<?= $page['platform']['url']; ?>" class="mb-0 mb-lg-12"><img alt="Logo" src="<?= $page['platform']['logo']; ?>" class="h-75px" /></a>
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7"><?= $page['platform']['name']; ?></h1>
                    <div class="d-none d-lg-block text-white fs-base text-center"><?= $page['platform']['description']; ?></div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <script src="/assets/js/custom/authentication-login.js"></script>

    <?php
    echo isset($_SESSION["toastr"]) && !empty($_SESSION["toastr"]) ?
    '<script>toastr.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['msg'] . '")</script>' : '';
    unset($_SESSION["toastr"]);
    ?>

</body>
</html>
