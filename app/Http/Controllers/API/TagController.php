<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use Illuminate\Support\Facades\Response;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') <= 50 ? $request->input('limit') : 15;
        $tags = TagResource::collection(Tag::paginate($limit));

        return Response::json(['data' => $tags])->setStatusCode(200, 'Tags Returned Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Tag::class);
        $tag = new TagResource(Tag::create($request->all()));

         return Response::json(['data' => $tag])->setStatusCode(200, 'Tag Stored Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = new TagResource(Tag::findOrFail($id));

        return Response::json(['data' => $tag])->setStatusCode(200, 'Tag Retured Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $idtag = Tag::findOrFail($id);
        $this->authorize('update', $idtag);
        $tag = new TagResource(Tag::findOrFail($id));
        $tag->update($request->all());

        return Response::json(['data' => $tag])->setStatusCode(200, 'Tag Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idtag = Tag::findOrFail($id);
        $this->authorize('delete', $idtag);
        Tag::findOrFail($id)->delete();

        return 204;
    }
}
