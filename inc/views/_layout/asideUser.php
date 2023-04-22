<!--begin::User-->
<div class="d-flex align-items-stretch" id="header_user_menu_toggle">
    <!--begin::Menu wrapper-->
    <div class="topbar-item cursor-pointer symbol px-3 px-lg-5 me-n3 me-lg-n5 symbol-30px symbol-md-35px"
        data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"
        data-kt-menu-flip="bottom">
        <img src="<?=$user->avatar();?>" alt="<?=$user->name();?>" />
    </div>
    <!--begin::User account menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
        data-kt-menu="true">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <div class="menu-content d-flex align-items-center px-3">
                <!--begin::Avatar-->
                <div class="symbol symbol-50px me-5">
                    <img alt="<?=$user->name();?>" src="<?=$user->avatar();?>" />
                </div>
                <!--end::Avatar-->
                <!--begin::Username-->
                <div class="d-flex flex-column">
                    <div class="fw-bold d-flex align-items-center fs-5"><?=$user->name();?></div>
                    <span class="d-flex badge badge-light-primary fw-bold fs-8 px-2 py-1"><?=$user->role();?></span>
                </div>
                <!--end::Username-->
            </div>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="/profile/<?=$user->id();?>" class="menu-link px-5">My Profile</a>
        </div>
        <!--end::Menu item-->
        <div class="separator my-2"></div>
        <div class="menu-item px-5 my-1">
            <a href="/profile/<?=$user->id();?>/settings" class="menu-link px-5">Account Settings</a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="/logout" class="menu-link px-5">Log Out</a>
        </div>
        <!--end::Menu item-->
    </div>
    <!--end::User account menu-->
    <!--end::Menu wrapper-->
</div>
<!--end::User -->