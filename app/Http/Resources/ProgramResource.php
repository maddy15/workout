<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'currentLevel' => $this->getCurrentLevel(),
            'exercises' => ExerciseResource::collection($this->whenLoaded('exercises')),
            'progress' => $this->pivot->progress,
            'numberOfExercices' => $this->countExercise()
        ];
    }
}
