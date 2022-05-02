<?php

namespace App;

use App\Product;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\SubSubSubCategory;
use App\SubSubSubSubCategory;
use App\User;
// use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Auth;

class CategoriesImport implements ToCollection, WithHeadingRow, WithValidation,SkipsOnFailure 
{
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }
    // WithHeadingRow
    public function collection(Collection $row)
    {       
        $cat = '';
        $sub_cat = '';
        $sub_sub_cat = '';
        $sub_sub_sub_cat = '';
        $sub_sub_sub_sub_cat = '';
        
        foreach($row as $c => $d){
            $meta = [
                'type' => '',
                'id' => ''
            ];
            foreach($d as $a => $b){ 
                // dd($row);              
                if($a == 'category'){
                    $explode = explode('/',$b);

                    if (isset($explode[1]) && !empty($explode[1])) {
                        $cat = $explode['1'];
                        if(Category::where('name',trim(trim(str_replace("'", "", $cat))))->count() == 0){
                            $cat_upload = Category::create([
                                'name' => trim(trim(str_replace("'", "", $cat))),
                                'slug' => str_replace(' ','-',strtolower(trim($cat))),
                                'meta_title' => trim(trim(str_replace("'", "", $cat))),
                                'meta_description' => trim(trim(str_replace("'", "", $cat)))
                            ]);
                        }
                        
                        $cat_2 = Category::where('name',(trim(str_replace("'", "", $cat))))->first();
                        $meta = [
                            'type' => 'Category',
                            'id' => $cat_2->id
                        ];
                        // dd($meta);
                    }
                    if (isset($explode[2]) && !empty($explode[2])) {
                        $sub_cat = $explode[2];
                        // dd($cat_upload);
                        if(SubCategory::where('name',(trim(str_replace("'", "", $sub_cat))))->count() == 0){
                            $cat_upload = Category::where('name',(trim(str_replace("'", "", $cat))))->first();
                            $sub_cat_upload = SubCategory::create([
                                'name' => (trim(str_replace("'", "", $sub_cat))),
                                'category_id' =>  $cat_upload->id,
                                'slug' => str_replace(' ','-',strtolower(trim($sub_cat))),
                                'meta_title' => (trim(str_replace("'", "", $sub_cat))),
                                'meta_description' => (trim(str_replace("'", "", $sub_cat)))
                            ]);
                        }
                        $sub_cat_2 = SubCategory::where('name',(trim(str_replace("'", "", $sub_cat))))->first();
                        $meta = [
                            'type' => 'SubCategory',
                            'id' => $sub_cat_2->id
                        ];
                        // else{
                        //     $sub_cat_upload = SubCategory::where('name',$sub_cat)->first();
                        // }
                    }
                    if (isset($explode[3]) && !empty($explode[3])) {
                        $sub_sub_cat = $explode[3];
                        if(SubSubCategory::where('name',(trim(str_replace("'", "", $sub_sub_cat))))->count() == 0){
                            $sub_cat_upload = SubCategory::where('name',(trim(str_replace("'", "", $sub_cat))))->first();
                            $sub_cat_upload = SubSubCategory::create([
                                'name' => (trim(str_replace("'", "", $sub_sub_cat))),
                                'sub_category_id' =>  $sub_cat_upload->id,
                                'slug' => str_replace(' ','-',strtolower(trim($sub_sub_cat))),
                                'meta_title' => (trim(str_replace("'", "", $sub_sub_cat))),
                                'meta_description' => (trim(str_replace("'", "", $sub_sub_cat)))
                            ]);
                        }
                        
                        $sub_sub_cat_2 = SubSubCategory::where('name',(trim(str_replace("'", "", $sub_sub_cat))))->first();
                        $meta = [
                            'type' => 'SubSubCategory',
                            'id' => $sub_sub_cat_2->id
                        ];
                        // else{
                        //     $sub_cat_upload = SubSubCategory::where('name',$sub_sub_cat)->first();
                        // }
                    }
                    if (isset($explode[4]) && !empty($explode[4])) {
                        $sub_sub_sub_cat = $explode[4];
                        if(SubSubSubCategory::where('name',(trim(str_replace("'", "", $sub_sub_sub_cat))))->count() == 0){
                            $sub_cat_upload = SubSubCategory::where('name',(trim(str_replace("'", "", $sub_sub_cat))))->first();
                            $sub_cat_upload = SubSubSubCategory::create([
                                'name' => (trim(str_replace("'", "", $sub_sub_sub_cat))),
                                'sub_sub_category_id' =>  $sub_cat_upload->id,
                                'slug' => str_replace(' ','-',strtolower(trim($sub_sub_sub_cat))),
                                'meta_title' => (trim(str_replace("'", "", $sub_sub_sub_cat))),
                                'meta_description' => (trim(str_replace("'", "", $sub_sub_sub_cat)))
                            ]);
                        }
                        
                        $sub_sub_sub_cat_2 = SubSubSubCategory::where('name',(trim(str_replace("'", "", $sub_sub_sub_cat))))->first();
                        $meta = [
                            'type' => 'SubSubSubCategory',
                            'id' => $sub_sub_sub_cat_2->id
                        ];
                        // else{
                        //     $sub_cat_upload = SubSubSubCategory::where('name',$sub_sub_sub_cat)->first();
                        // }
                    }
                    if (isset($explode[5]) && !empty($explode[5])) {
                        $sub_sub_sub_sub_cat = $explode[5];
                        if(SubSubSubSubCategory::where('name',(trim(str_replace("'", "", $sub_sub_sub_sub_cat))))->count() == 0){
                            $sub_cat_upload = SubSubSubCategory::where('name',(trim(str_replace("'", "", $sub_sub_sub_cat))))->first();
                            $sub_cat_upload = SubSubSubSubCategory::create([
                                'name' => (trim(str_replace("'", "", $sub_sub_sub_sub_cat))),
                                'sub_sub_sub_category_id' =>  $sub_cat_upload->id,
                                'slug' => str_replace(' ','-',strtolower(trim($sub_sub_sub_sub_cat))),
                                'meta_title' => (trim(str_replace("'", "", $sub_sub_sub_sub_cat))),
                                'meta_description' => (trim(str_replace("'", "", $sub_sub_sub_sub_cat)))
                            ]);
                        }
                        
                        $sub_sub_sub_sub_cat_2 = SubSubSubSubCategory::where('name',(trim(str_replace("'", "", $sub_sub_sub_sub_cat))))->first();
                        $meta = [
                            'type' => 'SubSubSubSubCategory',
                            'id' => $sub_sub_sub_sub_cat_2->id
                        ];
                        // else{
                        //     $sub_cat_upload = SubSubSubSubCategory::where('name',$sub_sub_sub_sub_cat)->first();
                        // }
                    }
                }
                
                if($a == 'category_seo_title'){
                    
                // dd($meta);
                    if($meta['type'] != ''){
                        if($meta['type'] == 'Category'){
                            if($meta['id']  > 0){
                                $sub = Category::where('id',$meta['id'])->update([
                                    'meta_title' => $b
                                ]);
                            }
                        }
                        if($meta['type'] == 'SubCategory'){
                            if($meta['id']  > 0){
                                $sub = SubCategory::where('id',$meta['id'])->update([
                                    'meta_title' => $b
                                ]);
                            }
                        }
                        if($meta['type'] == 'SubSubCategory'){
                            if($meta['id']  > 0){
                                $sub = SubSubCategory::where('id',$meta['id'])->update([
                                    'meta_title' => $b
                                ]);
                            }
                        }
                        if($meta['type'] == 'SubSubSubCategory'){
                            if($meta['id']  > 0){
                                $sub = SubSubSubCategory::where('id',$meta['id'])->update([
                                    'meta_title' => $b
                                ]);
                            }
                        }
                        if($meta['type'] == 'SubSubSubSubCategory'){
                            if($meta['id']  > 0){
                                $sub = SubSubSubSubCategory::where('id',$meta['id'])->update([
                                    'meta_title' => $b
                                ]);
                            }
                        }
                    }
                }
                if($a == 'category_seo_description'){
                  
                // dd($row); 
                    if($meta['type'] != ''){
                        if($meta['type'] == 'Category'){
                            if($meta['id']  > 0){
                                $sub = Category::where('id',$meta['id'])->update([
                                    'meta_description' => $b
                                ]);
                            }
                        }
                        if($meta['type'] == 'SubCategory'){
                            if($meta['id']  > 0){
                                $sub = SubCategory::where('id',$meta['id'])->update([
                                    'meta_description' => $b
                                ]);
                            }
                        }
                        if($meta['type'] == 'SubSubCategory'){
                            if($meta['id']  > 0){
                                $sub = SubSubCategory::where('id',$meta['id'])->update([
                                    'meta_description' => $b
                                ]);
                            }
                        }
                        if($meta['type'] == 'SubSubSubCategory'){
                            if($meta['id']  > 0){
                                $sub = SubSubSubCategory::where('id',$meta['id'])->update([
                                    'meta_description' => $b
                                ]);
                            }
                        }
                        if($meta['type'] == 'SubSubSubSubCategory'){
                            if($meta['id']  > 0){
                                $sub = SubSubSubSubCategory::where('id',$meta['id'])->update([
                                    'meta_description' => $b
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return true;
        // dd($all);
        // return new Product([
        //    'name'     => $row['name'],
        //    'added_by'    => Auth::user()->user_type == 'seller' ? 'seller' : 'admin',
        //    'user_id'    => Auth::user()->user_type == 'seller' ? Auth::user()->id : User::where('user_type', 'admin')->first()->id,
        //    'category_id'    => $row['category_id'],
        //    'subcategory_id'    => $row['subcategory_id'],
        //    'subsubcategory_id'    => $row['subsubcategory_id'],
        //    'brand_id'    => $row['brand_id'],
        //    'video_provider'    => $row['video_provider'],
        //    'video_link'    => $row['video_link'],
        //    'unit_price'    => $row['unit_price'],
        //    'purchase_price'    => $row['purchase_price'],
        //    'unit'    => $row['unit'],
        //    'current_stock' => $row['current_stock'],
        //    'meta_title' => $row['meta_title'],
        //    'meta_description' => $row['meta_description'],
        //    'colors' => json_encode(array()),
        //    'choice_options' => json_encode(array()),
        //    'variations' => json_encode(array()),
        //    'slug' => preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $row['slug'])).'-'.str_random(5),
        // ]);
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
             'unit_price' => function($attribute, $value, $onFailure) {
                  if (!is_numeric($value)) {
                       $onFailure('Unit price is not numeric');
                  }
              }
        ];
    }
}
