<?php include 'inc/views/_layout/headerinclude.php'; ?>
<!-- Custom Script Here -->
<?php include 'inc/views/_layout/body.php'; ?>

<div class="d-flex flex-column flex-column-fluid">
  <div class="d-flex flex-column-fluid">
    <div class="container-xxl">
      <div class="d-flex justify-content-end mb-10">
        <button type="button" class="btn btn-lg btn-light-primary" data-bs-toggle="modal" data-bs-target="#modal_add_role">
        <span class="svg-icon svg-icon-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect><rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect></svg></span>Add Role
        </button>
      </div>
      <div class="mb-10 row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
        <?php foreach ($roles as $role): ?>
          <div class="col-md-4">
            <div class="card card-flush mb-10">
              <div class="card-header">
                <div class="card-title">
                  <h2>
                    <?= secure($role['role_title']); ?>
                  </h2>
                </div>
              </div>

              <div class="card-body pt-1">
                <div class="fw-bold text-gray-600 mb-5">Total users with this role:
                  <?= $role['total']; ?>
                </div>
                <div class="d-flex flex-column text-gray-600">
                  <?php 
                  $permissions = $database->query("SELECT permissions.permission_title FROM permissions LEFT JOIN role_permissions ON permissions.permission_id = role_permissions.permission_id WHERE role_permissions.role_id = :role_id", [':role_id' => $role['role_id']]); 
                  $permissionsCount = $permissions->rowCount(); 
                  $counter = 0;
                  ?>
                  <?php if ($permissionsCount == 0): ?>
                    <div class="d-flex align-items-center py-2"><span class="bullet bg-danger me-3"></span> No Permissions Assigned</div>
                  <?php else: ?>
                    <?php foreach ($permissions->fetchAll() as $permission): ?>
                      <?php $counter++; ?>
                      <div class="d-flex align-items-center py-2"><span class="bullet bg-primary me-3"></span><?= secure($permission['permission_title']); ?></div>
                      <?php if ($counter >= 4): ?>
                        <div class="d-flex align-items-center py-2"><span class="bullet bg-primary me-3"></span>And <?=$permissionsCount - $counter;?> more...</div>
                      <?php break; endif; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
              <div class="card-footer flex-wrap pt-0">
                <a href="/admin/role/<?= $role['role_id']; ?>" class="btn btn-light btn-active-primary my-1 me-2">View
                  Role</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_add_role" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered mw-750px">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="fw-bold">Add a Role</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
          <i class="ki-outline ki-cross fs-1"></i>
        </div>
      </div>
      <div class="modal-body scroll-y mx-lg-5 my-7">
        <form id="modal_add_role_form" class="form" action="/admin/role/add" method="post">
          <div class="d-flex flex-column scroll-y me-n7 pe-7" id="modal_add_role_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#modal_add_role_header" data-kt-scroll-wrappers="#modal_add_role_scroll"
            data-kt-scroll-offset="300px">
            <div class="fv-row mb-10">
              <label class="fs-5 fw-bold form-label mb-2">
                <span class="required">Role Title</span>
              </label>
              <input class="form-control form-control-solid" placeholder="Enter a role title" name="role_title" />
            </div>

            <div class="fv-row mb-10">
              <label class="fs-5 fw-bold form-label mb-2">
                <span class="required">Role Description</span>
              </label>
              <textarea class="form-control form-control-solid" placeholder="Enter a role description"
                name="role_description"></textarea>
            </div>

            <div class="fv-row">
              <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
              <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                  <tbody class="text-gray-600 fw-semibold">
                    <tr>
                      <td class="text-gray-800">Administrator Access
                        <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true"
                          data-bs-content="Allows a full access to the system">
                          <i class="ki-outline ki-information fs-7"></i>
                        </span>
                      </td>
                      <td>

                        <div class="col-lg-8 fv-row">
                            <div class="d-flex align-items-center mt-3">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input rounded-pill" type="checkbox" id="roles_select_all" />
                                    <label class="form-check-label">Select all</label>
                                </div>
                            </div>
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
                              <input class="form-check-input rounded-pill" type="checkbox" name="permissions[]" value="<?= $permission['permission_id']; ?>" />
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
            <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">Discard</button>
            <button type="submit" class="btn btn-primary" data-kt-roles-modal-action="submit">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include 'inc/views/_layout/footerinclude.php'; ?>
<script>
  const form = document.querySelector('#modal_add_role_form');
  const selectAll = form.querySelector('#roles_select_all');
  const allCheckboxes = form.querySelectorAll('[type="checkbox"]');
  selectAll.addEventListener('change', e => {
    allCheckboxes.forEach(c => {
      c.checked = e.target.checked;
    });
  });
</script>
<?php include 'inc/views/_layout/footer.php'; ?>
