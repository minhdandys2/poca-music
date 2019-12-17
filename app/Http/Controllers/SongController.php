<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditSongRequest;
use App\Http\Requests\SongRequest;
use App\Service\Implement\SongService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    private $songService;

    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
        $this->middleware('auth');
    }

    public function create()
    {
        return view('song.create');
    }

    public function store(SongRequest $request)
    {
        try {
            $message = 'Them moi thanh Cong';
            $this->songService->create($request);
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        $song = $this->songService->findById($id);
        return view('song.edit', compact('song'));
    }

    public function update(EditSongRequest $request, $id)
    {
        try {
            $this->songService->update($request, $id);
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $message = 'Xoa bai hat thanh Cong';
            $song = $this->songService->findById($id);
            if ($song->file) {
                Storage::disk('public')->delete($song->file);
            }
            if ($song->image) {
                Storage::disk('public')->delete($song->image);
            }
            $this->songService->delete($song);
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function listen($id)
    {
        $song = $this->songService->findById($id);
        return view('user.listenMusic', compact('song'));
    }

    public function songNew()
    {
        $songs = $this->songService->getAll();
        return view('user.recent',compact('songs'));
    }

    public function listenTheMost()
    {
        $songs = $this->songService->getAll();
        return view('user.HearTheMost', compact('songs'));
    }

}
