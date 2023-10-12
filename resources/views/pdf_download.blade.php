<html>
<head>
    <title>Test</title>
</head>
<body>
    <div class="page-border"></div>
    <div class="page">
        <div class="" style="margin: 40px 40px 40px 40px;">
            <div style="font-size: 27px;margin-top: 50px; text-align: center;">PROJECT INCLUSIONS</div>
            <hr>
            <table cellspacing="0" border="1" style="width:100%;margin-top: 50px;font-size:40px">
                <tbody style="font-size: 14px;">
                    <tr class="text-left">
                        <td style="width:35%;">Project Name</td>
                        <td style="width:65%;">
                            {{ $project['latest_approved_project']->name }}
                        </td>
                    </tr>
                    @if($project['latest_approved_project']->client_name)
                        <tr class="text-left">
                            <td style="width:35%;">Client Name</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->client_name }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->client_address)
                        <tr class="text-left">
                            <td style="width:35%;">Client Address</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->client_address }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->client_email)
                        <tr class="text-left">
                            <td style="width:35%;">Client Email</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->client_email }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->client_phone)
                        <tr class="text-left">
                            <td style="width:35%;">Client Phone</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->client_phone }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->owner_address)
                        <tr class="text-left">
                            <td style="width:35%;">Owner Address</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->owner_address }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->dwelling_description)
                        <tr class="text-left">
                            <td style="width:35%;">Dwelling Description</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->dwelling_description }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->builder_address)
                        <tr class="text-left">
                            <td style="width:35%;">Builder Address</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->builder_address }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->site_address)
                        <tr class="text-left">
                            <td style="width:35%;">Site Address</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->site_address }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->contract_price)
                        <tr class="text-left">
                            <td style="width:35%;">Contract Price</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->contract_price }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->extra_inclusions_variation_price)
                        <tr class="text-left">
                            <td style="width:35%;">Extra inclusions variation price</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->extra_inclusions_variation_price }}
                            </td>
                        </tr>
                    @endif
                    @if($project['latest_approved_project']->extra_inclusions_variation_price || $project['latest_approved_project']->contract_price)
                        <tr class="text-left">
                            <td style="width:35%;">Total price</td>
                            <td style="width:65%;">
                                {{ $project['latest_approved_project']->extra_inclusions_variation_price + $project['latest_approved_project']->contract_price }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div style="margin-top: 50px;margin-bottom: 50px;font-style: italic;"><b>These Project Inclusions in conjunction with the drawings form a part of the Building Contract.</b></div>
            <div style="text-decoration:underline;margin-bottom: 20px;"><b>Signatures</b></div>
            <div style="width: 100%;margin-top: 25px;">
                <div style="width: 50%; float: left;">
                    OWNER(s):
                </div>
                <div style="margin-left: 50%;">
                    DATE:
                </div>
            </div>
            <hr style="border-top: 0.5px solid #333;color:#333;background-color:#333;">
            <div style="width: 100%;margin-top: 50px;">
                <div style="width: 50%; float: left;">
                    BUILDER:
                </div>
                <div style="margin-left: 50%;">
                    DATE:
                </div>
            </div>
            <hr style="border-top: 0.5px solid #333;color:#333;background-color:#333;">

            <div class="page-break"></div>
            <div style="font-size: 27px;margin-top: 50px;">INCLUSIONS LIST</div>
            <hr>
            @if(isset($project['latest_approved_project']->project_version_items) && count($project['latest_approved_project']->project_version_items) > 0)
                @foreach($project['latest_approved_project']->project_version_items as $item)
                    <div style="margin-top: 25px;">
                        <div><b>{{$item->item_display_name}}</b></div>
                        <div>
                            @if(isset($item->project_version_items_options) && count($item->project_version_items_options) > 0)
                                @foreach($item->project_version_items_options as $item_option)
                                <ul>
                                    <li>{{ $item_option->option_name }}</li>
                                </ul>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
            <div style="text-decoration:underline;margin-top: 50px;"><b>Signatures</b></div>
            <div style="width: 100%;margin-top: 25px;">
                <div style="width: 50%; float: left;">
                    Sales Consultant:
                </div>
                <div style="margin-left: 50%;">
                    DATE:
                </div>
            </div>
            <div style="width: 100%;margin-top: 25px;">
                <div style="width: 50%; float: left;">
                    Client 1:
                </div>
                <div style="margin-left: 50%;">
                    DATE:
                </div>
            </div>
            <div style="width: 100%;margin-top: 25px;">
                <div style="width: 50%; float: left;">
                    Client 2:
                </div>
                <div style="margin-left: 50%;">
                    DATE:
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<style>
    .page-border {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
        border: 1px solid blue;
    }
    ul {
        margin-bottom: 10px !important;
    }
    hr {
        color: blue;
        border-top: 1px;
    }
    th, td {
        padding: 5px;
    }
    .page-break {
        page-break-after: always;
    }
</style>