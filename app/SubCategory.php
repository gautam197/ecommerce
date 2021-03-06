<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
  protected $fillable = [
      'name','category_id','slug','meta_title','meta_description'
    ];
  public function category(){
  	return $this->belongsTo(Category::class);
  }

  public function subsubcategories(){
  	return $this->hasMany(SubSubCategory::class);
  }

  public function products(){
      return $this->hasMany(Product::class, 'subcategory_id');
  }

  public function classified_products(){
  	return $this->hasMany(CustomerProduct::class, 'subcategory_id');
  }
}
