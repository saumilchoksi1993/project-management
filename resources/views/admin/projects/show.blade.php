@extends('home')

@section('title')
    View Project
@endsection

@section('extra-css')
<style>
    ul {
        margin-bottom: 10px !important;
    }
</style>
@endsection

@section('index')
        <div class="content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div>
                            <h3>
                                View Project Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dt-mant-table">
                                    <tbody style="font-size: 14px;">
                                        <tr class="text-left">
                                            <td><b>Project Name</b></td>
                                            <td>
                                                <div class="ml-4">
                                                    {{ $project['approved_project']->name }}
                                                </div>
                                            </td>
                                        </tr>
                                        @if($project['approved_project']->client_name)
                                            <tr class="text-left">
                                                <td><b>Client Name</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->client_name }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($project['approved_project']->client_address)
                                            <tr class="text-left">
                                                <td><b>Client Address</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->client_address }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($project['approved_project']->client_email)
                                            <tr class="text-left">
                                                <td><b>Client Email</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->client_email }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($project['approved_project']->client_phone)
                                            <tr class="text-left">
                                                <td><b>Client Phone</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->client_phone }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($project['approved_project']->owner_address)
                                            <tr class="text-left">
                                                <td><b>Owner Address</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->owner_address }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($project['approved_project']->dwelling_description)
                                            <tr class="text-left">
                                                <td><b>Dwelling Description</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->dwelling_description }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($project['approved_project']->builder_address)
                                            <tr class="text-left">
                                                <td><b>Builder Address</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->builder_address }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($project['approved_project']->site_address)
                                            <tr class="text-left">
                                                <td><b>Site Address</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->site_address }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($project['approved_project']->contract_price)
                                            <tr class="text-left">
                                                <td><b>Contract Price</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->contract_price }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($project['approved_project']->extra_inclusions_variation_price)
                                            <tr class="text-left">
                                                <td><b>Extra inclusions variation price</b></td>
                                                <td>
                                                    <div class="ml-4">
                                                        {{ $project['approved_project']->extra_inclusions_variation_price }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @if(isset($project['approved_project']->project_version_items) && count($project['approved_project']->project_version_items) > 0)
                                            @foreach($project['approved_project']->project_version_items as $item)
                                                <tr class="text-left">
                                                    <td><b>{{ $item->item_display_name }}</b></td>
                                                    @if(isset($item->project_version_items_options) && count($item->project_version_items_options) > 0)
                                                        <td>
                                                            @foreach($item->project_version_items_options as $option)
                                                                <ul>
                                                                    <li> 
                                                                        {{ $option->option_name }} 
                                                                    </li>
                                                                </ul>
                                                            @endforeach
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if($project['version_history'] && count($project['version_history']) > 0)
                                <div>
                                    <h3>
                                        Project Versions History
                                    </h3>
                                </div>
                                @foreach($project['version_history'] as $project_version_number => $project_version_data)
                                    <div class="mt-2">
                                        <h6>Version-{{ $project_version_number - 1 }} Changes</h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dt-mant-table">
                                            <tbody style="font-size: 14px;">
                                                @if(isset($project_version_data['name']))
                                                    <tr class="text-left">
                                                        <td><b>Project Name</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['name']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['name']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['client_name']))
                                                    <tr class="text-left">
                                                        <td><b>Client Name</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['client_name']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['client_name']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['client_address']))
                                                    <tr class="text-left">
                                                        <td><b>Client Address</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['client_address']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['client_address']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['client_email']))
                                                    <tr class="text-left">
                                                        <td><b>Client Email</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['client_email']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['client_email']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['client_phone']))
                                                    <tr class="text-left">
                                                        <td><b>Client Phone</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['client_phone']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['client_phone']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['owner_address']))
                                                    <tr class="text-left">
                                                        <td><b>Owner Address</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['owner_address']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['owner_address']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['dwelling_description']))
                                                    <tr class="text-left">
                                                        <td><b>Dwelling Description</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['dwelling_description']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['dwelling_description']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['builder_address']))
                                                    <tr class="text-left">
                                                        <td><b>Builder Address</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['builder_address']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['builder_address']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['site_address']))
                                                    <tr class="text-left">
                                                        <td><b>Site Address</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['site_address']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['site_address']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['contract_price']))
                                                    <tr class="text-left">
                                                        <td><b>Contract Price</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['contract_price']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['contract_price']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['extra_inclusions_variation_price']))
                                                    <tr class="text-left">
                                                        <td><b>Extra inclusions variation price</b></td>
                                                        <td>
                                                            <div class="ml-4">
                                                                <ul>
                                                                    <li><b>Old:</b> {{ $project_version_data['extra_inclusions_variation_price']['old'] }}
                                                                    </li>
                                                                    <li><b>New:</b> {{ $project_version_data['extra_inclusions_variation_price']['new'] }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if(isset($project_version_data['existing_items']) && count($project_version_data['existing_items']) > 0)
                                                    @foreach($project_version_data['existing_items'] as $item_data)
                                                        <tr class="text-left">
                                                            <td><b>{{ $item_data['new']->item_display_name }}</b></td>
                                                            @if(isset($item_data['new']->project_version_items_options) && count($item_data['new']->project_version_items_options) > 0)
                                                                <td>
                                                                    <ul>
                                                                        <li> 
                                                                            <b>Old</b>
                                                                        </li>
                                                                        @if(isset($item_data['old']->project_version_items_options) && count($item_data['old']->project_version_items_options) > 0)
                                                                            @foreach($item_data['old']->project_version_items_options as $option)
                                                                                <ul>
                                                                                    <li> 
                                                                                        {{ $option->option_name }} 
                                                                                    </li>
                                                                                </ul>
                                                                            @endforeach
                                                                        @endif
                                                                        <li> 
                                                                            <b>New</b>
                                                                        </li>
                                                                        @if(isset($item_data['new']->project_version_items_options) && count($item_data['new']->project_version_items_options) > 0)
                                                                            @foreach($item_data['new']->project_version_items_options as $option)
                                                                                <ul>
                                                                                    <li> 
                                                                                        {{ $option->option_name }} 
                                                                                    </li>
                                                                                </ul>
                                                                            @endforeach
                                                                        @endif
                                                                    </ul>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>  
                </div>
            </div>
        </div>
@endsection

@section('extra-script')

@endsection
