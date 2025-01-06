<?php

namespace TradeJedi\SeoService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TradeJedi\SeoService\Services\SeoManager;

class SeoTagsController extends Controller
{
    public function edit($model, $id, SeoManager $seoManager)
    {
        $modelClass = config("seo.models.$model");
        abort_if(!$modelClass, 404);

        $record = $modelClass::findOrFail($id);

        $seoKeys = config('seo.keys', []);
        $seo = $seoManager->getSeoForModel($record);

        return view('laravel-seo::edit', compact('model', 'id', 'seo', 'seoKeys'));
    }

    public function update($model, $id, Request $request, SeoManager $seoManager)
    {
        $modelClass = config("seo.models.$model");
        abort_if(!$modelClass, 404);

        $record = $modelClass::findOrFail($id);

        // ['seo' => [ 'title' => '...', 'description' => '...' ]]
        $seoData = $request->input('seo', []);

        foreach ($seoData as $key => $value) {
            $seoManager->setSeoTag($record, $key, $value);
        }

        return redirect()->back()->with('status', 'SEO Tags updated');
    }
}
