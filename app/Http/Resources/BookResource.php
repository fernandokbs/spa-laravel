<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
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
        $action = explode('@',Route::currentRouteAction())[1];
        
        return 
        [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'slug' => $this->slug,
            'score' => $this->score(),
            'comments' => $this->countComments(),
            'attributes' => [
                'title' => $this->title,
                'content' => ($action === "show" ? $this->content : Str::limit($this->content, 50)),
                'picture' => $this->thumbnail,
                'created_at' => $this->created_at->diffForHumans()
            ],
            'relationships' =>  [
                'author' => new AuthorResource($this->author)
            ],
        ];
    }
}
