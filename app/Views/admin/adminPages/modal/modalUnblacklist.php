<!-- Modal -->
<div class="modal fade" id="unbanned-user" tabindex="-1" aria-labelledby="unbanned-userLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unbanned-userLabel">Unblacklist User '<?= $data['username'] ?>'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Information : <?= $data['message'] ?>
                <div class="modal-footer">
                    <?= form_open('/admin/goUnblacklist/' . $data['id'], 'id="form-unblacklist"') ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function reloadTable() {
        table.ajax.reload(null, false);
    }
    $(document).ready(function() {
        $('#form-unblacklist').submit(function(event) {
            event.preventDefault();
            swal({
                    text: "Are you sure, you want to unblacklist this user?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: $(this).attr('action'),
                            method: 'POST',
                            dataType: 'json',
                            data: $(this).serialize(),
                            success: function(response) {
                                if (response.success) {
                                    swal(response.success, {
                                        icon: "success",
                                    });
                                    $('#unbanned-user').modal('hide');
                                }
                                $('[name="csrf_test_name"]').val(response.csrfHash)
                                reloadTable();
                            }
                        })
                    }
                });
        })
    })
</script>