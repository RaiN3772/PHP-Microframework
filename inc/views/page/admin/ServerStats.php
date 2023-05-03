<div class="card card-xl-stretch mb-xl-8">
    <div class="card-body p-0">
        <div class="px-9 pt-7 card-rounded h-275px w-100 bg-secondary">
            <div class="d-flex flex-stack">
                <h3 class="m-0 text-gray-900 fw-bold fs-3">Server Statistics</h3>
            </div>

            <div class="d-flex text-center flex-column text-gray-800 pt-8">
                <span class="fw-semibold fs-3"><?= $page['platform']['name']; ?></span>
            </div>
        </div>

        <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -100px">

        <div class="d-flex align-items-center mb-6">
                <div class="symbol symbol-45px w-40px me-5">
                    <span class="symbol-label bg-lighten">
                        <i class="ki-outline ki-element-11 fs-1"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center flex-wrap w-100">
                    <div class="mb-1 pe-3 flex-grow-1">
                        <span class="fs-5 text-gray-800 text-hover-primary fw-bold">Platform Version</span>
                        <div class="text-gray-400 fw-semibold fs-7">The friendly version number we're running</div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="fw-bold fs-5 text-gray-800 pe-1"><?=version;?></div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center mb-6">
                <div class="symbol symbol-45px w-40px me-5">
                    <span class="symbol-label bg-lighten">
                        <i class="fa-brands fa-php fs-1"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center flex-wrap w-100">
                    <div class="mb-1 pe-3 flex-grow-1">
                        <span class="fs-5 text-gray-800 text-hover-primary fw-bold">PHP Version</span>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="fw-bold fs-5 text-gray-800 pe-1"><?= phpversion(); ?></div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center mb-6">
                <div class="symbol symbol-45px w-40px me-5">
                    <span class="symbol-label bg-lighten">
                        <i class="fa-solid fa-database fs-1"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center flex-wrap w-100">
                    <div class="mb-1 pe-3 flex-grow-1">
                        <span class="fs-5 text-gray-800 text-hover-primary fw-bold">SQL Engine</span>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="fw-bold fs-5 text-gray-800 pe-1"><?= $database->driver() . ' ' . $database->driver_version(); ?></div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center mb-6">
                <div class="symbol symbol-45px w-40px me-5">
                    <span class="symbol-label bg-lighten">
                        <i class="fa-solid fa-weight-scale fs-1"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center flex-wrap w-100">
                    <div class="mb-1 pe-3 flex-grow-1">
                        <span class="fs-5 text-gray-800 text-hover-primary fw-bold">Database Size</span>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="fw-bold fs-5 text-gray-800 pe-1"><?=format_size($setting->total_database_size());?></div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center mb-6">
                <div class="symbol symbol-45px w-40px me-5">
                    <span class="symbol-label bg-lighten">
                        <i class="fa-solid fa-upload fs-1"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center flex-wrap w-100">
                    <div class="mb-1 pe-3 flex-grow-1">
                        <span class="fs-5 text-gray-800 text-hover-primary fw-bold">Max Upload / POST Size</span>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="fw-bold fs-5 text-gray-800 pe-1"><?=ini_get("upload_max_filesize");?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
