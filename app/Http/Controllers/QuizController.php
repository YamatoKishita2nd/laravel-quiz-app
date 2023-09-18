<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('quizzes.index', [
            'quizzes' => Quiz::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 入力内容のチェック
        // ルールに一致しない入力の場合は、自動的に入力画面を表示させる
        $validatedData = $request->validate([
            'question' => 'required|max:255',
            'answer_a' => 'required|max:255',
            'answer_b' => 'required|max:255',
            'answer_c' => 'required|max:255',
            'answer_d' => 'required|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'max:65535',
        ]);

        $Quiz = new Quiz();
        $Quiz->question = $validatedData['question'];
        $Quiz->answer_a = $validatedData['answer_a'];
        $Quiz->answer_b = $validatedData['answer_b'];
        $Quiz->answer_c = $validatedData['answer_c'];
        $Quiz->answer_d = $validatedData['answer_d'];
        $Quiz->correct_answer = $validatedData['correct_answer'];
        $Quiz->explanation = $validatedData['explanation'];

        // ModelをDBに保存
        $Quiz->save();

        // 一覧ページを表示
        // ※ リロードされたときに、もう一度データが保存されないようにリダイレクトさせる
        return redirect(route('quizzes.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('quizzes.show', [
            'quiz' => Quiz::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Quiz::destroy($id)) {
            // 400 Bad Request
            return response()->json([
                'message' => 'Failed to delete.',
            ], 400);
        }

        // 204 NO CONTENT
        return response()->noContent();
    }
}
