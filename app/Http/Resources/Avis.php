<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\Resource;
class Avis extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'avis'      => $this->avis,
            'is_public' => $this->is_public,
            'date'      => $this->date,
            'stars'     => $this->stars
        ];
    }
   
}