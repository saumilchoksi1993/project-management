<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->boolean('default_available_while_create_project')->default(true);
            $table->timestamps();
        });

        // Create electrical item
        DB::table('items')->insert([
            'name' => 'electrical_item',
            'display_name' => 'Electrical Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $electrc_item_data = DB::table('items')->where('name', 'electrical_item')->first();
        
        // Create options for electrical item
        $electrical_options = [
            'Hard wired smoke alarms with battery backup as per BCA requirements',
            'RCD safety switch',
            'Double power points 15nos',
            'LED down lights 25nos',
            'External Para flood light to rear external doors',
            'Two telephone points',
            'Two TV points',
            'Three Data points',
            'Drop light- Provision only above kitchen BENCHTOP',
            'Exhaust Fan in Bathrooms and Ensuite',
            'Installation of conduit only (for NBN)'
        ];

        Schema::create('items_options', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->longText('name');
            $table->timestamps();
        });

        foreach ($electrical_options as $electrical_option) {
            DB::table('items_options')->insert([
                'item_id' => $electrc_item_data->id,
                'name' => $electrical_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create preliminary work item
        DB::table('items')->insert([
            'name' => 'preliminary_work_item',
            'display_name' => 'Preliminary Work Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $preliminary_work_item = DB::table('items')->where('name', 'preliminary_work_item')->first();

        // Create options for preliminary work item
        $preliminary_work_options = [
            'Site analysis, soil report, Feature survey, title search',
            'HIA/MBA standard contract',
            'Engineered structural drawings and computations',
            'Building permit by registered surveyor',
            'Colour selections and verification of plans',
            'Fixed price agreement (after preliminary Footing report)',
            'Allowance for rock removal and disposal up to $2500',
            'Planning / Building approval/permit (Includes 6-Star Energy rating, Architectural
            drawings including all fees for permit /council to be taken care by Builder)'
        ];

        foreach ($preliminary_work_options as $preliminary_work_option) {
            DB::table('items_options')->insert([
                'item_id' => $preliminary_work_item->id,
                'name' => $preliminary_work_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create site work item
        DB::table('items')->insert([
            'name' => 'site_works_item',
            'display_name' => 'Site Works Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $site_works_item = DB::table('items')->where('name', 'site_works_item')->first();

        // Create options for site work item
        $site_work_options = [
            'Maximum 300mm fall (M Class) with allowance of 150mm uncontrolled fill',
            'Connection of services - Water, Gas, Sewer and Storm water to existing service
            connections.(connection prices supplied by the client)',
            'Recycled water connection',
            'Single phase electricity connection to meter box of up to 12 meters from pit.
            Owner to pay all the utility connections and charges',
            'Provide Part A and Part B termite treatments including termite shields to all
            plumbing penetrations and a reticulated re-treatment system to perimeter of
            house',
            'Temporary fence and driveway protection'
        ];

        foreach ($site_work_options as $site_work_option) {
            DB::table('items_options')->insert([
                'item_id' => $site_works_item->id,
                'name' => $site_work_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create structural item
        DB::table('items')->insert([
            'name' => 'structural_item',
            'display_name' => 'Structural Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $structural_item = DB::table('items')->where('name', 'structural_item')->first();

        // Create options for structural item
        $structural_options = [
            'Engineered Waffle Pod slab',
            'timber framing as per BCA requirements',
            'Timber Trusses as per BCA requirements',
            'B22.5-degree roof pitch with quality tin roof'
        ];

        foreach ($structural_options as $structural_option) {
            DB::table('items_options')->insert([
                'item_id' => $structural_item->id,
                'name' => $structural_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create external finish item
        DB::table('items')->insert([
            'name' => 'external_finishes_item',
            'display_name' => 'External Finishes Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $external_finishes_item = DB::table('items')->where('name', 'external_finishes_item')->first();

        // Create options for external finish item
        $external_finish_options = [
            'Hebel walls',
            'Traditional Facade’s as per drawing(DA approval) including',
            'Garage over build included',
            'Front entry Corinthian Door 2340 *920 mm Madison Range',
            'GAINSBOROUGH OMNI DOOR HANDLE TO ENTRY DOOR',
            'Aluminum windows',
            'Weather door seals to all external doors',
            'sectional Garage door (Dynamic) with 3 remotes (Flat or slimline timber look)',
            'colored concrete Driveway',
            'standard Front landscaping with letter box',
            'back ready for landscaping'
        ];

        foreach ($external_finish_options as $external_finish_option) {
            DB::table('items_options')->insert([
                'item_id' => $external_finishes_item->id,
                'name' => $external_finish_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create Internal finish item
         DB::table('items')->insert([
            'name' => 'internal_finishes_item',
            'display_name' => 'Internal Finishes Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $internal_finishes_item = DB::table('items')->where('name', 'internal_finishes_item')->first();

        // Create options for Internal finish item
        $internal_finishes_options = [
            'Ground floor 2700mm high ceiling throughout',
            'Corinthian 2340mm flush panel or builder range available designer hinged doors',
            'Gainsborough hardware-G2/G4 Series with privacy lock',
            '90 X 18mm MDF skirting/architraves',
            '10mm plasterboard',
            '90mm cove cornice',
            'Builders Tiles up to ceiling height in both (Ensuite and bathroom)',
            'White melamine shelving in robes and linen as per plan',
            'Builders range designer sliding panels to all robes',
            'Insulation as per energy report required',
            'Hybrid flooring to kitchen, living, meal, lounge and open space',
            'Carpet flooring in all bedrooms',
            'Tiles in all wet area (ensuite, bathroom)',
            'Two upgraded bulkheads in the house (Kitchen island bench bulkhead and TV
            bulkhead, max 2m)'
        ];

        foreach ($internal_finishes_options as $internal_finishes_option) {
            DB::table('items_options')->insert([
                'item_id' => $internal_finishes_item->id,
                'name' => $internal_finishes_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create kitchen item
        DB::table('items')->insert([
            'name' => 'kitchen_item',
            'display_name' => 'Kitchen Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $kitchen_item = DB::table('items')->where('name', 'kitchen_item')->first();

        // Create options for kitchen item
        $kitchen_options = [
            '40mm Stone Island bench builder’s range',
            '20mm stone on all benchtop (inc. kitchen, bathroom, ensuite, laundry)',
            'Melamine sheen doors and panels for overhead cupboards as per plan
            with stylish handles as per client selection',
            'PVC edging to all doors /panels',
            'soft closing drawers to the kitchen as per plan',
            'Water point for fridge',
            'Tile Splash back Color TBA by client',
            '900mm stainless steel kitchen appliances (Cooktop, Rangehood) Oven
            900mm-Standard range Euro/Technika brands and dishwasher',
            'Undermount Double bowl stainless steel sink',
            'Stylish chrome flick mixer'
        ];

        foreach ($kitchen_options as $kitchen_option) {
            DB::table('items_options')->insert([
                'item_id' => $kitchen_item->id,
                'name' => $kitchen_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create kitchen Ensuite 2 Bathroom Item
        DB::table('items')->insert([
            'name' => 'ensuite_2_bathroom_item',
            'display_name' => 'Ensuite 2 Bathroom Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $ensuite_2_bathroom_item = DB::table('items')->where('name', 'ensuite_2_bathroom_item')->first();

        // Create options for Ensuite 2 Bathroom Item
        $ensuite_2_bathroom_options = [
            'Tiled shower base as per plan(max shower allow 1200 X 900 and 1800 X 900 as per plan',
            '2000 mm high shower cubical',
            'Semi frameless shower screens',
            'Niche in shower area',
            'Chrome tapware for vanity basins and bath tub',
            'Polished edge mirrors above vanities',
            'Melamine doors and panels with PVC edging',
            'Above counter Quality vanity basins with chrome plug',
            'Towel rails and toilet roll holders as per client’s selection from builder’s range',
        ];

        foreach ($ensuite_2_bathroom_options as $ensuite_2_bathroom_option) {
            DB::table('items_options')->insert([
                'item_id' => $ensuite_2_bathroom_item->id,
                'name' => $ensuite_2_bathroom_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create laundry Item
        DB::table('items')->insert([
            'name' => 'laundry_item',
            'display_name' => 'Laundry Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $laundry_item = DB::table('items')->where('name', 'laundry_item')->first();

        // Create options for laundry Item
        $laundry_options = [
            '45 litres stainless steel inset trough with Chrome mixer tapware',
            'Tiled splashback'
        ];

        foreach ($laundry_options as $laundry_option) {
            DB::table('items_options')->insert([
                'item_id' => $laundry_item->id,
                'name' => $laundry_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create painting item
        DB::table('items')->insert([
            'name' => 'painting_item',
            'display_name' => 'Painting Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $painting_item = DB::table('items')->where('name', 'painting_item')->first();

        // Create options for painting Item
        $painting_options = [
            'Low sheen finish paint, three coats to all internal walls, two coats to ceilings and exterior timber',
            'Gloss finish to all internal doors',
        ];

        foreach ($painting_options as $painting_option) {
            DB::table('items_options')->insert([
                'item_id' => $painting_item->id,
                'name' => $painting_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create heating cooling item
        DB::table('items')->insert([
            'name' => 'heating_cooling_item',
            'display_name' => 'Heating Cooling Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $heating_cooling_item = DB::table('items')->where('name', 'heating_cooling_item')->first();

        // Create options for heating cooling item
        $heating_cooling_options = [
            '12.5 kw Reverse Cycle Unit with 3 zone Estate Requirements limited to',
            'NBN provision in garage',
            'Rainwater tank /Recycled water/ Solar HWS (Not considered)',
            'Bushfire zone requirements (Not Considered)',
            'Flood Zone requirements (Not Considered)',
            'Any feature survey (Not Considered)',
            'Any Insurances / Levies imposed by local council / authorities (Not Considered)'
        ];

        foreach ($heating_cooling_options as $heating_cooling_option) {
            DB::table('items_options')->insert([
                'item_id' => $heating_cooling_item->id,
                'name' => $heating_cooling_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create Turn-key package available item
        DB::table('items')->insert([
            'name' => 'turn_key_package_available_item',
            'display_name' => 'Turn-key Package Available Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $turn_key_package_available_item = DB::table('items')->where('name', 'turn_key_package_available_item')->first();

        // Create options for Turn-key package available item
        $turn_key_package_available_options = [
            'Letterbox',
            'Single builder’s range Blinds',
            'drive away(upto 35m2)',
            'Front standard landscapping',
            'privacy Locks in all bedrooms',
            'cloth line on hebel wall'
        ];

        foreach ($turn_key_package_available_options as $turn_key_package_available_option) {
            DB::table('items_options')->insert([
                'item_id' => $turn_key_package_available_item->id,
                'name' => $turn_key_package_available_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // Create Terms and conditions item
        DB::table('items')->insert([
            'name' => 'terms_and_conditions_item',
            'display_name' => 'Terms And Conditions Item',
            'default_available_while_create_project' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $terms_and_conditions_item = DB::table('items')->where('name', 'terms_and_conditions_item')->first();

        // Create options for Terms and conditions item
        $terms_and_conditions_options = [
            'above all inclusion and estimated quote is valid for 90 days from signing date',
            'on signing of quotation and playing the initial nonrefundable deposit of $3000, the owner hereby authorizes the builder to
            do the following works (prepare preliminary plans, specifications, contracts as per approved plan and conduct contour
            survey and soil test)',
            'builder will inform the client before 15 days and client is responsible to clean the site including all grass if the site is not
            clean cleaning amount will be payable by the owner',
            'above quote is only provisional sales quotation, price may be varied after complete working drawings',
            'the work including materials may vary by agreement under the unforeseen circumstances. a notice describing the
            variation, cost of additional work and any changes to the completion period will be provided to the client',
            'the price of extra work which includes GST will be added to the variation',
            'quote provided is fix site cost up to $11,500 (not bored pier)',
            'During any stage of project in any circumstances like supply shortage, discontinuous of product, etc., client will be
            requiring to reselect the similar product from available options provided by the builder',
            'This quote is subject to DA (developer approval)',
            'This price is lock in for site to be start in 12 months from acceptance of contract'
        ];

        foreach ($terms_and_conditions_options as $terms_and_conditions_option) {
            DB::table('items_options')->insert([
                'item_id' => $terms_and_conditions_item->id,
                'name' => $terms_and_conditions_option,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('items_options');
    }
};
