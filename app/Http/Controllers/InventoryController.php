<?php

namespace App\Http\Controllers;

use App\ProductClaim;
use App\UserProfile;
use Bregananta\Inventory\Models\Category;
use Bregananta\Inventory\Models\InventoryStock;
use Bregananta\Inventory\Models\Location;
use Bregananta\Inventory\Models\Metric;
use Bregananta\Inventory\Models\Inventory;
use Bregananta\Inventory\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class InventoryController extends Controller
{
    /*
    * Holds the inventory model
    *
    * @var Inventory
    */
    protected $inventory;

    public function __construct(Inventory $inventory)
    {
        $this->inventory = $inventory;

        $this->middleware(function ($request, $next) {
            //  contruct parent
            parent::__construct();
            //  only admin
            if($this->isLoggedIn && $this->isAdmin) {
                $this->initC(true);
                return $next($request);
            } elseif ($this->isLoggedIn && $this->user->isMember()) {
                return redirect()->route('dashboard');
            }
            // logout user, karena jika melalui hanya bisa method post, maka controllernya kita gunakan
            return (new \App\Http\Controllers\Auth\LoginController)->logout($request);
        });
    }

    /*
     * Inventory Setting : Show Metric List
     */
    public function getMetric()
    {
        $this->setPageHeader('Inventory', 'Metrics List');
        $metrics = Metric::all();
        return view('admin.inventory.metric')
            ->with('metrics', $metrics);
    }

    /*
     * Inventory Setting : Show Metric Input Form
     * @mode = new / update --> 1 = new data input, 2 = update existing data
     * @id = id of data to be update
     */
    public function getMetricForm($mode = 1, $id = null)
    {
        $subtitle = ($mode==1) ? 'Add New Metric' : 'Edit Metric';
        $this->setPageHeader('Inventory', 'Metrics Form : '. $subtitle);

        $data = Metric::find($id);
        return view('admin.inventory.metricform')
            ->with('subtitle',$subtitle)
            ->with('data',$data)
            ->with('mode',$mode);
    }

    /*
     * Inventory Setting : Metric Form POST data
     * @request : form data
     */
    public function postMetricForm(Request $request)
    {
        if ($request['mode']==1) {
            $validator = Validator::make($request->all(), [
                'metricname' => 'required|unique:tb_inventory_metrics,name|max:50',
                'metricsymbol' => 'required|unique:tb_inventory_metrics,symbol|max:10',
            ]);
        } elseif ($request['mode']==2) {
            $validator = Validator::make($request->all(), [
                'metricname' => 'required|unique:tb_inventory_metrics,name,'. $request['id'] .'|max:50',
                'metricsymbol' => 'required|unique:tb_inventory_metrics,symbol,'. $request['id'] .'|max:10',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $metric = new Metric();
        if ($request['mode']==1) {
            $metric->user_id = Auth::id();
            $metric->name = $request['metricname'];
            $metric->symbol = $request['metricsymbol'];
            $metric->save();
        } elseif ($request['mode']==2) {
            $data = $metric->find($request['id']);
            $data->user_id = Auth::id();
            $data->name = $request['metricname'];
            $data->symbol = $request['metricsymbol'];
            $data->save();
        }

        return redirect('admin/inventory/metric');

    }

    /*
     * Inventory Setting : Show Category List
     */
    public function getCategory()
    {
        $this->setPageHeader('Inventory', 'Category List');
        $categories = Category::all();
        return view('admin.inventory.category')
            ->with('categories', $categories);
    }

    /*
     * Inventory Setting : Show Category Input Form
     * @mode = new / update --> 1 = new data input, 2 = update existing data
     * @id = id of data to be update
     */
    public function getCategoryForm($mode = 1, $id = null)
    {
        $subtitle = ($mode==1) ? 'Add New Category' : 'Edit Category';
        $this->setPageHeader('Inventory', 'Category Form : '. $subtitle);

        $data = Category::find($id);
        return view('admin.inventory.categoryform')
            ->with('subtitle',$subtitle)
            ->with('data',$data)
            ->with('mode',$mode);
    }

    /*
     * Inventory Setting : Category Form POST data
     * @request : form data
     */
    public function postCategoryForm(Request $request)
    {
        if ($request['mode']==1) {
            $validator = Validator::make($request->all(), [
                'categoryname' => 'required|unique:tb_inventory_categories,name|max:50',
            ]);
        } elseif ($request['mode']==2) {
            $validator = Validator::make($request->all(), [
                'categoryname' => 'required|unique:tb_inventory_categories,name,'. $request['id'] .'|max:50',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = new Category();
        if ($request['mode']==1) {
            $category->name = $request['categoryname'];
            $category->save();
        } elseif ($request['mode']==2) {
            $data = $category->find($request['id']);
            $data->name = $request['categoryname'];
            $data->save();
        }

        return redirect('admin/inventory/category');

    }

    /*
     * Inventory Setting : Show Item List
     */
    public function getItem()
    {
        $this->setPageHeader('Inventory', 'Item List');
        $items = Inventory::with('metric')->with('category')->with('sku')->get();
        return view('admin.inventory.item')
            ->with('items', $items);
    }

    /*
     * Inventory Setting : Show Item Input Form
     * @mode = new / update --> 1 = new data input, 2 = update existing data
     * @id = id of data to be update
     */
    public function getItemForm($mode = 1, $id = null)
    {
        $subtitle = ($mode==1) ? 'Add New Item' : 'Edit Item';
        $this->setPageHeader('Inventory', 'Item Form : '. $subtitle);

        $data = Inventory::find($id);

        $metriclist = Metric::pluck('name','id');
        $categorylist = Category::pluck('name','id');

        return view('admin.inventory.itemform')
            ->with('subtitle',$subtitle)
            ->with('data',$data)
            ->with('mode',$mode)
            ->with('metriclist',$metriclist)
            ->with('categorylist',$categorylist);
    }

    /*
     * Inventory Setting : Item Form POST data
     * @request : form data
     */
    public function postItemForm(Request $request)
    {
        if ($request['mode']==1) {
            $validator = Validator::make($request->all(), [
                'itemname' => 'required|unique:tb_inventory_inventories,name|max:50',
                'selcategory' => 'required|numeric',
                'selmetric' => 'required|numeric',
            ]);
        } elseif ($request['mode']==2) {
            $validator = Validator::make($request->all(), [
                'itemname' => 'required|unique:tb_inventory_inventories,name,'. $request['id'] .'|max:50',
                'selcategory' => 'required|numeric',
                'selmetric' => 'required|numeric',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $item = new Inventory();
        if ($request['mode']==1) {
            $item->user_id = Auth::id();
            $item->name = $request['itemname'];
            $item->metric_id = $request['selmetric'];
            $item->category_id = $request['selcategory'];
            $item->description = $request['itemdesc'];
            $item->save();

            $locations = Location::all();
            foreach ($locations as $loc) {
                $stock = new InventoryStock();
                $stock->inventory_id = $item->id;
                $stock->location_id = $loc->id;
                $stock->quantity = 0;
                $stock->cost = 0;
                $stock->reason = 'init';
                $stock->save();
            }

        } elseif ($request['mode']==2) {
            $data = $item->with('suppliers')->find($request['id']);
            $data->user_id = Auth::id();
            $data->name = $request['itemname'];
            $data->metric_id = $request['selmetric'];
            $data->category_id = $request['selcategory'];
            $data->description = $request['itemdesc'];
            $data->save();
        }

        return redirect('admin/inventory/item');

    }

    /*
     * Inventory Setting : Show Location List
     */
    public function getLocation()
    {
        $this->setPageHeader('Inventory', 'Location List');

        $location = new Location();
        $locations = $location->all();

        return view('admin.inventory.location')
            ->with('locations', $locations);
    }

    /*
     * Inventory Setting : Show Location Input Form
     * @mode = new / update --> 1 = new data input, 2 = update existing data
     * @id = id of data to be update
     */
    public function getLocationForm($mode = 1, $id = null)
    {
        $subtitle = ($mode==1) ? 'Add New Location' : 'Edit Location';
        $this->setPageHeader('Inventory', 'Location Form : '. $subtitle);

        $location = new Location();
        $data = $location->find($id);
        return view('admin.inventory.locationform')
            ->with('subtitle',$subtitle)
            ->with('data',$data)
            ->with('mode',$mode);
    }

    /*
     * Inventory Setting : Location Form POST data
     * @request : form data
     */
    public function postLocationForm(Request $request)
    {
        if ($request['mode']==1) {
            $validator = Validator::make($request->all(), [
                'locationname' => 'required|unique:tb_inventory_locations,name|max:50',
            ]);
        } elseif ($request['mode']==2) {
            $validator = Validator::make($request->all(), [
                'locationname' => 'required|unique:tb_inventory_locations,name,'. $request['id'] .'|max:50',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $location = new Location();
        if ($request['mode']==1) {
            $location->name = $request['locationname'];
            $location->save();

            $items = Inventory::all();
            foreach ($items as $item) {
                $stock = new InventoryStock();
                $stock->inventory_id = $item->id;
                $stock->location_id = $location->id;
                $stock->quantity = 0;
                $stock->cost = 0;
                $stock->reason = 'init';
                $stock->save();
            }

        } elseif ($request['mode']==2) {
            $data = $location->find($request['id']);
            $data->name = $request['locationname'];
            $data->save();
        }

        return redirect('admin/inventory/location');

    }

    /*
 * Inventory Setting : Show Item List
 */
    public function getSupplier()
    {
        $this->setPageHeader('Inventory', 'Supplier List');
        $suppliers = Supplier::all();
        return view('admin.inventory.supplier')
            ->with('suppliers', $suppliers);
    }

    /*
     * Inventory Setting : Show Item Input Form
     * @mode = new / update --> 1 = new data input, 2 = update existing data
     * @id = id of data to be update
     */
    public function getSupplierForm($mode = 1, $id = null)
    {
        $subtitle = ($mode==1) ? 'Add New Supplier' : 'Edit Supplier';
        $this->setPageHeader('Inventory', 'Supplier Form : '. $subtitle);

        $data = Supplier::find($id);

        $ref = New UserProfile();
        $province = $ref->getProvince();

        return view('admin.inventory.supplierform')
            ->with('subtitle',$subtitle)
            ->with('data',$data)
            ->with('mode',$mode)
            ->with('provincelist',$province);
    }

    /*
     * Inventory Setting : Item Form POST data
     * @request : form data
     */
    public function postSupplierForm(Request $request)
    {
        if ($request['mode']==1) {
            $validator = Validator::make($request->all(), [
                'suppliername' => 'required|unique:tb_inventory_suppliers,name|max:50',
            ]);
        } elseif ($request['mode']==2) {
            $validator = Validator::make($request->all(), [
                'suppliername' => 'required|unique:tb_inventory_suppliers,name,'. $request['id'] .'|max:50',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $item = new Supplier();
        if ($request['mode']==1) {
            $item->name = $request['suppliername'];
            $item->address = $request['supplieraddress'];
            $item->region = $request['selprovince'];
            $item->city = $request['selcity'];
            $item->contact_name = $request['contactname'];
            $item->contact_phone = $request['contactphone'];
            $item->contact_fax = $request['contactfax'];
            $item->contact_email = $request['contactemail'];
            $item->save();
        } elseif ($request['mode']==2) {
            $data = $item->find($request['id']);
            $data->name = $request['suppliername'];
            $data->address = $request['supplieraddress'];
            $data->region = $request['selprovince'];
            $data->city = $request['selcity'];
            $data->contact_name = $request['contactname'];
            $data->contact_phone = $request['contactphone'];
            $data->contact_fax = $request['contactfax'];
            $data->contact_email = $request['contactemail'];
            $data->save();
        }

        return redirect('admin/inventory/supplier');

    }

    public function stockSummary()
    {

    }

    public function addStock()
    {
        $this->setPageHeader('Inventory', 'Add New Stock');
        $locations = Location::all();
        $items = Inventory::all();

        return view('admin.inventory.addstockform')
            ->with('subtitle','Add New Stock')
            ->with('locations',$locations)
            ->with('items',$items);
    }

    public function postAddStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'selitem' => 'required|numeric',
            'sellocation' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $location = Location::find($request['sellocation']);
        $item = Inventory::find($request['selitem']);
        $stock = $item->getStockFromLocation($location);
        $reason = $request['reason'];
        $cost = $request['cost'];
        $stock->put($request['quantity'], $reason, $cost);

        return redirect('admin/inventory/stock');

    }

    public function stockStanding()
    {
        $this->setPageHeader('Inventory', 'Stock List');
        $stocks = InventoryStock::with('location')->with('item')->get();
        return view('admin.inventory.stock')
            ->with('stocks', $stocks);
    }

    public function productClaimB()
    {
        $this->setPageHeader('List Product Claim (Plan-B)');
        return view('admin.inventory.productclaimlist')->with('type', 'B')->with('status', 1);
    }

    public function ajaxListProductClaimB(Request $request) {
        $clsClaim = new ProductClaim();
        $status = $request->get('status', 1);
        $claimData = $clsClaim->getProductClaimListB('B',$status);
        $data = Datatables::collection($claimData);
        return $data->make();
    }
}
