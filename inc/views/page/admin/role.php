<?php include 'inc/views/_layout/headerinclude.php'; ?>
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php include 'inc/views/_layout/body.php'; ?>

<div class="d-flex flex-column flex-column-fluid">
  <div class="d-flex flex-column-fluid">
    <div class="container-xxl">

      <div class="d-flex flex-column flex-lg-row">
        <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
          <div class="card card-flush">
            <div class="card-header">
              <div class="card-title">
                <h2 class="mb-5">
                  <?= $role['role_title']; ?><span class="ms-1" data-bs-toggle="tooltip"
                    title="<?= secure($role['role_description']); ?>">
                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                  </span>
                </h2>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="d-flex flex-column text-gray-600">
                <?php $permissions = $database->query("SELECT permissions.permission_title FROM permissions LEFT JOIN role_permissions ON permissions.permission_id = role_permissions.permission_id WHERE role_permissions.role_id = :role_id", [':role_id' => $role['role_id']]); ?>
                <?php if ($permissions->rowCount() == 0): ?>
                  <div class="d-flex align-items-center py-2"><span class="bullet bg-danger me-3"></span> No Permissions Assigned</div>
                <?php else: ?>
                  <?php foreach ($permissions as $permission): ?>
                    <div class="d-flex align-items-center py-2"><span class="bullet bg-primary me-3"></span>
                      <?= secure($permission['permission_title']); ?>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
            <div class="card-footer pt-0">
              <button type="button" class="btn btn-light btn-active-primary me-2" data-bs-toggle="modal"
                data-bs-target="#modal_update_role">Edit Role</button>
              <button id="delete_role" type="button" class="btn btn-light-danger">Delete Role</button>
            </div>
          </div>
          <div class="modal fade" id="modal_update_role" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-750px">
              <div class="modal-content">
                <div class="modal-header">
                  <h2 class="fw-bold">Update Role</h2>
                  <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                  </div>
                </div>
                <div class="modal-body scroll-y mx-5 my-7">
                  <form id="update_role_form" class="form" action="/admin/role/<?= $role['role_id']; ?>/update"
                    method="post">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="modal_update_role_scroll"
                      data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                      data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal_update_role_header"
                      data-kt-scroll-wrappers="#modal_update_role_scroll" data-kt-scroll-offset="300px">
                      <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold form-label mb-2"><span class="required">Role Title</span></label>
                        <input class="form-control form-control-solid" placeholder="Enter a role name" name="role_title"
                          value="<?= secure($role['role_title']); ?>" />
                      </div>
                      <div class="fv-row mb-10">
                        <label class="fs-5 fw-bold form-label mb-2"><span class="required">Role
                            Description</span></label>
                        <textarea class="form-control form-control-solid" placeholder="Enter a role description"
                          name="role_description"><?= secure($role['role_description']); ?></textarea>
                      </div>
                      <div class="fv-row">
                        <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                        <div class="table-responsive">
                          <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <tbody class="text-gray-600 fw-semibold">
                              <tr>
                                <td class="text-gray-800">Administrator Access
                                  <span class="ms-1" data-bs-toggle="tooltip"
                                    title="Allows a full access to the system">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                  </span>
                                </td>
                                <td>
                                  <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input rounded-pill" type="checkbox" name="permissions[]"
                                      id="roles_select_all" />
                                    <span class="form-check-label" for="roles_select_all">Select all</span>
                                  </div>
                                </td>
                              </tr>
                              <?php foreach ($database->select('permissions')->fetchAll() as $permission): ?>
                                <tr>
                                  <td class="text-gray-800">
                                    <?= secure($permission['permission_title']); ?>
                                    <span class="d-flex text-muted fs-5">
                                      <?= secure($permission['permission_description']); ?>
                                    </span>
                                  </td>
                                  <td>
                                    <div class="d-flex">
                                      <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input rounded-pill" type="checkbox" name="permissions[]"
                                          value="<?= $permission['permission_id']; ?>" id="permissionSwitch"
                                          <?= ($setting->rolePermission($role['role_id'], $permission['permission_id'])) ? ' checked' : ''; ?> />
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="text-center pt-15">
                      <button type="reset" class="btn btn-light me-3"
                        data-kt-roles-modal-action="cancel">Discard</button>
                      <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="flex-lg-row-fluid ms-lg-10">
          <div class="card card-flush mb-6 mb-xl-9">
            <div class="card-header pt-5">
              <div class="card-title">
                <h2 class="d-flex align-items-center">Users Assigned <span class="text-gray-600 fs-6 ms-1">(<?= secure($role['total']); ?>)</span>
                </h2>
              </div>
              <div class="card-toolbar">
                <div class="d-flex align-items-center position-relative my-1" data-view-roles-table-toolbar="base">
                  <i class="ki-outline ki-magnifier fs-1 position-absolute ms-6"></i>
                  <input type="text" data-roles-table-filter="search"
                    class="form-control form-control-solid w-250px ps-15" placeholder="Search Users" />
                </div>
              </div>
            </div>
            <div class="card-body pt-0">
              <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="roles_view_table">
                <thead>
                  <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-50px">ID</th>
                    <th class="min-w-150px">User</th>
                    <th class="min-w-125px">Assigned Date</th>
                    <th class="text-end min-w-100px">Actions</th>
                  </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                  <?php foreach ($database->query("SELECT users.id, users.display_name AS name, users.avatar, users.email, user_roles.assignment_date FROM user_roles LEFT JOIN users ON user_roles.user_id = users.id WHERE user_roles.role_id = :role_id", [':role_id' => $role['role_id']])->fetchAll() as $user_role): ?>
                    <tr>
                      <td>
                        <?= $user_role['id']; ?>
                      </td>
                      <td class="d-flex align-items-center">
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                          <a href="/profile/<?= $user_role['id']; ?>">
                            <div class="symbol-label">
                              <img src="<?= $user_role['avatar']; ?>" alt="<?= secure($user_role['name']); ?>" class="w-100" />
                            </div>
                          </a>
                        </div>
                        <div class="d-flex flex-column">
                          <a href="/profile/<?= $user_role['id']; ?>" class="text-gray-800 text-hover-primary mb-1"><?= secure($user_role['name']); ?></a>
                          <span>
                            <?= $user_role['email']; ?>
                          </span>
                        </div>
                      </td>
                      <td>
                        <?= format_date($user_role['assignment_date']); ?>
                      </td>
                      <td class="text-end">
                        <a href="/profile/<?= $user_role['id']; ?>" data-bs-toggle="tooltip" title="View Profile" class="btn btn-sm btn-light btn-active-light-primary me-2"><i class="fa-solid fa-address-card fs-6"></i></a>
                        <a href="/admin/role/<?= $role['role_id']; ?>/user/<?= $user_role['id']; ?>/remove" data-bs-toggle="tooltip" title="Remove user from this role" class="btn btn-sm btn-light-danger"><i class="fa-solid fa-user-minus fs-6"></i></a>
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
  </div>
