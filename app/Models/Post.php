<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Post extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'posts';
    // protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['title','body','cover_img','user_id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    // Handle file uploads
    public function setCoverImgAttribute($value)
    {
        $attribute_name = "cover_img";
        $disk = "local";
        $destination_path = "public/cover_imgs";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
    
        public function uploadFileToDisk($value, $attribute_name, $disk, $destination_path)
        {
            $request = \Request::instance();
            // if a new file is uploaded, delete the file from the disk
            if ($request->hasFile($attribute_name) &&
                $this->{$attribute_name} &&
                $this->{$attribute_name} != null) {
                \Storage::disk($disk)->delete($this->{$attribute_name});
                $this->attributes[$attribute_name] = null;
            }
            // if the file input is empty, delete the file from the disk
            if (is_null($value) && $this->{$attribute_name} != null) {
                \Storage::disk($disk)->delete($this->{$attribute_name});
                $this->attributes[$attribute_name] = null;
            }
            // if a new file is uploaded, store it on disk and its filename in the database
            if ($request->hasFile($attribute_name) && $request->file($attribute_name)->isValid()) {
                // 1. Generate a new file name
                $file = $request->file($attribute_name);
                $new_file_name = md5($file->getClientOriginalName().time()).'.'.$file->getClientOriginalExtension();
                // 2. Move the new file to the correct path
                $file_path = $file->storeAs($destination_path, $new_file_name, $disk);
                // 3. Save the complete path to the database
                $this->attributes[$attribute_name] = $new_file_name;
            }
        }
}
