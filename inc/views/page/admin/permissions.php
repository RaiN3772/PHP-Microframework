<?php include 'inc/views/_layout/headerinclude.php'; ?>
<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php include 'inc/views/_layout/body.php'; ?>

<div class="d-flex flex-column flex-column-fluid">
  <div class="d-flex flex-column-fluid">
    <div class="container-xxl">

      <div class="card mb-10">
        <div class="card-header mt-6">
          <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1 me-5">
              <span class="svg-icon svg-icon-1 position-absolute ms-6">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                    transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                  <path
                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                    fill="currentColor" />
                </svg>
              </span>
              <input type="text" data-permissions-table-filter="search"
                class="form-control form-control-solid w-250px ps-15" placeholder="Search Permissions" />
            </div>
          </div>
          <div class="card-toolbar">
            <button type="button" class="btn btn-light-primary" data-bs-toggle="modal"
              data-bs-target="#modal_add_permission">
              <span class="svg-icon svg-icon-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                  <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)"
                    fill="currentColor" />
                  <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                </svg>
              </span>
              Add Permission</button>
          </div>
        </div>
        <div class="card-body pt-0">
          <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="permissions_table">
            <thead>
              <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-50px">ID</th>
                <th class="min-w-125px">Permission Title</th>
                <th class="min-w-125px">Variable</th>
                <th class="min-w-250px">Assigned to</th>
                <th class="min-w-125px">Created Date</th>
                <th class="text-end min-w-100px">Actions</th>
              </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
              <?php foreach ($permissions as $permission): ?>
                <tr>
                  <td>
                    <?= $permission['permission_id']; ?>
                  </td>
                  <td>
                    <?= secure($permission['permission_title']); ?>
                    <span class="d-flex text-muted fs-7 fw-normal mt-1">
                      <?= secure($permission['permission_description']); ?>
                    </span>
                  </td>
                  <td><span class="badge badge-light fw-bold">
                      <?= secure($permission['permission_name']); ?>
                    </span></td>
                  <td>
                    <?php $roles = $database->query("SELECT roles.role_title FROM role_permissions JOIN roles ON role_permissions.role_id = roles.role_id WHERE role_permissions.permission_id = :permission_id", [':permission_id' => $permission['permission_id']])->fetchAll(); ?>
                    <?php foreach ($roles as $role): ?>
                      <span class="badge badge-light-primary fs-7 m-1">
                        <?= secure($role['role_title']); ?>
                      </span>
                    <?php endforeach; ?>
                  </td>
                  <td>
                    <?= format_date($permission['created_date']); ?>
                  <td class="text-end">
                    <a href="/admin/permission/<?= $permission['permission_id']; ?>/edit" data-bs-toggle="tooltip" title="Edit" class="btn btn-sm btn-light btn-active-light-primary me-2"><i class="fa-solid fa-pen-to-square"></i></a>
                    <button data-id="<?= $permission['permission_id']; ?>" data-permissions-table-filter="delete" data-bs-toggle="tooltip" title="Delete" class="btn btn-sm btn-light-danger"><i class="fa-solid fa-trash"></i></button>
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

<div class="modal fade" id="modal_add_permission" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered mw-650px">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="fw-bold">Add a Permission</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
          <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)"
                fill="currentColor"></rect>
              <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor">
              </rect>
            </svg>
          </span>
        </div>
      </div>

      <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <form class="form" action="/admin/permission/add" method="post">
          <div class="fv-row mb-7">
            <label class="fs-6 fw-semibold form-label mb-2"><span class="required">Permission Title</span></label>
            <input class="form-control form-control-solid" placeholder="Enter a permission Title"
              name="permission_title" required>
          </div>
          <div class="fv-row mb-7">
            <label class="fs-6 fw-semibold form-label mb-2"><span class="required">Permission Variable</span></label>
            <input class="form-control form-control-solid" placeholder="Enter a permission Variable"
              name="permission_variable" required>
            <span class="text-gray-600 mt-2">Please note that the permission variable must be one word, for example
              <code>manage_users</code>
            </span>
          </div>
          <div class="fv-row mb-7">
            <label class="fs-6 fw-semibold form-label mb-2">Permission Description</label>
            <textarea class="form-control form-control-solid" name="permission_description"
              placeholder="Enter a permission Description" rows="1"></textarea>
          </div>

          <div class="text-center pt-15">
            <button type="reset" class="btn btn-light me-3">Discard</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<?php include 'inc/views/_layout/footerinclude.php'; ?>
<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
  var table = document.querySelector('#permissions_table');

  var datatable = $(table).DataTable({
    "info": true,
    'order': [[0, 'asc']],
    'processing': true,
    'responsive': true,
    "pageLength": 10,
    "lengthChange": true,
    'columnDefs': [
      { orderable: false, targets: 5 },
    ]
  });

  var filterSearch = document.querySelector('[data-permissions-table-filter="search"]');
  filterSearch.addEventListener('keyup', function (e) {
    datatable.search(e.target.value).draw();
  });

  $(document).ready(function() {
  $('[data-permissions-table-filter="delete"]').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure you want to delete this permission?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '/admin/permission/' + id + '/delete';
      }
    })
  });
});


</script>
<?php include 'inc/views/_layout/footer.php'; ?>