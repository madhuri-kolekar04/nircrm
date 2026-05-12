<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'brand_id',
        'category_id',
        'subcategory_id',
        'subsubcategory_id	',
        'product_name_en',
        'long_descp_en',
        'product_thambnail',
       'changeLog',
         'status',
        'Group',
        'Assign',
        'Department_id',
    ];


    
    public function ticketstage(){
    	return $this->belongsTo(Ticket_status::class,'status','id');
    }
    public function category(){
    	return $this->belongsTo(Category::class,'category_id','id');
    }


    public function brand(){
    	return $this->belongsTo(Brand::class,'brand_id','id');
    }
    public function servicecategory(){
    	return $this->belongsTo(service_category::class,'service_category_id','id');
    }
    public function subcategory(){
    	return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }
    public function subsubcategory(){
    	return $this->belongsTo(Action::class,'subsubcategory_id','id');
    }
    public function departmentfuc(){
    	return $this->belongsTo(Department::class,'Department_id','id');
    }
    public function Ticketusername(){
    	return $this->belongsTo(User::class,'product_name_en','id');
    }
    public function assignusername(){
    	return $this->belongsTo(User::class,'Assign','id',);
    }
     public function Group(){
    	return $this->belongsTo(Group::class,'Group','id');
    }
    public function usergetname(){
    	return $this->belongsTo(User::class,'product_name_en','id');
    }

    public function projectUpdates(){
        return $this->hasMany(ProjectUpdate::class);
    }

    public function customer(){
        return $this->belongsTo(User::class,'customerlist','id');
    }

}
  