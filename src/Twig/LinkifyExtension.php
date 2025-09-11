<?php


namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class LinkifyExtension extends AbstractExtension
{
public function getFilters(): array
{
return [
new TwigFilter('linkify', [$this, 'linkify'], ['is_safe' => ['html']]),
];
}

public function linkify(string $text): string
{
// Regex pour détecter les URLs
$regex = '/(https?:\/\/[^\s]+)/';

// Remplacement des URLs par des liens HTML cliquables
return preg_replace($regex, '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $text);
}
}
