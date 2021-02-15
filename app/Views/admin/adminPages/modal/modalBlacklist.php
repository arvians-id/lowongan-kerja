<!-- Modal -->
<div class="modal fade" id="banned-user" tabindex="-1" role="dialog" aria-labelledby="banned-userLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="banned-userLabel">Blacklist User '<?= $username ?>'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('/admin/goBlacklist/' . $username, 'id="form-blacklist"') ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="Orang ini sengaja mendistribusikan diaksesnya Informasi Elektronik yang memiliki muatan yang melanggar kesusilaan.">
                    <label class="form-check-label" for="exampleRadios1">
                        Orang ini sengaja mendistribusikan diaksesnya Informasi Elektronik yang memiliki muatan yang melanggar kesusilaan.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="Orang ini sengaja mendistribusikan diaksesnya Informasi Elektronik yang memiliki muatan perjudian.">
                    <label class="form-check-label" for="exampleRadios2">
                        Orang ini sengaja mendistribusikan diaksesnya Informasi Elektronik yang memiliki muatan perjudian.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="Orang ini sengaja mendistribusikan diaksesnya Informasi Elektronik yang memiliki muatan penghinaan dan/atau pencemaran nama baik.">
                    <label class="form-check-label" for="exampleRadios3">
                        Orang ini sengaja mendistribusikan diaksesnya Informasi Elektronik yang memiliki muatan penghinaan dan/atau pencemaran nama baik.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="Orang ini sengaja mendistribusikan diaksesnya Informasi Elektronik yang memiliki muatan pemerasan dan/atau pengancaman.">
                    <label class="form-check-label" for="exampleRadios4">
                        Orang ini sengaja mendistribusikan diaksesnya Informasi Elektronik yang memiliki muatan pemerasan dan/atau pengancaman.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios5">
                    <label class="form-check-label" for="exampleRadios5">
                        Lainnya
                    </label>
                </div>
                <div class="form-group mt-2" id="message"></div>
                <div class="form-group">
                    <label class="form-control-label">Finished On</label>
                    <input class="form-control" name="finished_on" placeholder="Select date" type="date">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="btnSave" class="btn btn-primary" id="btn-submit" disabled>Save Changes</button>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<script>
    $('[name="exampleRadios"]').click(function() {
        if ($(this).attr('id') == 'exampleRadios5') {
            $('#message').html(`<div class="input-group input-group-merge input-group-alternative"><input type="text" class="form-control" name="exampleRadios" placeholder="Berikan detail pelanggaran yang spesifik"></div><small class="font-italic">*Maxs 120 Karakter</small>`)
        } else {
            $('#message').html('')
        }
    })

    $("input:radio").change(function() {
        $("#btn-submit").prop("disabled", false);
    });

    function reloadTable() {
        table.ajax.reload(null, false);
    }

    $(document).ready(function() {
        $('#form-blacklist').submit(function(event) {
            event.preventDefault();
            swal({
                    text: "Are you sure, you want to blacklist this user?",
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
                            beforeSend: function() {
                                $('#btn-submit').attr('disabled', true);
                                $('#btn-submit').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>`);
                            },
                            success: function(response) {
                                if (response.error) {
                                    iziToast.error({
                                        timeout: 7000,
                                        title: 'Error',
                                        message: response.error,
                                        position: 'topRight'
                                    });
                                } else {
                                    swal(response.success, {
                                        icon: "success",
                                    });
                                    $('#banned-user').modal('hide');
                                }
                                $('[name="csrf_test_name"]').val(response.csrfHash);
                                reloadTable();
                            },
                            complete: function() {
                                $('#btn-submit').html(`Save changes`);
                                $('#btn-submit').removeAttr('disabled');
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        })
                    }
                });
        })
    })
</script>