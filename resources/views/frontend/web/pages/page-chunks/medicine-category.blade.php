<!-- Modal -->
<div class="modal fade" id="storeCategory" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('store.category') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Store new Category</h5>
                <button type="button" class="btn-close" id="close" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBackdrop" class="form-label">Category name</label>
                        <input type="text" id="category" name="category" class="form-control" placeholder="Enter category name" />.
                        @error('category')
                        <span class="text-danger" id="error_span">{{ $message }}</span>
                        @enderror
                        @error('error')
                        <span class="text-danger" id="error_span">{{ $message }}</span>
                        @enderror
                        @if(session()->has('success'))
                        <span class="text-success" id="success_span">{{ session()->get('success') }}</span>
                        @endif
                    </div>
                    <div class="col mb-3">
                        <div class="col-md">
                            <small class="text-light fw-semibold d-block">Is it Top Category?</small>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="top_category" name="top_category" value="yes">
                                <label class="form-check-label" for="top_category">Yes</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" id="close">
                    Close
                </button>
                <button class="btn btn-primary" id="category_save">Save</button>
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
@error('category')
<script>
    $(document).ready(function () {
        $('#storeCategory').modal('show');
    });
</script>
@enderror
@error('error')
<script>
    $(document).ready(function () {
        $('#storeCategory').modal('show');
    });
</script>
@enderror
@if(session()->has('success'))
<script>
    $(document).ready(function () {
        $('#storeCategory').modal('show');
    });
</script>
@endif
<script>
    $(document).ready(function () {
        $(document).on('click', '#close', function (e) {
            e.preventDefault();
            $('#category').val('');
            $("input[name='top_category']:checked").prop("checked", false);
            $('#success_span').html('');
            $('#error_span').html('');
            $('#storeCategory').modal('hide');
        });
    });
</script>
