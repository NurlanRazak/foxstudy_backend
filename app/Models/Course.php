<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subcategory;
use App\Models\Lesson;
use Str;

class Course extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    const PUBLISHED = 1;
    const DRAFT = 0;
    const HAS = 1;

    protected $table = 'courses';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'name', 'short_description', 'long_description',
        'image', 'images',
        'subcategory_id',
        'map', 'rating', 'trial',
        'duration', 'price', 'type_course', 'frequency', 'about_center',
        'status'
    ];
    protected $fakeColumns = ['map'];
    protected $casts = [
        'images' => 'array',
        'map' => 'array',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('uploads')->delete($obj->image);
            if (count((array)$obj->images)) {
               foreach ($obj->images as $file_path) {
                   \Storage::disk('uploads')->delete($file_path);
               }
           }
        });
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        $query->where('status', static::PUBLISHED);
    }

    public function scopeTrial($query)
    {
        $query->where('trial',static::HAS);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public static function getStatusOptions() : array
    {
        return [
            static::PUBLISHED => trans('admin.published'),
            static::DRAFT => trans('admin.draft'),
        ];
    }

    public static function getTrialOptions() : array
    {
        return [
            static::HAS => trans('admin.has_trial'),
            static::DRAFT => trans('admin.no_trial'),
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = 'uploads'; // or use your own disk, defined in config/filesystems.php
        $destination_path = "course/image"; // path relative to the disk above

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value)->encode('png', 90);

        // 1. Generate a filename.
            $filename = md5($value.time()).'.png';

        // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

        // 3. Delete the previous image, if there was one.
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
        // but first, remove "public/" from the path, since we're pointing to it from the root folder
        // that way, what gets saved in the database is the user-accesible URL
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;

        }
    }

    public function setImagesAttribute($value)
    {
        $attribute_name = "images";
        $disk = "uploads";
        $destination_path = "course/images";

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
