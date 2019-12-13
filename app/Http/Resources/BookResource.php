<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return 
        [
            'id' => $this->id,
            'slug' => $this->slug,
            'score' => $this->score(),
            'comments' => $this->countComments(),
            'attributes' => [
                'title' => $this->title,
                'description' => Str::limit($this->content, 50),
                'picture' => $this->thumbnail,
                'created_at' => $this->created_at->diffForHumans()
            ],
            'relationships' =>  [
                'author' => new AuthorResource($this->author)
            ],
        ];
    }
}
