<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SongController extends Controller
{

    public function index(): JsonResponse
    {
        $column = request('order', 'id');
        $direction = request('dir', 'desc');

        $perPage = request()->input('per_page', 10);

        $resource = Song::query()
            ->with(['album', 'genre'])
            ->orderBy($column, $direction)
            ->paginate($perPage);

        return SongResource::collection($resource)
            ->response();
    }

    public function store(StoreSongRequest $request)
    {
        $data = $request->validated();

        $file = $request->file('file');

        if (!empty($file)) {
            $path = $file->store(Song::MUSIC_PATH);
            $fileName = basename($path);
            $data['file'] = $fileName;
        }
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        $song = Song::create($data);

        return SongResource::make($song)
            ->response();
    }

    public function show(Song $song)
    {
        $song->load(['album', 'genre']);
        return SongResource::make($song)
            ->response();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSongRequest $request, Song $song)
    {
        $data = $request->validated();

        $song->update($data);

        return SongResource::make($song)
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song)
    {
        $song->delete();

        return SongResource::make($song)
            ->response();
    }
}
