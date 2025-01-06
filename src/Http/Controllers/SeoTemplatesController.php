<?php

namespace CoolmacJedi\SeoService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use CoolmacJedi\SeoService\Models\SeoTemplate;
use CoolmacJedi\SeoService\Services\SeoManager;

class SeoTemplatesController extends Controller
{
    public function index()
    {
        $allTemplates = SeoTemplate::orderBy('model_type')->orderBy('key')->get();

        return view('laravel-seo::templates-edit', compact('allTemplates'));
    }

    public function update(Request $request, SeoManager $seoManager)
    {
        $templatesInput = $request->input('templates', []);

        foreach ($templatesInput as $id => $templateValue) {
            $seoTemplate = SeoTemplate::find($id);
            if ($seoTemplate) {
                $seoTemplate->template = $templateValue;
                $seoTemplate->save();
            }
        }

        return redirect()->back()->with('status', 'Templates updated');
    }
}
