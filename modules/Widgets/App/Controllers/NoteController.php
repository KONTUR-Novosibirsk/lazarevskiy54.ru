<?php

namespace Modules\Widgets\App\Controllers;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Support\Facades\Request;
use Modules\Widgets\App\Models\WidgetNote;
use Modules\Widgets\App\Requests\Note\StoreRequest;
use Modules\Widgets\App\Requests\Note\UpdateRequest;
use Modules\Widgets\App\Resources\WidgetNoteResource;

class NoteController extends \App\Http\Controllers\Controller
{
    public function index(): \Inertia\Response
    {
        Seo::breadcrumbs()->add('Заметки', route('admin.widget.note.index'));
        Seo::metaData()->setTitle('Заметки');

        return inertia('Modules/Widget/Note/Index', [
            'filters' => Request::all('search'),
            'notes' => WidgetNoteResource::collection(
                WidgetNote::query()->filter(Request::only('search'))
                    ->orderBy('id', 'DESC')->paginate(auth()->user()->per_page)->withQueryString()
            ),
        ]);
    }

    public function store(StoreRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $data = $request->validated();
        $note = new WidgetNote($data);
        $note->save();
        return WidgetNoteResource::collection(
            WidgetNote::query()->last()->get()
        );
    }

    public function update(UpdateRequest $request, WidgetNote $note): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $note->update($request->validated());
        return WidgetNoteResource::collection(
            WidgetNote::query()->last()->get()
        );
    }

    public function destroy(WidgetNote $note): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $note->delete();
        return WidgetNoteResource::collection(
            WidgetNote::query()->last()->get()
        );
    }

    public function destroyWithRefresh(WidgetNote $note): \Illuminate\Http\RedirectResponse
    {
        $note->delete();
        return redirect()->back();
    }
}
