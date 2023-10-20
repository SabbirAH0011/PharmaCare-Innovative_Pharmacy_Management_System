<!-- Modal -->
<div class="modal fade" id="storeLocation" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Store new location</h5>
                <button type="button" class="btn-close" id="close" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBackdrop" class="form-label">Location name</label>
                        <input type="text" id="location" class="form-control" placeholder="Enter location name" />
                        <span class="text-danger" id="error_span"></span>
                        <span class="text-success" id="success_span"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" id="close">
                    Close
                </button>
                <button type="submit" class="btn btn-primary" id="save">Save</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
<!--/ Bootstrap modals -->
<script>
    var wait = '<i class="fas fa-spinner fa-pulse"></i> Please wait';
    $(document).ready(function () {
        $(document).on('click', '#save', function (e) {
            e.preventDefault();
            $('#success_span').html('');
            $('#error_span').html('');
            const location = $('#location').val();
            if (!location) {
                $('#error_span').html('Location can not be empty');
            }else{
                 $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('store.location') }}",
                    data: { 'location': location },
                    dataType: "json",
                    beforeSend: function () {
                        $('#save').attr("disabled", true);
                        $('#save').html(wait);
                    },
                    success: function (response) {
                        $('#save').attr("disabled", false);
                        $('#save').html('Save');
                        if (response.error == 'yes') {
                            $('#error_span').html(response.msg);
                        } else if (response.error == 'no') {
                           $('#success_span').html(response.msg);;
                        } else {
                            $('#error_span').html('Something went wrong please contact with admin');
                        }
                    }
                });
            }
        });

        $(document).on('click', '#close', function (e) {
            e.preventDefault();
            $('#location').val('');
            $('#success_span').html('');
            $('#error_span').html('');
            $('#storeLocation').modal('hide');
        });
    });
</script>
