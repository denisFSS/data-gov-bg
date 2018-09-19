@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.alerts-bar')
        @include('partials.admin-nav-bar', ['view' => 'news'])
        <div class="row m-t-lg">
            @if (!is_null($news))
                <div class="col-md-2 col-sm-1"></div>
                <div class="col-md-8 col-sm-10">
                    <div class="frame add-terms">
                        <div class="p-w-md text-center m-b-lg m-t-lg">
                            <h2>{{ __('custom.news_preview') }}</h2>
                        </div>
                        <div class="body">
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ utrans('custom.title') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ $news->title }}</div>
                                </div>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label for="active" class="col-sm-6 col-xs-12 col-form-label">{{ utrans('custom.active') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ !empty($news->active) ? utrans('custom.yes') : utrans('custom.no') }}</div>
                                </div>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ __('custom.browser_head') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ $news->head_title }}</div>
                                </div>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ __('custom.browser_keywords') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ $news->meta_keywords }}</div>
                                </div>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ __('custom.browser_desc') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ $news->meta_description }}</div>
                                </div>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ utrans('custom.valid') }}</label>
                                <div class="col-sm-3 col-xs-12">
                                    <div>{{ __('custom.from') .': '. $news->valid_from }}</div>
                                </div>
                                <div class="col-sm-3 col-xs-12">
                                    <div>{{ __('custom.to') .': '. $news->valid_to }}</div>
                                </div>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ __('custom.short_txt') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ $news->abstract }}</div>
                                </div>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ utrans('custom.content') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ $news->body }}</div>
                                </div>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ __('custom.forum_link') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ $news->forum_link }}</div>
                                </div>
                            </div>

                            <div class="text-center m-b-lg terms-hr">
                                <hr>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ __('custom.created_by') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ $news->created_by }}</div>
                                </div>
                            </div>
                            <div class="form-group row m-b-lg m-t-md">
                                <label class="col-sm-6 col-xs-12 col-form-label">{{ __('custom.created_at') }}</label>
                                <div class="col-sm-6 col-xs-12">
                                    <div>{{ $news->created_at }}</div>
                                </div>
                            </div>
                            @if ($news->created_at != $news->updated_at)
                                <div class="form-group row m-b-lg m-t-md">
                                    <label class="col-sm-6 col-xs-12 col-form-label">{{ __('custom.updated_by') }}</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <div>{{ $news->updated_by }}</div>
                                    </div>
                                </div>
                                <div class="form-group row m-b-lg m-t-md">
                                    <label class="col-sm-6 col-xs-12 col-form-label">{{ __('custom.updated_at') }}</label>
                                    <div class="col-sm-6 col-xs-12">
                                        <div>{{ $news->updated_at }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-1"></div>
            @else
                <div class="col-sm-12 m-t-xl text-center no-info">
                    {{ __('custom.no_info') }}
                </div>
            @endif
        </div>
    </div>
@endsection