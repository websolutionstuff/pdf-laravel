<?php

namespace Websolutionstuff\PDF;

use Illuminate\Support\Facades\Config;

class PDF
{
    protected static $format;

    protected $app;
    /** @var  PDFHelper */
    protected $pdf;

    public function __construct($app)
    {
        $this->app = $app;
        $this->reset();
    }

    public function reset()
    {
        $class = Config::get('pdf.use_fpdi') ? FpdiPDFHelper::class : PDFHelper::class;

        $this->pdf = new $class(
            Config::get('pdf.page_orientation', 'P'),
            Config::get('pdf.page_units', 'mm'),
            static::$format ? static::$format : Config::get('pdf.page_format', 'A4'),
            Config::get('pdf.unicode', true),
            Config::get('pdf.encoding', 'UTF-8'),
            false, // Diskcache is deprecated
            Config::get('pdf.pdfa', false)
        );
    }

    public static function changeFormat($format)
    {
        static::$format = $format;
    }

    public function __call($method, $args)
    {
        if (method_exists($this->pdf, $method)) {
            return call_user_func_array([$this->pdf, $method], $args);
        }
        throw new \RuntimeException(sprintf('the method %s does not exists in PDF', $method));
    }

    public function setHeaderCallback($headerCallback)
    {
        $this->pdf->setHeaderCallback($headerCallback);
    }

    public function setFooterCallback($footerCallback)
    {
        $this->pdf->setFooterCallback($footerCallback);
    }
}
