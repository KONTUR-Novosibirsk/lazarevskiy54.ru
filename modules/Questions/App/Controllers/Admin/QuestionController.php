<?php

namespace Modules\Questions\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Support\Facades\Request;
use Modules\Questions\App\Models\Question;
use Modules\Questions\App\Requests\StoreRequest;
use Modules\Questions\App\Requests\UpdateRequest;
use Modules\Questions\App\Resources\QuestionResource;

class QuestionController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Вопрос-ответ', route('admin.question.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Вопрос-ответ');
        return inertia('Modules/Question/Index', [
            'filters' => Request::all('search', 'status'),
            'questions' => QuestionResource::collection(
                Question::query()->filter(Request::only('status'))
                    ->sort(Request::only('order_by', 'order_direction'))
                    ->orderBy('id', 'DESC')->paginate(auth()->user()->per_page)->withQueryString()),
        ]);
    }

    public function store(StoreRequest $request): QuestionResource
    {
        $question = new Question($request->validated());
        $question->save();
        return new QuestionResource($question);
    }

    public function update(UpdateRequest $request, Question $question): QuestionResource
    {
        $question->update($request->validated());
        return new QuestionResource($question);
    }

    public function changeStatus(Question $question): QuestionResource
    {
        $question->status = ($question->status == 1 ? 0 : 1);
        $question->save();
        return new QuestionResource($question);
    }

    public function destroy(Question $question): \Illuminate\Http\RedirectResponse
    {
        $question->delete();
        return redirect()->back();
    }


}
