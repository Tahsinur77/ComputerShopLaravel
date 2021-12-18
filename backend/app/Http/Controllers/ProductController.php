<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;


class ProductController extends Controller
{
    //

    public function productList(Request $req){
        $allProducts = Product::All();
        return $allProducts;
    }

    public function navigationCheck(Request $req){
        $categorys = Product::select('pCategory')->distinct()->pluck('pCategory');
        return $categorys;
    }

    public function subproducts(Request $req){
        $types = Product::select('pType')->where('pCategory',$req->category)->distinct()->pluck('pType');
        return $types;
    }

    public function products(Request $req){
        $this->validate(
            $req,
            
            [
                'category'=>'required',
                'type'=>'required',
                'pId'=>'required| regex:/^[a-zA-Z0-9_.-]*$/|unique:products',
                'pname'=>'required',
                'price'=>'required|numeric|gt:0',
                'quantity'=>'required|numeric|gt:0',
                'pic' => 'required|image|mimes:jpg,png,jpeg'
            ]
        );
        
        if($req->hasFile('pic')){
            $pic = time().'_'.$req->file('pic')->getClientOriginalName();
            $req->file('pic')->storeAs('uploads',$pic,'public');
        }
        else{
            $pic = "none";
        }

        
        $component_num = count($req->component);

        $specification = array();

        for($i = 0 ; $i <$component_num;$i++){
            
            $specification[$req->component[$i]] = $req->model[$i];
        }

        $var = new product();
        $var->pName = $req->pname;
        $var->pCategory = $req->category;
        $var->pId = $req->pId;
        $var->pType = $req->type;
        $var->pPrice = $req->price;
        $var->pQuantity = $req->quantity;
        $var->pPicture = $pic;
        $var->pSpecification = json_encode($specification);
        $var->save();
        

        return redirect()->route("navigationCheck");
            
    }



    public function productListByCategory(Request $req){
        $categoryName = $req->category;
        $allProducts = Product::where('pCategory',$categoryName)->get();
        return $allProducts;
    }


    public function productListByType(Request $req){
        $categoryName = $req->category;
        $typeName = $req->type;
        $allProducts = Product::where(['pCategory'=>$categoryName,'pType'=>$typeName])->get();
        return $allProducts;
    }
    
    public function productDetails(Request $req){
        $id = $req->id;
        $product = Product::where('id',$id)->first();

       return $product;
    }
}
