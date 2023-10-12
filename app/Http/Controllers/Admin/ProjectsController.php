<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Projects;
use App\Items;
use App\ItemOptions;
use App\ProjectVersions;
use App\ProjectItems;
use App\ProjectItemOptions;
use PDF;

class ProjectsController extends Controller
{
     /**
    *
    * allow admin only
    *
    */
    public function __construct() {
        //$this->middleware(['role:admin|creator']);
        $this->middleware(['role:admin']);
    }

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = [];

        // Get all approved projects.
        $approved_projects = Projects::with('project_versions', 'project_versions.project_version_items', 'project_versions.project_version_items.project_version_items_options')
            ->whereHas('project_versions', function ($query) {
                $query->where('project_versions.status', 'approved');
            })
            ->get();

        // Get last version of approved projects.
        if($approved_projects && count($approved_projects) > 0) {
            foreach ($approved_projects as $project_data) {
                if(isset($project_data->project_versions) && count($project_data->project_versions) > 0) {
                    $i = 0;
                    $project_versions_count = count($project_data->project_versions);
                    foreach ($project_data->project_versions as $key => $project_version) {
                        if ($i == $project_versions_count - 1) {
                            $projects[] = $project_version;
                        }

                        $i++;
                    }
                }
            }
        }

        return view('admin.projects.index', compact('projects'));
    }
    
    public function create()
    {
        $items_data = Items::with('itemOptions')->where('default_available_while_create_project', true)->get();

        return view('admin.projects.create',compact('items_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            //'client_email' => ['required', 'string', 'email', 'max:255', 'unique:projects'],
        ]);

        $request_data = [
            'name' => $request->name,
            'owner_address' => $request->owner_address,
            'dwelling_description' => $request->dwelling_description,
            'builder_address' => $request->builder_address,
            'site_address' => $request->site_address,
            'client_name' => $request->client_name,
            'client_address' => $request->client_address,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'extra_inclusions_variation_price' => $request->extra_inclusions_variation_price,
            'contract_price' => $request->contract_price,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $project = Projects::create($request_data);

        $project_version = ProjectVersions::create([
            'project_id' => $project->id,
            'version_number' => 1,
            'name' => $project->name,
            'owner_address' => $project->owner_address,
            'dwelling_description' => $project->dwelling_description,
            'builder_address' => $project->builder_address,
            'site_address' => $project->site_address,
            'client_name' => $project->client_name,
            'client_address' => $request->client_address,
            'client_email' => $project->client_email,
            'client_phone' => $project->client_phone,
            'extra_inclusions_variation_price' => $project->extra_inclusions_variation_price,
            'contract_price' => $project->contract_price,
            'status' => 'approved',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // Handle for existing items.
        if(isset($request->items) && count($request->items) > 0 ){
            foreach ($request->items as $item_name => $item) {
                $item_data = Items::where('name', $item_name)->first();
                if($item_data) {
                    // Associate project items.
                    $project_items_created = ProjectItems::create([
                        'project_id' => $project->id,
                        'project_version_id' => $project_version->id,
                        'item_id' => $item_data->id,
                        'notes' => isset($item['input_note']) ? $item['input_note'] : null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    // Associate project item options.
                    if(isset($item['existing_options']) && count($item['existing_options']) > 0) {
                        foreach ($item['existing_options'] as $option_key => $option) {
                            ProjectItemOptions::create([
                                'project_id' => $project->id,
                                'project_version_id' => $project_version->id,
                                'project_items_id' => $project_items_created->id,
                                'item_id' => $item_data->id,
                                'item_option_id' => $option,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                    }
                    // Create new item options and associate that option with project.
                    if(isset($item['new_options']) && count($item['new_options']) > 0) {
                        foreach ($item['new_options'] as $new_option_key => $new_option) {
                            $item_option_exists = ItemOptions::where('name', $new_option)->first();

                            if(!$item_option_exists) {
                                // Create new item option.
                                $item_option_exists = ItemOptions::create([
                                    'item_id' => $item_data->id,
                                    'name' => $new_option,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                            }

                            if($item_option_exists) {
                                ProjectItemOptions::create([
                                    'project_id' => $project->id,
                                    'project_version_id' => $project_version->id,
                                    'project_items_id' => $project_items_created->id,
                                    'item_id' => $item_data->id,
                                    'item_option_id' => $item_option_exists->id,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                            }
                        }
                    }
                }
            }
        }

        // Handle for new items with options.
        if(isset($request->new_items) && count($request->new_items) > 0 ){
            foreach ($request->new_items as $new_item_key => $new_item) {
                $new_item_data = Items::where('name', $new_item['name'])->first();

                // If item not exists -> create new item.
                if(!$new_item_data) {
                    $new_item_data = Items::create([
                        'name' => strtolower(str_replace(' ', '_', $new_item['name'])),
                        'display_name' => $new_item['name'],
                        'default_available_while_create_project' => false,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }

                if($new_item_data) {
                    // Associate project items.
                    $project_items_created = ProjectItems::create([
                        'project_id' => $project->id,
                        'project_version_id' => $project_version->id,
                        'item_id' => $new_item_data->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    // Create new item options and associate that option with project.
                    if(isset($new_item['new_options']) && count($new_item['new_options']) > 0) {
                        foreach ($new_item['new_options'] as $new_item_option) {
                            $new_item_option_exists = ItemOptions::where('name', $new_item_option)->first();

                            if(!$new_item_option_exists) {
                                // Create new item option.
                                $new_item_option_exists = ItemOptions::create([
                                    'item_id' => $new_item_data->id,
                                    'name' => $new_item_option,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                            }

                            if($new_item_option_exists) {
                                ProjectItemOptions::create([
                                    'project_id' => $project->id,
                                    'project_version_id' => $project_version->id,
                                    'project_items_id' => $project_items_created->id,
                                    'item_id' => $new_item_data->id,
                                    'item_option_id' => $new_item_option_exists->id,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()->route('projects.index')->with('success', "The $project->name was saved successfully");
    }

     /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get default items.
        $default_items_data = Items::with('itemOptions')->where('default_available_while_create_project', true)->get();

        $project_data = Projects::with('project_versions', 'project_versions.project_version_items', 'project_versions.project_version_items.project_version_items_options')
            ->where('id' ,$id)
            ->whereHas('project_versions', function ($query) {
                $query->where('project_versions.status', 'approved');
            })
            ->orderBy('created_at', 'desc')
            ->first();

        $project = [];
        $custom_items_data = [];
        if($project_data) {
            if(isset($project_data->project_versions) && count($project_data->project_versions) > 0) {
                $i = 0;
                $project_versions_count = count($project_data->project_versions);
                foreach ($project_data->project_versions as $key => $project_version) {
                    if ($i == $project_versions_count - 1) {
                        $project['edit_approved_project'] = $project_version;
                        if($project_version->project_version_items && count($project_version->project_version_items) > 0) {
                            foreach ($project_version->project_version_items as $custom_item) {
                                $item_with_options = Items::with('itemOptions')->where('id', $custom_item->item_id)->first();
                                if($item_with_options && !$item_with_options->default_available_while_create_project) {
                                    $custom_items_data[] = $item_with_options;
                                }
                            }
                        }
                    }

                    $i++;
                }
            }
        }

        $default_items_data = $default_items_data->merge($custom_items_data);

        return view('admin.projects.edit', compact('project', 'default_items_data'));
    }

    public function show($id)
    {
        $project_data = Projects::with('project_versions', 'project_versions.project_version_items', 'project_versions.project_version_items.project_version_items_options')
            ->where('id' ,$id)
            ->whereHas('project_versions', function ($query) {
                $query->where('project_versions.status', 'approved');
            })
            ->first();

        $project = [];
        if($project_data) {
            if(isset($project_data->project_versions) && count($project_data->project_versions) > 0) {
                $i = 0;
                $project_versions_count = count($project_data->project_versions);
                foreach ($project_data->project_versions as $key => $project_version) {
                    if ($i == $project_versions_count - 1) {
                        $project['approved_project'] = $project_version;
                    }
                    if($key > 0) {
                        if($project_version->name != $project_data->project_versions[$key-1]->name) {
                            $project['version_history'][$project_version->version_number]['name']['old'] = $project_data->project_versions[$key-1]->name;
                            $project['version_history'][$project_version->version_number]['name']['new'] = $project_version->name;
                        }
                        if($project_version->client_name != $project_data->project_versions[$key-1]->client_name) {
                            $project['version_history'][$project_version->version_number]['client_name']['old'] = $project_data->project_versions[$key-1]->client_name;
                            $project['version_history'][$project_version->version_number]['client_name']['new'] = $project_version->client_name;
                        }
                        if($project_version->client_address != $project_data->project_versions[$key-1]->client_address) {
                            $project['version_history'][$project_version->version_number]['client_address']['old'] = $project_data->project_versions[$key-1]->client_address;
                            $project['version_history'][$project_version->version_number]['client_address']['new'] = $project_version->client_address;
                        }
                        if($project_version->client_email != $project_data->project_versions[$key-1]->client_email) {
                            $project['version_history'][$project_version->version_number]['client_email']['old'] = $project_data->project_versions[$key-1]->client_email;
                            $project['version_history'][$project_version->version_number]['client_email']['new'] = $project_version->client_email;
                        }
                        if($project_version->client_phone != $project_data->project_versions[$key-1]->client_phone) {
                            $project['version_history'][$project_version->version_number]['client_phone']['old'] = $project_data->project_versions[$key-1]->client_phone;
                            $project['version_history'][$project_version->version_number]['client_phone']['new'] = $project_version->client_phone;
                        }
                        if($project_version->owner_address != $project_data->project_versions[$key-1]->owner_address) {
                            $project['version_history'][$project_version->version_number]['owner_address']['old'] = $project_data->project_versions[$key-1]->owner_address;
                            $project['version_history'][$project_version->version_number]['owner_address']['new'] = $project_version->owner_address;
                        }
                        if($project_version->dwelling_description != $project_data->project_versions[$key-1]->dwelling_description) {
                            $project['version_history'][$project_version->version_number]['dwelling_description']['old'] = $project_data->project_versions[$key-1]->dwelling_description;
                            $project['version_history'][$project_version->version_number]['dwelling_description']['new'] = $project_version->dwelling_description;
                        }
                        if($project_version->builder_address != $project_data->project_versions[$key-1]->builder_address) {
                            $project['version_history'][$project_version->version_number]['builder_address']['old'] = $project_data->project_versions[$key-1]->builder_address;
                            $project['version_history'][$project_version->version_number]['builder_address']['new'] = $project_version->builder_address;
                        }
                        if($project_version->site_address != $project_data->project_versions[$key-1]->site_address) {
                            $project['version_history'][$project_version->version_number]['site_address']['old'] = $project_data->project_versions[$key-1]->site_address;
                            $project['version_history'][$project_version->version_number]['site_address']['new'] = $project_version->site_address;
                        }
                        if($project_version->contract_price != $project_data->project_versions[$key-1]->contract_price) {
                            $project['version_history'][$project_version->version_number]['contract_price']['old'] = $project_data->project_versions[$key-1]->contract_price;
                            $project['version_history'][$project_version->version_number]['contract_price']['new'] = $project_version->contract_price;
                        }
                        if($project_version->extra_inclusions_variation_price != $project_data->project_versions[$key-1]->extra_inclusions_variation_price) {
                            $project['version_history'][$project_version->version_number]['extra_inclusions_variation_price']['old'] = $project_data->project_versions[$key-1]->extra_inclusions_variation_price;
                            $project['version_history'][$project_version->version_number]['extra_inclusions_variation_price']['new'] = $project_version->extra_inclusions_variation_price;
                        }
                        if($project_version->project_version_items && count($project_version->project_version_items)) {
                            foreach ($project_version->project_version_items as $project_item) {
                                $old_item_data = $project_data->project_versions[$key-1]->project_version_items->where('item_id', $project_item->item_id)->first();
                                if($old_item_data) {
                                    // Item exists in previous version.
                                    if(count($project_item->project_version_items_options) != count($old_item_data->project_version_items_options)) {
                                        // Item update.
                                        $project['version_history'][$project_version->version_number]['existing_items'][$project_item->item_id]['old'] = $old_item_data;
                                        $project['version_history'][$project_version->version_number]['existing_items'][$project_item->item_id]['new'] = $project_item;
                                        continue;
                                    } else {
                                        // Check any option change or not.
                                        foreach ($project_item->project_version_items_options as $option_data) {
                                            $old_option_data = $old_item_data->project_version_items_options->where('item_option_id', $option_data->item_option_id)->first();
                                            if(!$old_option_data) {
                                                // New option added
                                                $project['version_history'][$project_version->version_number]['existing_items'][$project_item->item_id]['old'] = $old_item_data;
                                                $project['version_history'][$project_version->version_number]['existing_items'][$project_item->item_id]['new'] = $project_item;
                                                break;
                                            }
                                        }
                                    }
                                } else {
                                    // New item added.
                                    $project['version_history'][$project_version->version_number]['existing_items'][$project_item->item_id]['old'] = null;
                                    $project['version_history'][$project_version->version_number]['existing_items'][$project_item->item_id]['new'] = $project_item;
                                    continue;
                                }                                
                            }
                        }
                    }

                    $i++;
                }
            }
        }
        //dd($project['version_history']);
        return view('admin.projects.show', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $project = Projects::findOrFail($id);

        // Get last version number of this project.
        $last_version_for_this_project = ProjectVersions::where('project_id', $id)->orderBy('id', 'desc')->first();
        $last_version_number_for_this_project = ($last_version_for_this_project) ? $last_version_for_this_project->version_number : 0;

        // Create new version of project.
        $project_version = ProjectVersions::create([
            'project_id' => $project->id,
            'version_number' => $last_version_number_for_this_project + 1,
            'name' => $request->name,
            'owner_address' => $request->owner_address,
            'dwelling_description' => $request->dwelling_description,
            'builder_address' => $request->builder_address,
            'site_address' => $request->site_address,
            'client_name' => $request->client_name,
            'client_address' => $request->client_address,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'extra_inclusions_variation_price' => $request->extra_inclusions_variation_price,
            'contract_price' => $request->contract_price,
            'status' => 'approved',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if(isset($request->items) && count($request->items) > 0 ) {
            foreach ($request->items as $item_name => $item) {
                $item_data = Items::where('name', $item_name)->first();
                if($item_data) {
                    // Associate project items.
                    $project_items_created = ProjectItems::create([
                        'project_id' => $project->id,
                        'project_version_id' => $project_version->id,
                        'item_id' => $item_data->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    // Associate project item options.
                    if(isset($item['existing_options']) && count($item['existing_options']) > 0) {
                        foreach ($item['existing_options'] as $option_key => $option) {
                            ProjectItemOptions::create([
                                'project_id' => $project->id,
                                'project_version_id' => $project_version->id,
                                'project_items_id' => $project_items_created->id,
                                'item_id' => $item_data->id,
                                'item_option_id' => $option,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                    }
                    // Create new item options and associate that option with project.
                    if(isset($item['new_options']) && count($item['new_options']) > 0) {
                        foreach ($item['new_options'] as $new_option_key => $new_option) {
                            $item_option_exists = ItemOptions::where('name', $new_option)->first();

                            if(!$item_option_exists) {
                                // Create new item option.
                                $item_option_exists = ItemOptions::create([
                                    'item_id' => $item_data->id,
                                    'name' => $new_option,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                            }

                            if($item_option_exists) {
                                ProjectItemOptions::create([
                                    'project_id' => $project->id,
                                    'project_version_id' => $project_version->id,
                                    'project_items_id' => $project_items_created->id,
                                    'item_id' => $item_data->id,
                                    'item_option_id' => $item_option_exists->id,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                            }
                        }
                    }
                }
            }
        }

        // Handle for new items with options.
        if(isset($request->new_items) && count($request->new_items) > 0 ) {
            foreach ($request->new_items as $new_item_key => $new_item) {
                $new_item_data = Items::where('name', $new_item['name'])->first();

                // If item not exists -> create new item.
                if(!$new_item_data) {
                    $new_item_data = Items::create([
                        'name' => strtolower(str_replace(' ', '_', $new_item['name'])),
                        'display_name' => $new_item['name'],
                        'default_available_while_create_project' => false,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }

                if($new_item_data) {
                    // Associate project items.
                    $project_items_created = ProjectItems::create([
                        'project_id' => $project->id,
                        'project_version_id' => $project_version->id,
                        'item_id' => $new_item_data->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    // Create new item options and associate that option with project.
                    if(isset($new_item['new_options']) && count($new_item['new_options']) > 0) {
                        foreach ($new_item['new_options'] as $new_item_option) {
                            $new_item_option_exists = ItemOptions::where('name', $new_item_option)->first();

                            if(!$new_item_option_exists) {
                                // Create new item option.
                                $new_item_option_exists = ItemOptions::create([
                                    'item_id' => $new_item_data->id,
                                    'name' => $new_item_option,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                            }

                            if($new_item_option_exists) {
                                ProjectItemOptions::create([
                                    'project_id' => $project->id,
                                    'project_version_id' => $project_version->id,
                                    'project_items_id' => $project_items_created->id,
                                    'item_id' => $new_item_data->id,
                                    'item_option_id' => $new_item_option_exists->id,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()->route('projects.index')->with('warning', "The $project->name was updated successfully");
    }

    public function destroy($id)
    {
        $project = Projects::with('project_versions', 'project_versions.project_version_items', 'project_versions.project_version_items.project_version_items_options')
            ->whereHas('project_versions', function ($query) {
                $query->where('project_versions.status', 'approved');
            })
            ->where('id', $id)
            ->first();
        if($project) {
            if(isset($project->project_versions) && count($project->project_versions) > 0) {
                foreach ($project->project_versions as $project_version) {
                    if($project_version->project_version_items && count($project_version->project_version_items) > 0) {
                        foreach ($project_version->project_version_items as $project_item) {
                            if($project_item && count($project_item->project_version_items_options) > 0) {
                                foreach ($project_item->project_version_items_options as $project_item_option) {
                                    // Project Item Options delete.
                                    $project_item_option->delete();
                                }
                            }
                            // Project Items delete.
                            $project_item->delete();
                        }
                    }
                    // Delete Project Versions.
                    $project_version->delete();
                }
            }
        }

        // Delete entry from project table
        $project->delete();

        return redirect()->route('projects.index')->with('danger', "The $project->name was deleted successfully");
    }

    public function projectPDFDownload($id)
    {
        $project_data = Projects::with('project_versions', 'project_versions.project_version_items', 'project_versions.project_version_items.project_version_items_options')
            ->where('id' ,$id)
            ->whereHas('project_versions', function ($query) {
                $query->where('project_versions.status', 'approved');
            })
            ->first();

        $project = [];
        if($project_data) {
            if(isset($project_data->project_versions) && count($project_data->project_versions) > 0) {
                $i = 0;
                $project_versions_count = count($project_data->project_versions);
                foreach ($project_data->project_versions as $key => $project_version) {
                    if ($i == $project_versions_count - 1) {
                        $project['latest_approved_project'] = $project_version;
                    }

                    $i++;
                }
            }
        }

        $pdf = PDF::loadView('pdf_download', compact('project'));

        return $pdf->download('project.pdf');
    }
}
