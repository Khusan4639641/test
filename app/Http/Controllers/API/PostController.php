<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FindRequest;

use App\Http\Response\BaseResponse;
use App\Models\House;
use App\Services\SearchService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function search(FindRequest $request)
    {
            return SearchService::find($request);
    }
}
