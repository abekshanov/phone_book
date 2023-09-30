<?php

namespace App\Http\Resources\Contacts;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactIndexResource extends JsonResource
{
    /**
     * @var LengthAwarePaginator
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->resource->getCollection()->map(function (Contact $item) {
            return [
                'id' => $item->id,
                'first_name' => $item->first_name,
                'last_name' => $item->last_name,
                'surname' => $item->surname,
                'phone' => $item->phone,
                'favourite' => $item->favourite,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        $this->resource->setCollection($data);

        return parent::toArray($request);
    }
}
