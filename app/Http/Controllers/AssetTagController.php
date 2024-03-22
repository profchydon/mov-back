<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Taggable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class AssetTagController extends Controller
{
    public function assign(Asset $asset, Request $request)
    {
        $this->validate($request, [
            'tag_ids' => 'required|array|min:1',
            'tag_ids.*' => ['required', Rule::exists('tags', 'id')]
        ]);

        $tags = collect($request->tag_ids);
        $tags->transform(function ($tag) use ($asset) {
            return Taggable::firstOrCreate([
                'tag_id' => $tag,
                'taggable_type' => $asset::class,
                'taggable_id' => $asset->id,
            ]);
        });

        return $this->response(Response::HTTP_OK, __('messages.records-created'), $tags);
    }

    public function unassign(Asset $asset, Request $request)
    {
        $this->validate($request, [
            'tag_ids' => 'required|array|min:1',
            'tag_ids.*' => ['required', Rule::exists('tags', 'id')]
        ]);

        Taggable::query()->whereIn('tag_id', $request->tag_ids)->where('taggable_id', $asset->id)->delete();

        return $this->noContent();
    }
}
