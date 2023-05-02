<!--begin::Aside-->
<div id="aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="aside_logo">
        <!--begin::Logo-->
        <a href="/" class="logo d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <img alt="Logo" src="<?= $page['platform']['logo']; ?>" class="h-25px" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle me-n2"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <i class="ki-outline ki-double-left fs-1 rotate-180"></i>
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-2 py-2" id="aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#aside_logo, #aside_footer" data-kt-scroll-wrappers="#aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#aside_menu" data-kt-menu="true">
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link" href="/">
                        <span class="menu-icon">
                            <i class="fa-solid fa-house fs-2"></i>
                        </span>
                        <span class="menu-title">Home</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Pages</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->

                <?php foreach ($MenuItems as $name => $item): ?>
                    <?php if (isset($item['permission']) && !$user->hasPermission($item['permission'])) continue; ?>
                    <?php if (isset($item['sub'])): ?>
                        
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion<?=(preg_match($item['route'], $page['route'])) ? ' here show' : '' ;?>">
                            <span class="menu-link">
                                <span class="menu-icon"><i class="<?= $item['icon']; ?> fs-2"></i></span>
                                <span class="menu-title"><?= secure($name); ?></span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion">
                                <?php foreach ($item['sub'] as $subName => $subItem) { ?>
                                    <?php if (isset($subItem['permission']) && !$user->hasPermission($subItem['permission'])) {
                                        continue;
                                    } ?>
                                    <div class="menu-item">
                                        <a class="menu-link" href="<?= $subItem['link']; ?>">
                                            <span class="menu-icon"><i class="<?= $subItem['icon']; ?> fs-2"></i></span>
                                            <span class="menu-title"><?= secure($subName); ?></span>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="menu-item">
                            <a class="menu-link<?=(preg_match($item['route'], $page['route'])) ? ' active' : '' ;?>" href="<?= $item['link']; ?>">
                                <span class="menu-icon"><i class="<?= $item['icon']; ?> fs-2"></i></span>
                                <span class="menu-title"><?= secure($name); ?></span>
                            </a>
                        </div>

                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
