<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'attributes' => [
                'title' => $this->title,
                'content' => $this->content,
                'score' => $this->score,
                'created_at' => $this->created_at->diffForHumans()
            ],

            'relationships' => [
                'author' => new AuthorResource($this->user)
            ],
        ];
    }
}
