<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('join_or_string', [$this, 'joinOrString']),
            new TwigFilter('format_popup', [$this, 'formatPopup'], ['is_safe' => ['html']]),
        ];
    }

    public function joinOrString($value, string $emptyText = '-'): string
    {
        if (is_iterable($value)) {
            $array = is_array($value) ? $value : iterator_to_array($value);
            if (count($array) === 0) {
                return $emptyText;
            }
            return implode(', ', $array);
        }
        if (empty($value)) {
            return $emptyText;
        }
        return (string) $value;
    }

    /**
     * Minimal formatter for popup content supporting line breaks and limited colors.
     * Supported tags:
     *  - [b]bold[/b], [i]italic[/i], [u]underline[/u]
     *  - [red]...[/red], [green]...[/green], [blue]...[/blue]
     *  - [color=#RRGGBB]...[/color] (hex only)
     *  - [size=small]...[/size], [size=large]...[/size]
     *  - [size=12]...[/size] (taille numérique en px: 8–72)
     */
    public function formatPopup(?string $text): string
    {
        if ($text === null || $text === '') {
            return '';
        }

        // Escape HTML first to avoid injection
        $escaped = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        // Basic styles replacements
        $replacements = [
            '/\[b\](.*?)\[\/b\]/si' => '<strong>$1</strong>',
            '/\[i\](.*?)\[\/i\]/si' => '<em>$1</em>',
            '/\[u\](.*?)\[\/u\]/si' => '<u>$1</u>',
            '/\[red\](.*?)\[\/red\]/si' => '<span style="color:#d32f2f;">$1</span>',
            '/\[green\](.*?)\[\/green\]/si' => '<span style="color:#2e7d32;">$1</span>',
            '/\[blue\](.*?)\[\/blue\]/si' => '<span style="color:#1565c0;">$1</span>',
            // [color=#AABBCC]...
            '/\[color=\#([0-9a-fA-F]{6})\](.*?)\[\/color\]/si' => '<span style="color:#$1;">$2</span>',
            // Sizes
            '/\[size=small\](.*?)\[\/size\]/si' => '<span style="font-size:0.9rem;">$1</span>',
            '/\[size=large\](.*?)\[\/size\]/si' => '<span style="font-size:1.2rem;">$1</span>',
        ];

        $formatted = $escaped;
        foreach ($replacements as $pattern => $replacement) {
            $formatted = preg_replace($pattern, $replacement, $formatted);
        }

        // Numeric size: [size=12]...[/size] → 12px; clamp 8–72
        $formatted = preg_replace_callback('/\[size=([0-9]{1,3})\](.*?)\[\/size\]/si', function($m) {
            $n = (int)$m[1];
            if ($n < 8) { $n = 8; }
            if ($n > 72) { $n = 72; }
            return '<span style="font-size:' . $n . 'px;">' . $m[2] . '</span>';
        }, $formatted);

        // Convert newlines to <br>
        $formatted = nl2br($formatted);

        return $formatted;
    }
}
