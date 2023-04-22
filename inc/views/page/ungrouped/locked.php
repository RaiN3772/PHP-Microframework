<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?= secure($page['title']); ?>
    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="<?= $page['platform']['favicon']; ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <style>
    body {
        background-image: url('/assets/images/locked.jpg');
    }
    [data-bs-theme="dark"] body {
        background-image: url('/assets/images/locked-dark.jpg');
    }
    </style>
</head>

<body id="body" class="auth-bg bgi-size-cover bgi-position-center bgi-no-repeat">
    <script type="text/javascript" src="/assets/js/custom/theme.js"></script>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <div class="d-flex flex-column flex-center text-center p-10">
                <div class="card card-flush w-lg-650px py-5">
                    <div class="card-body py-15 py-lg-20">
                        <h1 class="fw-bolder fs-2hx text-gray-900 mb-4"><?= $page['platform']['name']; ?> is Locked</h1>
                        <div class="fw-semibold fs-6 text-gray-500 mb-7"><?= $setting->get('deactivate_website_msg'); ?></div>
                        <div class="mb-0"><a href="/" class="btn btn-sm btn-light-danger">Return Home</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
</body>
</html>