<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\Http\Requests\DiscussionRequest;
use App\Tag;

class DiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discussions = Discussion::checkAuth()
            ->orderBy(config('blog.discussion.sortColumn'), config('blog.discussion.sort'))
            ->paginate(config('blog.discussion.number'));

        return view('discussion.index', compact('discussions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::query()->get();

        return view('discussion.create', compact('tags'));
    }

    /**
     * Store a new discussion.
     *
     * @param DiscussionRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DiscussionRequest $request)
    {
        $data = array_merge($request->all(), [
            'user_id' => \Auth::id(),
            'last_user_id' => \Auth::id(),
            'status' => true,
        ]);

        $discussion = Discussion::create($data);

        if (is_array($data['tags'])) {
            $discussion->tags()->sync($data['tags']);
        } else {
            $discussion->tags()->sync(json_decode($data['tags']));
        }

        return redirect()->to('discussion');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discussion = Discussion::query()->checkAuth()->findOrFail($id);

        return view('discussion.show', compact('discussion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discussion = Discussion::query()->checkAuth()->findOrFail($id);

        $this->authorize('update', $discussion);

        $tags = Tag::query()->get();

        $selectTags = $discussion->tags->pluck('id')->toArray();

        return view('discussion.edit', compact('discussion', 'tags', 'selectTags'));
    }

    /**
     * Update the discussion by id.
     *
     * @param DiscussionRequest $request
     * @param int               $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(DiscussionRequest $request, $id)
    {
        $discussion = Discussion::query()->checkAuth()->findOrFail($id);

        $this->authorize('update', $discussion);

        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id(),
        ]);

        $discussion->update($data);

        return redirect()->to("discussion/{$id}");
    }
}
