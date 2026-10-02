<div>
    <div class="mb-3">
        <label class="form-label fw-bold">{{ __('Title') }}:</label>
        <input type="text"
               name="seo[title]"
               class="form-control @error('seo.title') is-invalid @enderror"
               placeholder="{{ __('Title') }}"
               value="{{ old('seo.title', $model->seo->title ?? null) }}"
        >
        @error('seo.title')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">{{ __('Keywords') }}:</label>
        <input type="text"
               name="seo[keywords]"
               class="form-control @error('seo.keywords') is-invalid @enderror"
               placeholder="{{ __('Keywords') }}"
               value="{{ old('seo.keywords', $model->seo->keywords ?? null) }}"
        >
        @error('seo.keywords')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">{{ __('Description') }}:</label>
        <textarea placeholder="{{ __('Description') }}"
                  class="form-control @error('seo.description') is-invalid @enderror"
                  name="seo[description]"
                  rows="3">{{ old('description', $model->seo->description ?? null) }}</textarea>
        @error('seo.description')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
        @enderror
    </div>
    <div class="collapse {{ $model?->seo?->site_map ? 'show':null }}" id="collapseSiteMap">
        <div class="my-2">
            <div class="mb-3">
                <div class="form-check">
                    <input name="seo[site_map]" class="form-check-input" type="checkbox" value="1"
                           id="check_map" {{ $model?->seo?->site_map ? 'checked':null }}>
                    <label class="form-check-label" for="check_map">
                        {{ __('Add to sitemap') }}
                    </label>
                </div>
                @error('seo.site_map')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group input-group-sm mb-3">
                <select class="form-select form-select-sm @error('seo.changefreq') is-invalid @enderror"
                        name="seo[changefreq]" aria-label=".form-select-sm example">
                    <option value="">{{ __('Update frequency') }}</option>
                    <option value="always" {{ $model?->seo?->changefreq == 'always' ? 'selected':null }}>always</option>
                    <option value="hourly" {{ $model?->seo?->changefreq == 'hourly' ? 'selected':null }}>hourly</option>
                    <option value="daily" {{ $model?->seo?->changefreq == 'daily' ? 'selected':null }}>daily</option>
                    <option value="weekly" {{ $model?->seo?->changefreq == 'weekly' ? 'selected':null }}>weekly</option>
                    <option value="monthly" {{ $model?->seo?->changefreq == 'monthly' ? 'selected':null }}>monthly
                    </option>
                    <option value="yearly" {{ $model?->seo?->changefreq == 'yearly' ? 'selected':null }}>yearly</option>
                    <option value="never" {{ $model?->seo?->changefreq == 'never' ? 'selected':null }}>never</option>
                </select>
                <select class="form-select form-select-sm @error('seo.priority') is-invalid @enderror" name="seo[priority]"
                        aria-label=".form-select-sm example">
                    <option value="">{{ __('Priority') }}</option>
                    @for($i = 0.1; $i <= 1.0; $i = $i+0.1)
                        <option
                            value="{{ $i }}" {{ $model?->seo?->priority == strval($i) ? 'selected':null }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSiteMap"
            aria-expanded="false" aria-controls="collapseSiteMap">
        Карта сайта
    </button>

</div>