</div>


<?php include 'inc/views/_layout/footerinclude.php'; ?>
<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>

<script>
  e = document.querySelector("#roles_view_table"), t = $(e).DataTable({
    info: !1,
    responsive: true,
    order: [],
    pageLength: 5,
    lengthChange: !1,
    columnDefs: [{
      orderable: !1,
      targets: 0
    }, {
      orderable: !1,
      targets: 3
    }]
  }), document.querySelector('[data-roles-table-filter="search"]').addEventListener("keyup", (function (e) {
    t.search(e.target.value).draw()
  }));
  const form = document.querySelector('#update_role_form');
  const selectAll = form.querySelector('#roles_select_all');
  const allCheckboxes = form.querySelectorAll('[type="checkbox"]');
  selectAll.addEventListener('change', e => {
    allCheckboxes.forEach(c => {
      c.checked = e.target.checked;
    });
  });
  document.querySelector('#delete_role').addEventListener('click', function (e) {
    e.preventDefault();
    Swal.fire({
      html: `Are you sure you want to delete this role?`,
      icon: "warning",
      buttonsStyling: false,
      showCancelButton: true,
      cancelButtonText: 'Nope, cancel',
      confirmButtonText: "Yes, delete!",
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: 'btn btn-danger'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '/admin/role/<?= $role['role_id']; ?>/delete';
      }
    })
  });
</script>
<?php include 'inc/views/_layout/footer.php'; ?>