<?php include 'inc/views/_layout/headerinclude.php'; ?>
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php include 'inc/views/_layout/body.php'; ?>

<div class="d-flex flex-column flex-column-fluid">
  <div class="d-flex flex-column-fluid">
    <div class="container-xxl">
      <div class="card mb-10">
        <div class="card-header border-0 pt-6">
          <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
              <span class="svg-icon svg-icon-1 position-absolute ms-6">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                  <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                </svg>
              </span>
              <input type="text" data-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search user" />
            </div>
          </div>
          <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-user-table-toolbar="base">
              <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-2">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                  </svg>
                </span>
                Filter
              </button>
              <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                <div class="px-7 py-5">
                  <div class="fs-5 text-dark fw-bold">Filter Options</div>
                </div>
                <div class="separator border-gray-200"></div>
                <div class="px-7 py-5" data-user-table-filter="form">
                  <div class="mb-10">
                    <label class="form-label fs-6 fw-semibold">Role:</label>
                    <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-user-table-filter="role">
                      <option></option>
                      <?php foreach ($database->query("SELECT * FROM roles ORDER BY role_id ASC")->fetchAll() as $filter): ?>
                        <option value="<?= $filter['role_title']; ?>"><?= $filter['role_title']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-user-table-filter="reset">Reset</button>
                    <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-user-table-filter="filter">Apply</button>
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-2">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
                    <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor" />
                    <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor" />
                  </svg>
                </span>
                Export Users
                <div id="datatable_users_export_buttons" class="d-none"></div>
                <div id="datatable_users_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                  <div class="menu-item px-3"><a href="#" class="menu-link px-3" data-export="copy">Copy to clipboard</a></div>
                  <div class="menu-item px-3"><a href="#" class="menu-link px-3" data-export="excel">Export as Excel</a></div>
                  <div class="menu-item px-3"><a href="#" class="menu-link px-3" data-export="csv">Export as CSV</a></div>
                  <div class="menu-item px-3"><a href="#" class="menu-link px-3" data-export="pdf">Export as PDF</a></div>
                </div>
              </button>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_user">
                <span class="svg-icon svg-icon-2">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                      transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                  </svg>
                </span>
                Add User
              </button>
            </div>
            <div class="modal fade" id="modal_add_user" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                  <div class="modal-header" id="modal_add_user_header">
                    <h2 class="fw-bold">Add User</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                      <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                          <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                      </span>
                    </div>
                  </div>
                  <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form id="modal_add_user_form" class="form" action="/admin/users/add" method="post">
                      <div class="d-flex flex-column scroll-y me-n7 pe-7" id="modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal_add_user_header" data-kt-scroll-wrappers="#modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                          <label class="required fw-semibold fs-6 mb-2">User Name</label>
                          <input type="text" name="user_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter User Name" />
                          <span class="text-gray-600 mt-2">Please enter the desired username that the user will use to log in with</span>
                        </div>
                        <div class="fv-row mb-7">
                          <label class="required fw-semibold fs-6 mb-2">User Email</label>
                          <input type="email" name="user_email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" />
                        </div>
                        <div class="mb-7">
                          <label class="required fw-semibold fs-6 mb-5">Role</label>
                          <div class="fv-row">
                          <?php foreach ($database->query("SELECT * FROM roles ORDER BY role_id ASC")->fetchAll() as $select): ?>
                            <div class="d-flex">
                            <div class="form-check form-check-custom form-check-solid">
                              <input class="form-check-input me-3" name="user_role" type="radio" value="<?=$select['role_id'];?>" />
                              <label class="form-check-label">
                                <div class="fw-bold text-gray-800"><?=$select['role_title'];?></div>
                                <div class="text-gray-600"><?=$select['role_description'];?></div>
                              </label>
                            </div>
                          <div class='separator separator-dashed my-5'></div>
                          </div>
                          <?php endforeach; ?>
                          </div>
                        </div>
                        <div class="fv-row mb-7">
                          <label class="required fw-semibold fs-6 mb-2">User Password</label>
                          <input type="password" name="user_password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter a Password" />
                        </div>
                      </div>
                      <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-users-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary" data-users-modal-action="submit">
                          <span class="indicator-label">Submit</span>
                          <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body py-4 table-responsive">
          <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_users">
            <thead>
              <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="w-35px pe-2">ID</th>
                <th class="min-w-125px">User</th>
                <th class="min-w-125px">Role</th>
                <th class="min-w-125px">Last Online</th>
                <th class="min-w-125px">Joined Date</th>
                <th class="min-w-125px">IP Address</th>
                <th class="text-end min-w-100px">Actions</th>
              </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
              <?php foreach ($users as $member): ?>
                <tr>
                  <td><?= $member['id']; ?></td>
                  <td class="d-flex align-items-center">
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                      <a href="/profile/<?= $member['id']; ?>">
                        <div class="symbol-label">
                          <img src="<?= $member['avatar']; ?>" alt="<?= secure($member['display_name']); ?>" class="w-100" />
                        </div>
                      </a>
                    </div>
                    <div class="d-flex flex-column">
                      <a href="/profile/<?= $member['id']; ?>" class="text-gray-800 text-hover-primary mb-1"><?= secure($member['name']); ?></a>
                      <span>(<?= secure($member['display_name']); ?>)</span>
                      <span><?= $member['email']; ?></span>
                    </div>
                  </td>
                  <td>
                    <?php $roles = $database->query("SELECT role_title FROM user_roles INNER JOIN roles ON roles.role_id = user_roles.role_id WHERE user_id = :user_id", ['user_id' => $member['id']])->fetchAll(); ?>
                    <?php foreach ($roles as $role): ?>
                      <div class="badge badge-primary fw-bold me-2"><?= secure($role['role_title']); ?></div>
                    <?php endforeach; ?>
                  </td>
                  <td>
                    <?php if (!is_null($member['last_online'])): ?>
                      <div class="badge badge-light fw-bold"><?= format_date($member['last_online']); ?></div>
                    <?php else: ?>
                      <div class="badge badge-danger fw-bold">Never</div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?= format_date($member['created_date']); ?>
                  </td>
                  <td><?= $member['last_ip']; ?></td>
                  <td class="text-end">
                    <a href="/admin/user/<?=$member['id'];?>" class="btn btn-light btn-active-light-primary btn-sm me-2" data-bs-toggle="tooltip" title="Edit User"><i class="fa-solid fa-user-pen"></i></a>
                    <button class="btn btn-light-danger btn-sm" data-id="<?= $member['id']; ?>" data-user-table-filter="delete" data-bs-toggle="tooltip" title="Delete User"><i class="fa-solid fa-trash"></i></button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>


<?php include 'inc/views/_layout/footerinclude.php'; ?>
<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/assets/js/custom/users.js"></script>
<script>
    $(document).ready(function() {
  $('[data-user-table-filter="delete"]').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure you want to delete this user permanently?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '/admin/user/' + id + '/delete';
      }
    })
  });
});
</script>
<?php include 'inc/views/_layout/footer.php'; ?>