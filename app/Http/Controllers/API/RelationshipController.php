<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Tag;

class RelationshipController extends Controller
{
    public function userLessons($id)
    {
        $user = User::findOrFail($id)->lessons;
        $fields = [];
        $filtered = [];
        foreach($user as $lesson){
            $fields['Title'] = $lesson->title;
            $fields['Content'] = $lesson->body;
            $filtered[] = $fields;
        }

        return Response::json(['data' => $filtered], 200);
    }

    public function lessonTags($id)
    {
        $lesson = Lesson::findOrFail($id)->tags;
        $fields = [];
        $filtered = [];
        foreach($lesson as $tag){
            $fields['Tag'] = $tag->name;
            $filtered[] = $fields;
        }
        return Response::json(['data' => $filtered], 200);
    }

    public function tagLessons($id)
    {
        $tag = Tag::findOrFail($id)->lessons;
        $fields = [];
        $filtered = [];
        foreach($tag as $lesson){
            $fields['Title'] = $lesson->title;
            $fields['Content'] = $lesson->body;
            $filtered[] = $fields;
        }

        return Response::json(['data' => $filtered], 200);
    }
}
