<?php

namespace App\Utils\Twig;

use App\Settings;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UrlExtension extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', [$this, 'asset']),
            new TwigFunction('currentUrl', [$this, 'currentUrl'])
        ];
    }

    private function getScheme(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://');
    }

    public function asset(string $path, bool $absolute = false): string
    {
        $manifest = file_get_contents(Settings::getString('assets.manifestPath'));

        if ($manifest !== false) {
            $manifest = json_decode($manifest, true);

            if (is_array($manifest) && isset($manifest[$path])) {
                return ($absolute ? $this->getScheme() . $_SERVER['HTTP_HOST'] : '') . $manifest[$path];
            }
        }

        return Settings::getString('assets.publicPath') . $path;
    }

    public function currentUrl(): string
    {
        return $this->getScheme() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}
