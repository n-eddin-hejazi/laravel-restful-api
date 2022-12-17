<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Resources\LessonResource;
use Illuminate\Support\Facades\Response;

class LessonController extends Controller
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
        $lessons = LessonResource::collection(Lesson::paginate($limit));

        return Response::json(['data' => $lessons])->setStatusCode(200, 'Lessons Returned Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lesson = new LessonResource(Lesson::create($request->all()));

        return Response::json(['data' => $lesson])->setStatusCode(200, 'Lesson Stored Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = new LessonResource(Lesson::findOrFail($id));

        return Response::json(['data' => $lesson])->setStatusCode(200, 'Lesson Retured Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $idlesson = Lesson::findOrFail($id);
        $this->authorize('update', $idlesson);
        $lesson = new LessonResource(Lesson::findOrFail($id));
        $lesson->update($request->all());

        return Response::json(['data' => $lesson])->setStatusCode(200, 'Lesson Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idlesson = Lesson::findOrFail($id);
        $this->authorize('delete', $idlesson);
        Lesson::findOrFail($id)->delete();

        return 204;
    }
}
