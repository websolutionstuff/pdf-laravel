# Laravel 6-7-8-9 HTML To PDF Converter

[![Latest Stable Version](http://poser.pugx.org/websolutionstuff/pdf-laravel/v)](https://packagist.org/packages/websolutionstuff/pdf-laravel) [![Total Downloads](http://poser.pugx.org/websolutionstuff/pdf-laravel/downloads)](https://packagist.org/packages/websolutionstuff/pdf-laravel) [![License](http://poser.pugx.org/websolutionstuff/pdf-laravel/license)](https://packagist.org/packages/websolutionstuff/pdf-laravel)

## Installation

The Laravel PDF service provider can be installed via [composer](http://getcomposer.org) by requiring the `websolutionstuff/pdf-laravel` package in your project's `composer.json` file.

```
composer require websolutionstuff/pdf-laravel
```

or

Laravel 5.5+ will use the auto-discovery function.

```json
{
    "require": {
        "websolutionstuff/pdf-laravel": "^1.0"
    }
}
```

If you don't use auto-discovery you will need to include the service provider and facade in the `config/app.php` file.


```php
'providers' => [
    ...
    ...
    Websolutionstuff\PDF\ServiceProvider::class
]

//...

'aliases' => [
    ...
    ..
    'PDF' => Websolutionstuff\PDF\Facades\PDF::class
]
```

## Lumen

In the Lumen add the following lines:

```php
$app->register(Websolutionstuff\PDF\ServiceProvider::class);
class_alias(Websolutionstuff\PDF\Facades\PDF::class, 'PDF');
```

## Example

Let's see some beautiful examples.

```php
use PDF; // at the top of the file

  PDF::SetTitle('Websolutionstuff PDF File');
  PDF::AddPage();
  PDF::Write(0, 'Websolutionstuff PDF File Generate');
  PDF::Output('websolutionstuff.pdf');
```

another example for generating multiple PDF's

```php
use PDF; // at the top of the file

  for ($i = 0; $i < 5; $i++) {
    PDF::SetTitle('Websolutionstuff PDF File'.$i);
    PDF::AddPage();
    PDF::Write(0, 'Websolutionstuff PDF File Generate'.$i);
    PDF::Output(public_path('websolutionstuff' . $i . '.pdf'), 'F');
    PDF::reset();
  }
```

#### Example 1: Add HTML Text

```php
        $html = '<h1 style="color:red;">Hello World</h1>';
        
        PDF::SetTitle('Hello World');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('Example_1.pdf');
```

#### Example 2: without Header and Footer

```php
        // remove default header/footer
        PDF::setPrintHeader(false);
        PDF::setPrintFooter(false);
        
        // set margins
        PDF::SetMargins(20,20,20);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, 20);

        // set font
        PDF::SetFont('times', 'BI', 20);

        // add a page
        PDF::AddPage();

        // set some text to print
        $txt = <<<EOD
        PDF Example 2

        Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.
        EOD;

        // print a block of text using Write()
        PDF::Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);        

        //Close and output PDF document
        PDF::Output('example_2.pdf', 'I');
```

## Configuration

PDF-Laravel comes with some basic configuration.
If you want to override the defaults, you can publish the config, like so:

    php artisan vendor:publish --provider="Websolutionstuff\PDF\ServiceProvider"

Now access `config/pdf.php` to customize.

 * use_original_header is to used the original `Header()` from PDF.
    * Please note that `PDF::setHeaderCallback(function($pdf){})` overrides this settings.
 * use_original_footer is to used the original `Footer()` from PDF.
    * Please note that `PDF::setFooterCallback(function($pdf){})` overrides this settings.

## Header/Footer helpers

You can use for Header and Footer.

* `PDF::setHeaderCallback(function($pdf){})` 
* `PDF::setFooterCallback(function($pdf){})`

## Functions

### writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')

- Supported tags are: a, b, blockquote, br, dd, del, div, dl, dt, em, font, h1, h2, h3, h4, h5, h6, hr, i, img, li, ol, p, pre, small, span, strong, sub, sup, table, tcpdf, td, th, thead, tr, tt, u, ul

- @param string $html text to display
- @param boolean $ln if true add a new line after text (default = true)
- @param boolean $fill Indicates if the background must be painted (true) or transparent (false).
- @param boolean $reseth if true reset the last cell height (default false).
- @param boolean $cell if true add the current left (or right for RTL) padding to each Write (default false).
- @param string $align Allows to center or align the text. Possible values are:<ul><li>L : left align</li><li>C : center</li><li>R : right align</li><li>'' : empty string : left for LTR or right for RTL</li></ul>

### setPrintHeader(true)

- Set a flag to print page header.
- true is default value.

### setPrintFooter(true)

- Set a flag to print page footer.
- true is default value.

### setMargins($left, $top, $right=null, $keepmargins=false)

- Defines the left, top and right margins.
- @param int|float $left Left margin.
- @param int|float $top Top margin.
- @param int|float|null $right Right margin. Default value is the left one.
- @param boolean $keepmargins if true overwrites the default page margins

### setAutoPageBreak($auto, $margin=0)

- Enables or disables the automatic page breaking mode. When enabling, the second parameter is the distance from the bottom of the page that defines the triggering limit. By default, the mode is on and the margin is 2 cm.
- @param boolean $auto Boolean indicating if mode should be on or off.
- @param float $margin Distance from the bottom of the page.

### setFont($family, $style='', $size=null, $fontfile='', $subset='default', $out=true)

- Sets the font used to print character strings.
- The font can be either a standard one or a font added via the AddFont() method. Standard fonts use Windows encoding cp1252 (Western Europe).
- The method can be called before the first page is created and the font is retained from page to page.
- If you just wish to change the current font size, it is simpler to call SetFontSize().
- @param string $family Family font. It can be either a name defined by AddFont() or one of the standard Type1 families (case insensitive):<ul><li>times (Times-Roman)</li><li>timesb (Times-Bold)</li><li>timesi (Times-Italic)</li><li>timesbi (Times-BoldItalic)</li><li>helvetica (Helvetica)</li><li>helveticab (Helvetica-Bold)</li><li>helveticai (Helvetica-Oblique)</li><li>helveticabi (Helvetica-BoldOblique)</li><li>courier (Courier)</li><li>courierb (Courier-Bold)</li><li>courieri (Courier-Oblique)</li><li>courierbi (Courier-BoldOblique)</li><li>symbol (Symbol)</li><li>zapfdingbats (ZapfDingbats)</li></ul> It is also possible to pass an empty string. In that case, the current family is retained.
- @param string $style Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line through</li><li>O: overline</li></ul> or any combination. The default value is regular. Bold and italic styles do not apply to Symbol and ZapfDingbats basic fonts or other fonts when not defined.
- @param float|null $size Font size in points. The default value is the current size. If no size has been specified since the beginning of the document, the value taken is 12
- @param string $fontfile The font definition file. By default, the name is built from the family and style, in lower case with no spaces.
- @param mixed $subset if true embedd only a subset of the font (stores only the information related to the used characters); if false embedd full font; if 'default' uses the default value set using setFontSubsetting(). This option is valid only for TrueTypeUnicode fonts. If you want to enable users to change the document, set this parameter to false. If you subset the font, the person who receives your PDF would need to have your same font in order to make changes to your PDF. The file size of the PDF would also be smaller because you are embedding only part of a font.
- @param boolean $out if true output the font size command, otherwise only set the font properties.

### AddPage($orientation='', $format='', $keepmargins=false, $tocpage=false)

- Adds a new page to the document. If a page is already present, the Footer() method is called first to output the footer (if enabled). Then the page is added, the current position set to the top-left corner according to the left and top margins (or top-right if in RTL mode), and Header() is called to display the header (if enabled).
- The origin of the coordinate system is at the top-left corner (or top-right for RTL) and increasing ordinates go downwards.
- @param string $orientation page orientation. Possible values are (case insensitive):<ul><li>P or PORTRAIT (default)</li><li>L or LANDSCAPE</li></ul>
- @param mixed $format The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
- @param boolean $keepmargins if true overwrites the default page margins with the current margins
- @param boolean $tocpage if true set the tocpage state to true (the added page will be used to display Table Of Content).

### Write($h, $txt, $link='', $fill=false, $align='', $ln=false, $stretch=0, $firstline=false, $firstblock=false, $maxh=0, $wadj=0, $margin=null)

- This method prints text from the current position.<br />
- @param float $h Line height
- @param string $txt String to print
- @param mixed $link URL or identifier returned by AddLink()
- @param boolean $fill Indicates if the cell background must be painted (true) or transparent (false).
- @param string $align Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
- @param boolean $ln if true set cursor at the bottom of the line, otherwise set cursor at the top of the line.
- @param int $stretch font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
- @param boolean $firstline if true prints only the first line and return the remaining string.
- @param boolean $firstblock if true the string is the starting of a line.
- @param float $maxh maximum height. It should be >= $h and less then remaining space to the bottom of the page, or 0 for disable this feature.
- @param float $wadj first line width will be reduced by this amount (used in HTML mode).
- @param array|null $margin margin array of the parent container
- @return mixed Return the number of cells or the remaining string if $firstline = true.

### Output($name='doc.pdf', $dest='I')

- Send the document to a given destination: string, local file or browser.
- In the last case, the plug-in may be used (if present) or a download ("Save as" dialog box) may be forced.<br />
- The method first calls Close() if necessary to terminate the document.
- @param string $name The name of the file when saved
- @param string $dest Destination where to send the document. It can take one of the following values:<ul><li>I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.</li><li>D: send to the browser and force a file download with the name given by name.</li><li>F: save to a local server file with the name given by name.</li><li>S: return the document as a string (name is ignored).</li><li>FI: equivalent to F + I option</li><li>FD: equivalent to F + D option</li><li>E: return the document as base64 mime multi-part email attachment (RFC 2045)</li></ul>