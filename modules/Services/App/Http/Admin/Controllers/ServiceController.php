<?php

namespace Modules\Services\App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Kontur\Dashboard\App\DTO\Filter;
use Modules\Services\App\Http\Admin\Requests\UpdatePartialRequest;
use Modules\Services\App\Http\Admin\Requests\UpdateRequest;
use Modules\Services\App\Http\Admin\Requests\IndexRequest;
use Modules\Services\App\Http\Admin\Requests\StoreRequest;
use Modules\Services\App\Http\Admin\Resources\ServiceResource;
use Modules\Services\App\Models\Service;
use Modules\Services\App\Services\ServiceService;
use Modules\Storage\App\Resources\ImageResource;

final class ServiceController extends Controller
{
    private string $moduleName;
    private string $inertiaModulePath;

    public function __construct(private readonly ServiceService $service)
    {
        $this->moduleName = settings('name', 'services', 'Услуги');
        $this->inertiaModulePath = 'Modules/Services';
    }

    public function show(IndexRequest $request, ?int $serviceId = null): Response
    {
        Seo::metaData()->setTitle($this->moduleName);
        Seo::breadcrumbs()->add($this->moduleName, route('admin.services.index'));
        if ($service = $serviceId ? $this->service->getById($serviceId) : null) {
            $this->setBreadcrumbs($service);
        }

        $filter = Filter::make([
            'perPage'       => settings('per_page_admin', default: 10),
            'isActive'      => $request->get('active'),
            'searchTerm'    => $request->get('search', ''),
            'sortColumn'    => $request->get('order_by', 'created_at'),
            'sortOrder'     => $request->get('order_direction', 'desc'),
        ]);

        $services = $this->service->getChildren($service, $filter);

        return inertia("$this->inertiaModulePath/Index", [
            'filters'   => $request->only('search', 'active'),
            'services'  => ServiceResource::collection($services),
            'service'   => $service ? ServiceResource::make($service) : null,
        ]);
    }

    public function create(?int $serviceId = null): Response
    {
        Seo::metaData()->setTitle('Создать');
        Seo::breadcrumbs()->add($this->moduleName, route('admin.services.index'));
        if ($service = $serviceId ? $this->service->getById($serviceId) : null) {
            $this->setBreadcrumbs($service);
        }
        Seo::breadcrumbs()->add('Создать');

        $previewImage = Image::getFreeImages(new Service(), 'preview')?->first();
        $editorImages = Image::getFreeImages(new Service(), 'editor');

        return inertia("$this->inertiaModulePath/Edit", [
            'model'     => Service::class,
            'preview'   => $previewImage ? ImageResource::make($previewImage) : null ,
            'editor'    => ImageResource::collection($editorImages),
            'service'   => null,
            'parent'    => $serviceId,
            'parents'   => $this->service->getAvailableParentsFor(),
        ]);
    }

    public function edit(Service $service): Response
    {
        $service->load(['images', 'seo', 'ancestors']);

        Seo::metaData()->setTitle("Изменить {$service->name}");
        Seo::breadcrumbs()->add($this->moduleName, route('admin.services.index'));
        foreach ($service->ancestors as $ancestor) {
            Seo::breadcrumbs()->add($ancestor->name, route('admin.services.show', $ancestor->id));
        }
        Seo::breadcrumbs()->add("Изменить {$service->name}");

        $previewImage = $service->getImagesByGroup('preview')?->first();
        $editorImages = $service->getImagesByGroup('editor');

        return inertia("$this->inertiaModulePath/Edit", [
            'model'     => Service::class,
            'preview'   => $previewImage ? ImageResource::make($previewImage) : null,
            'editor'    => ImageResource::collection($editorImages),
            'service'   => ServiceResource::make($service),
            'parents'   => $this->service->getAvailableParentsFor($service),
        ]);
    }

    public function store(StoreRequest $request): ServiceResource
    {
        $service = Service::query()->create($request->validated());

        return ServiceResource::make($service);
    }

    public function update(UpdateRequest $request, Service $service): ServiceResource
    {
        $service->update($request->validated());

        return ServiceResource::make($service);
    }

    public function updatePartial(UpdatePartialRequest $request, Service $service): ServiceResource
    {
        $service->update($request->validated());

        return ServiceResource::make($service);
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index');
    }

    private function setBreadcrumbs(Service $service): void
    {
        foreach ($service->ancestors as $ancestor) {
            Seo::breadcrumbs()->add($ancestor->name, route('admin.services.show', $ancestor->id));
        }
        Seo::breadcrumbs()->add($service->name, route('admin.services.show', $service->id));
    }
}
