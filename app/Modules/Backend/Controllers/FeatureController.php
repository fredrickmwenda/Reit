<?php


namespace App\Modules\Backend\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index(){
        $features = Feature::all();
        return view('Backend::screens.admin.subscriptions.features.index', compact('features'));
    }

    public function create(){
        return view('Backend::screens.admin.subscriptions.features.new');
    }

    public function store(Request $request){
        $consumable = $request->has('consumable') ? true : false;
        $quota = $request->has('quota') ? true : false;
    
        // Create a Feature
        Feature::create([
            'name' => $request->input('name'),
            'consumable' => $consumable,
            'quota' => $quota,
            // Other fields...
        ]);

        // return [
        //     'status' => 'success',
        //     'message' => __('Feature created succcessfully.'),
        // ];

        
        return redirect()->route('feature.index')->with('message', ' Feature created succcessfully');

    }

    public function edit($id){
        $feature = Feature::find($id);

        return view('Backend::screens.admin.subscriptions.features.edit', compact('feature'));

    }

    public function update(Request $request, $id){
        $feature = Feature::findOrFail($id);
    
        $consumable = $request->has('consumable') ? true : false;
        $quota = $request->has('quota') ? true : false;
    
        // Update the Feature
        $feature->update([
            'name' => $request->input('name'),
            'consumable' => $consumable,
            'quota' => $quota,
            // Other fields...
        ]);
    
        return redirect()->route('feature.index')->with('message', ' Feature updated succcessfully');

    }
    
}
