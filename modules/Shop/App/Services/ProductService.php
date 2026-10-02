<?php

namespace Modules\Shop\App\Services;

use Galtsevt\LaravelStorage\App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Shop\App\Models\{ShopAttributeValue, ShopProduct};
use Modules\Shop\App\Requests\Product\{StoreProductRequest, UpdateProductRequest};
use Modules\Shop\App\Resources\ShopProductResource;

class ProductService
{

    public function store(StoreProductRequest $request): ShopProductResource
    {
        $data = $request->validated();
        $product = new ShopProduct($data);
        $product->save();
        $this->saveAttributes($product, $data);
        $request->session()->flash('success', 'Продукт добавлен');
        return new ShopProductResource($product);
    }

    public function update(UpdateProductRequest $request, ShopProduct $shopProduct): ShopProductResource
    {
        $data = $request->validated();
        $shopProduct->update($data);
        $this->saveAttributes($shopProduct, $data);
        $this->removeMissingAttributes($shopProduct, $data);
        return new ShopProductResource($shopProduct);
    }

    public function clone(ShopProduct $shopProduct): ShopProduct
    {
        $shopProduct->load('images', 'attributesValue');
        $newShopProduct = $shopProduct->replicate();
        $lastProduct = ShopProduct::query()->latest()->first();
        $newShopProduct->alias = Str::slug($shopProduct['title']) . $lastProduct->id + 1;
        $newShopProduct->save();

        foreach ($shopProduct->getImagesByGroup('preview') as $image) {
            $newImage = $image->replicate();
            $newShopProduct->images()->save($this->cloneImage($image, $newImage, $newShopProduct));
        }

        foreach ($shopProduct->attributesValue as $attributeValue) {
            $newAttributeValue = $attributeValue->replicate();
            $newShopProduct->attributesValue()->save($newAttributeValue);
        }

        return $newShopProduct;
    }

    /**
     * Клонирование изображения
     *
     * @param Image $image
     * @param Image $newImage
     * @param ShopProduct $shopProduct
     *
     * @return Image
     */
    private function cloneImage(Image $image, Image $newImage, ShopProduct $shopProduct): Image
    {
        $pathStorage = 'app/public/images/shopproduct/';
        $oldPathFull = storage_path($pathStorage . 'full/' . $image['name']);
        $oldPathThmb = storage_path($pathStorage . 'thmb/' . $image['name']);
        $newFilename = uniqid() . '_' . $shopProduct['id'] . '.webp';
        $newPathFull = storage_path($pathStorage .'full/' . $newFilename);
        $newPathThmb = storage_path($pathStorage .'thmb/' . $newFilename);

        if (file_exists($oldPathFull)) {
            File::copy($oldPathFull, $newPathFull);
            $newImage['name'] = $newFilename;
        }

        if (file_exists($oldPathThmb)) {
            File::copy($oldPathThmb, $newPathThmb);
        }

        return $newImage;
    }

    private function saveAttributes(ShopProduct $shopProduct, array $data): void
    {

        $attributes = $this->nestedToDefault($data['attributes_for_edit'] ?? null);
        foreach ($attributes as $attribute) {
            if ($shopProduct->attributesValue->filter(function ($value) use ($attribute) {
                return $value->attribute_id == $attribute['attribute_id'] && $value->value == $attribute['value'];
            })->first()) {
                continue;
            } elseif ($model = $shopProduct->attributesValue->where(['attribute_id' => $attribute['attribute_id']])->first()) {
                $model->update($attribute);
            } else {
                $attribute['product_id'] = $shopProduct->id;
                ShopAttributeValue::query()->create($attribute);
            }
        }
    }

    private function nestedToDefault(?array $data): array
    {
        $result = [];
        if (empty($data)) return $result;
        foreach ($data as $item) {
            if (is_array($item['value'])) {
                foreach ($item['value'] as $itemValue) {
                    $result[] = [
                        'attribute_id' => $item['attribute_id'],
                        'value' => $itemValue,
                    ];
                }
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }

    private function removeMissingAttributes(ShopProduct $shopProduct, array $data): void
    {
        $attributes = collect($this->nestedToDefault($data['attributes_for_edit'] ?? null));
        foreach ($shopProduct->attributesValue()->get() as $attribute) {
            if (!$attributes->filter(function ($value) use ($attribute) {
                return $attribute->attribute_id == $value['attribute_id'] && $attribute->value == $value['value'];
            })->first()) {
                $attribute->delete();
            }
        }
    }

}
