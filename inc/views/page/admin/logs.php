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
                  <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                    transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                  <path
                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                    fill="currentColor" />
                </svg>
              </span>
              <input type="text" data-logs-table-filter="search" class="form-control form-control-solid w-250px ps-14"
                placeholder="Search..." />
            </div>
          </div>
          <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-user-table-toolbar="base">
              <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-2">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                      fill="currentColor" />
                  </svg>
                </span>
                Filter
              </button>
              <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                <div class="px-7 py-5">
                  <div class="fs-5 text-dark fw-bold">Filter Options</div>
                </div>
                <div class="separator border-gray-200"></div>
                <div class="px-7 py-5" data-logs-table-filter="form">
                  <div class="mb-10">
                    <label class="form-label fs-6 fw-semibold">User:</label>
                    <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                      data-placeholder="Select User" data-allow-clear="true" data-logs-table-filter="user">
                      <option></option>
                      <?php foreach ($logs->getAdmins() as $admin): ?>
                        <option value="<?= $admin['name']; ?>"><?= $admin['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="mb-10">
                    <label class="form-label fs-6 fw-semibold">Role:</label>
                    <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                      data-placeholder="Select Role" data-allow-clear="true" data-logs-table-filter="role">
                      <option></option>
                      <?php foreach ($logs->getRoles() as $role): ?>
                        <option value="<?= $role['role_title']; ?>"><?= $role['role_title']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                      data-kt-menu-dismiss="true" data-logs-table-filter="reset">Reset</button>
                    <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true"
                      data-logs-table-filter="filter">Apply</button>
                  </div>
                </div>
              </div>
              <button type="button" id="purge_logs" class="btn btn-light-danger"><i
                  class="fa-solid fa-trash me-2"></i>Purge Logs</button>
            </div>
          </div>
        </div>
        <div class="card-body py-4 table-responsive">
          <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_logs">
            <thead>
              <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="w-25px">User</th>
                <th>Information</th>
                <th>Date</th>
                <th>IP Address</th>
              </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
              <?php foreach ($logs->getLogs() as $logger): ?>
                <tr>
                  <td class="d-flex align-items-center">
                    <div class="symbol symbol-circle symbol-25px overflow-hidden me-3">
                      <a href="/profile/<?= $logger['id']; ?>">
                        <div class="symbol-label">
                          <img src="<?= $logger['avatar']; ?>" alt="<?= secure($logger['name']); ?>" class="w-100" />
                        </div>
                      </a>
                    </div>
                    <div class="d-flex flex-column">
                      <a href="/profile/<?= $logger['id']; ?>" class="text-gray-800 text-hover-primary mb-1"><?= secure($logger['name']); ?></a>
                      <span class="fs-8">(<?= secure($logger['role_title']); ?>)</span>
                    </div>
                  </td>
                  <td><?=secure($logger['info']);?></td>
                  <td><?=format_date($logger['date']);?></td>
                  <td><?=$logger['ip'];?></td>
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
<script src="/assets/js/custom/logs.js"></script>
<script>
  $(document).ready(function () {
    $('#purge_logs').click(function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Are you sure you want to purge logs permanently?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, purge!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '/admin/logs/purge';
        }
      })
    });
  });
</script>
<?php include 'inc/views/_layout/footer.php'; ?>