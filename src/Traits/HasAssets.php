<?php

namespace Encore\Admin\Traits;

trait HasAssets
{
    /**
     * @var array
     */
    public static $script = [];

    /**
     * @var array
     */
    public static $deferredScript = [];

    /**
     * @var array
     */
    public static $style = [];

    /**
     * @var array
     */
    public static $css = [];

    /**
     * @var array
     */
    public static $js = [];

    /**
     * @var array
     */
    public static $html = [];

    /**
     * @var array
     */
    public static $headerJs = [];

    /**
     * @var string
     */
    public static $manifest = 'vendor/laravel-admin/minify-manifest.json';

    /**
     * @var array
     */
    public static $manifestData = [];

    /**
     * @var array
     */
    public static $min = [
        'js'  => 'vendor/laravel-admin/laravel-admin.min.js',
        'css' => 'vendor/laravel-admin/laravel-admin.min.css',
    ];

    /**
     * @var array
     */
    public static $baseCss = [
        'vendor/laravel-admin/fontawesome-free/css/all.min.css',
        'vendor/laravel-admin/laravel-admin/laravel-admin.css',
        'vendor/laravel-admin/nprogress/nprogress.css',
        'vendor/laravel-admin/sweetalert2/sweetalert2.min.css',
        'vendor/laravel-admin/nestable/nestable.css',
        'vendor/laravel-admin/AdminLTE/css/adminlte.min.css',
        'vendor/laravel-admin/bootstrap-iconpicker/dist/css/bootstrap-iconpicker.min.css',
        'vendor/laravel-admin/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
        'vendor/laravel-admin/icheck-bootstrap/icheck-bootstrap.min.css',
        'vendor/laravel-admin/bootstrap-fileinput/css/fileinput.min.css?v=5.1.3',
        'vendor/laravel-admin/bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        'vendor/laravel-admin/select2/css/select2.min.css',
        'vendor/laravel-admin/select2-bootstrap4-theme/select2-bootstrap4.min.css',
        'vendor/laravel-admin/bootstrap4-toggle/css/bootstrap4-toggle.min.css',
        'vendor/laravel-admin/bootstrap4-duallistbox/bootstrap-duallistbox.min.css',
//        'vendor/laravel-admin/ion-rangeslider/css/ion.rangeSlider.min.css',

    ];

    /**
     * @var array
     */
    public static $baseJs = [
        'vendor/laravel-admin/bootstrap/js/bootstrap.bundle.min.js',
        'vendor/laravel-admin/AdminLTE/js/adminlte.min.js',
        'vendor/laravel-admin/jquery-pjax/jquery.pjax.js',
        'vendor/laravel-admin/nprogress/nprogress.js',
        'vendor/laravel-admin/nestable/jquery.nestable.js',
        'vendor/laravel-admin/sweetalert2/sweetalert2.min.js',
        'vendor/laravel-admin/laravel-admin/laravel-admin.js',
        'vendor/laravel-admin/jquery.initialize/jquery.initialize.min.js',
        'vendor/laravel-admin/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.min.js',
        'vendor/laravel-admin/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.bundle.min.js',
        'vendor/laravel-admin/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js',
        'vendor/laravel-admin/bootstrap-fileinput/js/fileinput.min.js?v=5.1.3',
        'vendor/laravel-admin/bootstrap-fileinput/themes/fas/theme.min.js',
        'vendor/laravel-admin/bootstrap-fileinput/js/plugins/piexif.min.js?v=5.1.3',
        'vendor/laravel-admin/bootstrap-fileinput/js/plugins/purify.min.js?v=5.1.3',
        'vendor/laravel-admin/bootstrap-fileinput/js/plugins/sortable.min.js?v=5.1.3',
        'vendor/laravel-admin/moment/moment-with-locales.min.js',
        'vendor/laravel-admin/bootstrap4-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        'vendor/laravel-admin/select2/js/select2.full.min.js',
        'vendor/laravel-admin/bootstrap-input-spinner/bootstrap-input-spinner.js',
        'vendor/laravel-admin/bootstrap4-toggle/js/bootstrap4-toggle.min.js',
        'vendor/laravel-admin/inputmask/min/jquery.inputmask.bundle.min.js',
        'vendor/laravel-admin/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js',
//        'vendor/laravel-admin/ion-rangeslider/js/ion.rangeSlider.min.js',
//        'https://cdn.jsdelivr.net/npm/wangeditor@3.1.1/release/wangEditor.min.js',
    ];

    /**
     * @var string
     */
    public static $jQuery = 'vendor/laravel-admin/jquery/jquery.min.js';

    /**
     * @var array
     */
    public static $minifyIgnores = [];

    /**
     * Add css or get all css.
     *
     * @param null $css
     * @param bool $minify
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function css($css = null, $minify = true)
    {
        static::ignoreMinify($css, $minify);

        if (!is_null($css)) {
            return self::$css = array_merge(self::$css, (array) $css);
        }

        if (!$css = static::getMinifiedCss()) {
            $css = array_merge(static::$css, static::baseCss());
        }

        $css = array_filter(array_unique($css));

        return view('admin::partials.css', compact('css'));
    }

    /**
     * @param null $css
     * @param bool $minify
     *
     * @return array|null
     */
    public static function baseCss($css = null, $minify = true)
    {
        static::ignoreMinify($css, $minify);

        if (!is_null($css)) {
            return static::$baseCss = $css;
        }

        $skin = config('admin.skin', 'skin-blue-light');

        array_unshift(static::$baseCss, "vendor/laravel-admin/AdminLTE/dist/css/skins/{$skin}.min.css");

        return static::$baseCss;
    }

