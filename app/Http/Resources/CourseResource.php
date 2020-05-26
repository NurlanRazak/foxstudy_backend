<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'image' => url('uploads/'.$this->image),
            'images' => $this->getImages(),
            'map' => $this->map,
            'rating' => $this->rating,
            'trial' => $this->trial,
            'lessons' => LessonResource::collection($this->lessons),
            'subcategory_id' => $this->subcategory->name,
            'at_morning' => $this->at_morning,
            'at_afternoon' => $this->at_afternoon,
            'at_evening' => $this->at_evening,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function getImages()
    {
        $images = [];
        foreach($this->images as $image) {
            $images[] = url('uploads/'.$image);
        }
        return $images;
    }
}
