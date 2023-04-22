<!--begin::Footer-->
<div class="footer py-4 d-flex flex-lg-column" id="footer" style="background-color: #1e1e2d;">
    <!--begin::Container-->
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1"><?= date("Y"); ?>&copy;</span>
            <a href="/" target="_blank" class="text-gray-800 text-hover-primary me-2"><?= $page['platform']['name']; ?></a><?=version;?>
        </div>
        <!--end::Copyright-->
        <!--begin::Menu-->
        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
            <?php foreach ($FooterItems as $name => $link): ?>
                <li class="menu-item"><a href="<?=$link;?>" target="_blank" class="menu-link px-2"><?=secure($name);?></a></li>
            <?php endforeach; ?>
        </ul>
        <!--end::Menu-->
    </div>
    <!--end::Container-->
</div>

<!--end::Footer-->
</div>
<!--end::Wrapper-->
</div>
</div>
<!--end::Root-->
<!--begin::Scrolltop-->
<div id="scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Scrolltop-->
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>