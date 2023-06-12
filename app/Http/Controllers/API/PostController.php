<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FindRequest;

use App\Http\Response\BaseResponse;
use App\Models\House;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function search(FindRequest $request)
    {
        $validated = $request->validated();
            $matchingRecords = House::query()
                ->when($request->has('name'), function (Builder $builder) use ($validated) {
                    $builder->where('name', 'like', '%' . $validated['name'] . '%');
                })
                ->when($request->has('price'), function (Builder $builder) use ($validated) {
                    $builder->whereBetween('price', [
                        $validated['price']['x'], $validated['price']['y']
                    ]);
                })
                ->when($request->hasAny(['bathrooms','bedrooms','storeys','garages']), function (Builder $builder) use ($validated) {
                    foreach (['bathrooms','bedrooms','storeys','garages'] as $key){
                        if(isset($validated[$key])){
                            $builder->where($key,$validated[$key]);
                        }
                    }
                });
            return BaseResponse::success($matchingRecords->get());
    }
}
