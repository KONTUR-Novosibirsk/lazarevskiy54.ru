# Seo package for laravel


1. [ ] **`laravel 9/10`**

## Установка
1) Установить пакет `composer require galsevt/laravel-seo`
2) выполнить миграции `php artisan migrate`
## Использование  
Расширить модель с помощью trait  
`Galtsevt\LaravelSeo\Traits\HasSeo`  
Добавить интерфейс SeoInterface.  
`Galtsevt\LaravelSeo\Interfaces\SeoInterface`  
Модель должна реализовать методы интерфейса:  
```php 
public function getUrl(): string;   
public function getDate(): string;
```

Добавление и обновление сео через SeoService передав модель методу saveData:    
```php 
$seoService->saveData($news);
```
Автоматическая генерация карты сайта, каждый день в час ночи:  
```php 
$schedule->call(function () {  
$service = new SeoService();  
$service->makeSitemap(new SiteMapGenerator());  
})->dailyAt('1:00');
```

### Хлебные крошки

**Добавление хлебных крошек через фасад `Galtsevt\LaravelSeo\Facades\Seo`**:

```php 
Seo::breadcrumbs()->add('Name', 'Url'); // Один элемент

Seo::breadcrumbs()->addList([
   'url' => 'name',
   'url1' => 'name1',
]);  // несколько элементов
```

**Получить весь список:**
```php 
Seo::breadcrumbs()->getAll();
```

**Вывести через готовый blade component:**
```html
<x-laravel-seo::breadcrumbs/>
```

### Seo данные
Доступ к мета данным через фасад `Galtsevt\LaravelSeo\Facades\Seo`
```php 
Seo::metaData();
```

