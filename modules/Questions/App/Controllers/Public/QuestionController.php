<?php

namespace Modules\Questions\App\Controllers\Public;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Questions\App\Models\Question;
use Modules\Questions\App\Requests\StoreFromPublicRequest;
use Modules\Questions\App\Resources\QuestionResource;

class QuestionController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Вопрос-Ответ');
    }

    public function index(): \Illuminate\Http\Response
    {
        Seo::metaData()->setTitle('Вопрос-Ответ');

        return response()->view('question::index', [
            'questions' => Question::query()->where('status', 1)->orderByDesc('id')
                ->paginate(settings('per_page', default: 10))
        ]);
    }

    public function store(StoreFromPublicRequest $request): QuestionResource
    {
        $data = $request->validated();
        $question = new Question($data);
        $question->save();
        return new QuestionResource($question);
    }
}