    /**
     * Add js or get all js.
     *
     * @param null $js
     * @param bool $minify
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function js($js = null, $minify = true)
    {
        static::ignoreMinify($js, $minify);

        if (!is_null($js)) {
            return self::$js = array_merge(self::$js, (array) $js);
        }

        if (!$js = static::getMinifiedJs()) {
            $js = array_merge(static::baseJs(), static::$js);
        }

        $js = array_filter(array_unique($js));

        return view('admin::partials.js', compact('js'));
    }

    /**
     * Add js or get all js.
     *
     * @param null $js
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function headerJs($js = null)
    {
        if (!is_null($js)) {
            return self::$headerJs = array_merge(self::$headerJs, (array) $js);
        }

        return view('admin::partials.js', ['js' => array_unique(static::$headerJs)]);
    }

    /**
     * @param null $js
     * @param bool $minify
     *
     * @return array|null
     */
    public static function baseJs($js = null, $minify = true)
    {
        static::ignoreMinify($js, $minify);

        if (!is_null($js)) {
            return static::$baseJs = $js;
        }

        return static::$baseJs;
    }

    /**
     * @param string $assets
     * @param bool   $ignore
     */
    public static function ignoreMinify($assets, $ignore = true)
    {
        if (!$ignore) {
            static::$minifyIgnores[] = $assets;
        }
    }

    /**
     * @param string $script
     * @param bool   $deferred
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function script($script = '', $deferred = false)
    {
        if (!empty($script)) {
            if ($deferred) {
                return self::$deferredScript = array_merge(self::$deferredScript, (array) $script);
            }

            return self::$script = array_merge(self::$script, (array) $script);
        }

        $script = collect(static::$script)
            ->merge(static::$deferredScript)
            ->unique()
            ->map(function ($line) {
                return $line;
                //@see https://stackoverflow.com/questions/19509863/how-to-remove-js-comments-using-php
                $pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
                $line = preg_replace($pattern, '', $line);

                return preg_replace('/\s+/', ' ', $line);
            });

        return view('admin::partials.script', compact('script'));
    }

    /**
     * @param string $style
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function style($style = '')
    {
        if (!empty($style)) {
            return self::$style = array_merge(self::$style, (array) $style);
        }

        $style = collect(static::$style)
            ->unique()
            ->map(function ($line) {
                return preg_replace('/\s+/', ' ', $line);
            });

        return view('admin::partials.style', compact('style'));
    }

    /**
     * @param string $html
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function html($html = '')
    {
        if (!empty($html)) {
            return self::$html = array_merge(self::$html, (array) $html);
        }

        return view('admin::partials.html', ['html' => array_unique(self::$html)]);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    protected static function getManifestData($key)
    {
        if (!empty(static::$manifestData)) {
            return static::$manifestData[$key];
        }

        static::$manifestData = json_decode(
            file_get_contents(public_path(static::$manifest)),
            true
        );

        return static::$manifestData[$key];
    }

    /**
     * @return bool|mixed
     */
    protected static function getMinifiedCss()
    {
        if (!config('admin.minify_assets') || !file_exists(public_path(static::$manifest))) {
            return false;
        }

        return static::getManifestData('css');
    }

    /**
     * @return bool|mixed
     */
    protected static function getMinifiedJs()
    {
        if (!config('admin.minify_assets') || !file_exists(public_path(static::$manifest))) {
            return false;
        }

        return static::getManifestData('js');
    }

    /**
     * @return string
     */
    public function jQuery()
    {
        return admin_asset(static::$jQuery);
    }

    /**
     * @param $component
     */
    public static function component($component, $data = [])
    {
        $string = view($component, $data)->render();

        $dom = new \DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>'.$string);
        libxml_use_internal_errors(false);

        if ($head = $dom->getElementsByTagName('head')->item(0)) {
            foreach ($head->childNodes as $child) {
                if ($child instanceof \DOMElement) {
                    if ($child->tagName == 'style' && !empty($child->nodeValue)) {
                        static::style($child->nodeValue);
                        continue;
                    }

                    if ($child->tagName == 'link' && $child->hasAttribute('href')) {
                        static::css($child->getAttribute('href'));
                    }

                    if ($child->tagName == 'script') {
                        if ($child->hasAttribute('src')) {
                            static::js($child->getAttribute('src'));
                        } else {
                            static::script(';(function () {'.$child->nodeValue.'})();');
                        }

                        continue;
                    }
                }
            }
        }

        $render = '';

        if ($body = $dom->getElementsByTagName('body')->item(0)) {
            foreach ($body->childNodes as $child) {
                if ($child instanceof \DOMElement) {
                    if ($child->tagName == 'style' && !empty($child->nodeValue)) {
                        static::style($child->nodeValue);
                        continue;
                    }

                    if ($child->tagName == 'script' && !empty($child->nodeValue)) {
                        static::script(';(function () {'.$child->nodeValue.'})();');
                        continue;
                    }

                    if ($child->tagName == 'template') {
                        $html = '';
                        foreach ($child->childNodes as $childNode) {
                            $html .= $child->ownerDocument->saveHTML($childNode);
                        }
                        $html && static::html($html);
                        continue;
                    }
                }

                $render .= $body->ownerDocument->saveHTML($child);
            }
        }

        return trim($render);
    }
}
