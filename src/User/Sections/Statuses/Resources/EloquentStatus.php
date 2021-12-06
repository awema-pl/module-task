<?php

namespace AwemaPL\Task\User\Sections\Statuses\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

class EloquentStatus extends JsonResource
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
            'taskable' => $this->taskable,
            'type_trans' => _p($this->type_key, str_replace('_', ' ', $this->type)),
            'interrupt' => $this->interrupt,
            'status' => $this->status,
            'status_trans' =>_p('task::pages.user.status.statuses.' . $this->status, $this->status),
            'status_detail_trans' =>_p($this->status_detail_key, $this->status_detail_key, $this->status_detail_placeholders),
            'error' =>$this->error,
            'created_at' =>$this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
