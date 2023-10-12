@extends('home')

@section('title')
	Project
@endsection

@section('extra-css')
@endsection

@section('index')
<div class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="">
                    <h3>Projects</h3>
                    <a href="{{route('projects.create')}}" class="btn btn-success btn-sm">Add New Project</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dt-mant-table">
                            <thead>
                                <tr class="text-left">
                                    <th>Name</th>
                                    <th>Site Address</th>
                                    <th>Contract Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                    <tr class="text-left">
                                        <td>{{ $project->name }}</td>
                                        <td>{{ $project->site_address }}</td>
                                        <td>{{ $project->contract_price }}</td>
                                        <td class="text-center">
                                            <div style="display:inline-flex;">
                                                <a href="{{route('projects.edit',$project->project_id)}}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{route('projects.show',$project->project_id)}}" class="btn btn-info btn-sm ml-1">View</a>
                                                &nbsp;
                                                <form id="delete_form{{$project->project_id}}" method="POST" action="{{ route('projects.destroy',$project->project_id) }}" onclick="return confirm('Are you sure?')">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                                </form>
                                                <a class="btn btn-success btn-sm ml-1" href="{{ route('download.pdf', ['id' => $project->project_id]) }}"><i class="fa fa-download"></i>PDF</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-script')

@endsection
