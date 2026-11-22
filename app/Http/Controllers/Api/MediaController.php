<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $media = Media::query()
            ->when($request->filled('search'), fn ($query) => $query->where('title', 'like', '%'.$request->string('search')->toString().'%'))
            ->with('users')
            ->orderBy('title')
            ->get();

        return MediaResource::collection($media);
    }

    public function store(StoreMediaRequest $request): MediaResource
    {
        return new MediaResource(Media::create($request->validated()));
    }

    public function show(Media $media): MediaResource
    {
        return new MediaResource($media->load('users'));
    }

    public function update(UpdateMediaRequest $request, Media $media): MediaResource
    {
        $media->update($request->validated());

        return new MediaResource($media->refresh());
    }

    public function destroy(Media $media): Response
    {
        $media->delete();

        return response()->noContent();
    }
}
