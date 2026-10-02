<?php

namespace Modules\Feedback\App\Controllers\Admin;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Feedback\App\Feedback\FeedbackConfigFactory;
use Modules\Feedback\App\Models\Feedback;
use Modules\Feedback\App\Resources\FeedbackResource;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function show(string $name, FeedbackConfigFactory $feedbackFactory): \Inertia\Response
    {
        if (!$config = $feedbackFactory->getConfig($name)) {
            abort(404);
        }
        Seo::breadcrumbs()->add($config['title'], route('admin.feedback.show', $name));
        Seo::metaData()->setTitle($config['title']);

        return inertia('Modules/Feedback/Show', [
            'feedback' => FeedbackResource::collection(
                Feedback::query()->where('name', $config['name'])->orderBy('id', 'DESC')
                    ->paginate(auth()->user()->per_page)
            ),
            'config' => $config,
        ]);
    }

    public function changeStatus(Feedback $feedback): FeedbackResource
    {
        $feedback->status = $feedback->status === 0 ? 1 : 0;
        $feedback->save();
        return new FeedbackResource($feedback);
    }

    public function destroy(Feedback $feedback): \Illuminate\Http\RedirectResponse
    {
        $feedbackName = $feedback->name;
        $feedback->delete();
        return redirect()->route('admin.feedback.show', $feedbackName);
    }

    public function massDestroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $items = collect($request->get('items'));
        if ($items->count() > 0)
            Feedback::query()->whereIn('id', $items->pluck('id'))->delete();
        return response()->json([
            'delete_count' => $items->count()
        ]);
    }
}
