<?php
namespace App\TwigExtensions;

use Illuminate\Translation\Translator;

/**
 * Registers the Illuminate Translator with trans function in Twig.
 * The variable app.locale is registered as a global twig variables.
 */
class Translate extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function getName()
    {
        return 'slim_translator';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('trans', [$this->translator, 'trans'])
        ];
    }

    public function getGlobals()
    {
        return [
            'app' => ['locale' => $this->translator->getLocale()],
        ];
    }
}
