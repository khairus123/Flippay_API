<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserMediaController extends Controller
{
    public function index(User $user): UserResource
    {
        return new UserResource($user->load('media'));
    }

    public function store(User $user, Media $media): JsonResponse
    {
        if ($user->media()->whereKey($media->getKey())->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi pengguna ini.',
            ], 409);
        }

        $user->media()->attach($media->getKey());

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi.',
            'data' => new UserResource($user->load('media')),
        ], 201);
    }

    public function destroy(User $user, Media $media): JsonResponse
    {
        if (! $user->media()->whereKey($media->getKey())->exists()) {
            return response()->json([
                'message' => 'Media tidak ditemukan di koleksi pengguna ini.',
            ], 404);
        }

        $user->media()->detach($media->getKey());

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi.',
            'data' => new UserResource($user->load('media')),
        ]);
    }
}
