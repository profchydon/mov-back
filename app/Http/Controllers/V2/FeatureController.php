<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\FeatureRepositoryInterface;
use Illuminate\Http\Response;

class FeatureController extends Controller
{
    public function __construct(private readonly FeatureRepositoryInterface $featureRepository)
    {
    }

    public function index()
    {
        $features = $this->featureRepository->getFeatures();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $features);
    }
}
