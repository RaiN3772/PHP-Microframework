<?php include 'inc/views/_layout/headerinclude.php'; ?>
<?php include 'inc/views/_layout/body.php'; ?>

<div class="d-flex flex-column flex-column-fluid">
  <div class="d-flex flex-column-fluid">
    <div class="container-xxl">
        
    <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">
                    <?= secure($permission['permission_title']); ?>
                </div>
            </div>
            <form class="form" action="/admin/permission/<?= $permission['permission_id']; ?>/edit" method="post">
                <div class="card-body p-9">
                    <div class="d-flex flex-column">
                        <div class="mb-10">
                            <label class="fs-5 fw-bold form-label mb-2"><span class="required">Permission Title</span></label>
                            <input class="form-control form-control-solid" placeholder="Enter a permission Title" name="permission_title" value="<?= secure($permission['permission_title']); ?>" required>
                        </div>
                        <div class="mb-10">
                            <label class="fs-5 fw-bold form-label mb-2"><span class="required">Permission Variable</span></label>
                            <input class="form-control form-control-solid" placeholder="Enter a permission Variable" name="permission_variable" value="<?= secure($permission['permission_name']); ?>" required>
                            <span class="text-gray-600 mt-2">Please note that the permission variable must be one word, for example
                            <code><?=secure($permission['permission_name']);?></code>
                        </span>
                        </div>
                        <div class="mb-7">
                            <label class="fs-6 fw-semibold form-label mb-2">Permission Description</label>
                            <textarea class="form-control form-control-solid" name="permission_description" placeholder="Enter a permission Description" rows="1"><?= secure($permission['permission_description']); ?></textarea>
                        </div>


                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

<?php include 'inc/views/_layout/footerinclude.php'; ?>
<?php include 'inc/views/_layout/footer.php'; ?>