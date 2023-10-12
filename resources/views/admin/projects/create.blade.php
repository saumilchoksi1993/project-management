@extends('home')

@section('title')
    Create Project
@endsection

@section('extra-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<style>
    .dropdown-menu{
        max-width: 750px;
    }
    .my-select .btn {
        margin-top: 0px !important;
        color: #212529;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
    }
</style>
@endsection

@section('index')
        <div class="content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="">
                            <h3>
                                Add New Project
                            </h3>
                        </div>
                        <form id="form_submit" method="POST" action="#">
                           <div class="row">
                                @csrf
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Project Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="project name" required autofocus>
                                    @error('name')
                                        <label id="name-error" class="error" for="name">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Client Name</label>
                                    <input type="text" class="form-control" name="client_name" placeholder="Add client name">
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Client Address</label>
                                    <input type="text" class="form-control" name="client_address" placeholder="Add client address">
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Client Email</label>
                                    <input type="email" class="form-control @error('client_email') is-invalid @enderror" name="client_email" placeholder="Add client email">
                                    @error('client_email')
                                        <label id="client-email-error" class="error" for="client_email">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Client Phone</label>
                                    <input type="text" class="form-control" name="client_phone" placeholder="Add client phone">
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Owner Address</label>
                                    <input type="text" class="form-control" name="owner_address" placeholder="Add owner address">
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Dwelling Description</label>
                                    <input type="text" class="form-control" name="dwelling_description" placeholder="Add dwelling description">
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Builder Address</label>
                                    <input type="text" class="form-control" name="builder_address" placeholder="Add builder address">
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Site Address</label>
                                    <input type="text" class="form-control" name="site_address" placeholder="Add site address">
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Contract Price</label>
                                    <input type="number" class="form-control" name="contract_price" placeholder="Add price">
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <label class="form-label">Extra inclusions variation price</label>
                                    <input type="number" class="form-control" name="extra_inclusions_variation_price" placeholder="Add extra inclusions variation price">
                                </div>
                                @foreach($items_data as $item)
                                    <div class="form-group col-lg-6 col-md-6">
                                        <label class="form-label">{{ $item->display_name }}</label>
                                        <div id="items">
                                            <select name="items[{{ $item->name }}][existing_options][]" class="my-select selectpicker form-control show-menu-arrow" multiple data-live-search="true" data-style="btn-light" data-selected-text-format="count" data-width="100%">
                                                @foreach($item->itemOptions as $item_option)
                                                    <option value="{{ $item_option->id }}">{{ $item_option->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="add_sub_option_wrapper_{{ $item->id }}"></div>
                                        <button onclick="addOptionInItem({{ $item }})" class="btn btn-primary btn-sm" id="input_item_option_button_{{ $item->id }}" type="button">Add Option</button>
                                        <span id="add_note_option_wrapper_{{ $item->id }}"></span>
                                        <button id="add_note_button_{{ $item->id }}" onclick="addNoteInItem({{ $item }})" class="btn btn-primary btn-sm" type="button">Add Note</button>
                                    </div>
                                @endforeach
                                <div id="add_new_items"></div>
                                <div class="col-lg-12 col-md-12">
                                    <button onclick="addNewItem()" class="btn btn-primary btn-sm" id="add_new_items" type="button">Add New Item</button>
                                </div>
                            </div>
                            <div class="row form-group col-lg-6 col-md-6">
                                <button class="btn btn-primary btn-sm" type="submit">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('extra-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker();

    $(document).ready(function() {
        // Create project.
        var dynamicURL = '/projects';
        // Submit form.
        $("#form_submit").on("submit", function(event){
            event.preventDefault();
            var formValues = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: dynamicURL,
                data: formValues,
                success: function (data) {
                    window.location.href = dynamicURL;
                },
                error: function (data) {
                },
            });
        });
    });

    // Add new option under existing item.
    function addOptionInItem(item) {
        let item_id = item.id;
        let item_name = item.name;
        let newRowAdd =
            '<div id="new_sub_option_wrapper_'+item_id+'" class="d-flex multi-field mt-2">' +
            '<input type="text" name="items['+item_name+'][new_options][]" class="form-control flex">' +
            '<button id="remove_button_'+item_id+'" class="remove-field ml-2 flex btn btn-danger btn-sm" type="button">Remove</button>' +
            '</div>';

        $('#add_sub_option_wrapper_'+item_id).append(newRowAdd);
    }

    function addNoteInItem(item) {
        let item_id = item.id;
        let item_name = item.name;
        let newRowAdd =
            '<div id="add_note_option_wrapper_'+item_id+'" class="d-flex multi-field mt-2">' +
            '<input type="text" name="items['+item_name+'][input_note]" class="form-control flex" placeholder="Add note">' +
            '<button id="remove_button_'+item_id+'" class="remove-field ml-2 flex btn btn-danger btn-sm" type="button">Remove</button>' +
            '</div>';

            $('#add_note_option_wrapper_'+item_id).html(newRowAdd);
            $('#add_note_button_'+item_id).prop('disabled', true);
    }

    // remove new option under existing item.
    $("body").on("click", ".remove-field", function () {
        let remove_button_id_array = $(this).attr('id').split('_');
        let item_id = remove_button_id_array[2];
        $(this).parents("#new_sub_option_wrapper_" + item_id).remove();
        $(this).parents("#add_note_option_wrapper_" + item_id).remove();
    });

    // Add new whole item.
    var new_item_index = 0;
    function addNewItem() {
        let newItemAdd =
            '<div class="form-group col-lg-6 col-md-6 add_new_item_wrapper_'+new_item_index+'">' +
            '<div class="d-flex">' +
            '<label class="form-label"></label>' +
            '<input type="text" class="form-control" name="new_items['+new_item_index+'][name]" placeholder="Add item name">' +
            '<button class="remove_item ml-2 flex btn btn-danger btn-sm" onclick="removeNewItem('+new_item_index+')" type="button">Remove Item</button>' +
            '</div>' +
            '<div id="add_new_item_sub_option_wrapper_'+new_item_index+'"></div><button onclick="addOptionInNewItem('+new_item_index+')" class="btn btn-primary btn-sm" id="input_new_item_option_button_'+new_item_index+'" type="button">Add Option</button>' +
            '</div>';

        $(newItemAdd).insertBefore('#add_new_items');

        new_item_index++;
    }

    // Remove whole new item with options.
    function removeNewItem(item_index) {
        $('.add_new_item_wrapper_' + item_index).remove();
    }

    // Add new option under new item.
    function addOptionInNewItem(item_index) {
        let newRowAdd =
            '<div id="new_item_sub_option_wrapper_'+item_index+'" class="d-flex multi-field mt-2">' +
            '<input type="text" name="new_items['+item_index+'][new_options][]" class="form-control flex">' +
            '<button id="remove_button_'+item_index+'" class="remove-new-item-field ml-2 flex btn btn-danger btn-sm" type="button">Remove Option</button>' +
            '</div>';

        $('#add_new_item_sub_option_wrapper_'+item_index).append(newRowAdd);
    }

    // Remove options from new item created.
    $("body").on("click", ".remove-new-item-field", function () {
        let remove_button_id_array = $(this).attr('id').split('_');
        let item_id = remove_button_id_array[2];
        $(this).parents("#new_item_sub_option_wrapper_" + item_id).remove();
    });
</script>
@endsection 
