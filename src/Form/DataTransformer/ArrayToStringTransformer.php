<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ArrayToStringTransformer implements DataTransformerInterface
{
    public function transform($value): string
    {
        return is_array($value) ? implode(', ', $value) : (string) $value;
    }

    public function reverseTransform($value): array
    {
        return array_filter(array_map('trim', explode(',', $value ?? '')));
    }
}
