<?php

namespace App\Helpers;

class ProjectHelpers {
    public static function checkItemOptionSelectedForProject($item, $item_option_id, $project) {
        if($project->project_version_items && count($project->project_version_items) > 0) {
            foreach ($project->project_version_items as $item_data) {
                if($item_data->item_id == $item->id) {
                    if($item_data->project_version_items_options && count($item_data->project_version_items_options) > 0) {
                        foreach ($item_data->project_version_items_options as $selected_option) {
                            if($selected_option->item_option_id == $item_option_id) {
                                return true;
                                break;
                            }
                        }
                    }
                }
            }
        }

        return false;
    }
}