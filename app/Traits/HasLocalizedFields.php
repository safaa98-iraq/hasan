<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasLocalizedFields
{
    /**
     * Return the value of a bilingual field in the active locale,
     * falling back to English when an Arabic value is missing.
     */
    public function localized(string $field): ?string
    {
        $locale = app()->getLocale() === 'ar' ? 'ar' : 'en';

        return $this->{"{$field}_{$locale}"} ?? $this->{"{$field}_en"};
    }

    /**
     * Convert a double-newline separated body into HTML paragraphs.
     */
    public function localizedParagraphs(string $field): string
    {
        $body = (string) $this->localized($field);

        $paragraphs = array_map(
            fn ($paragraph) => '<p>' . e(trim($paragraph)) . '</p>',
            preg_split('/\r?\n\s*\r?\n/', trim($body)) ?: []
        );

        return implode("\n", $paragraphs);
    }

    public function getTitleAttribute(): ?string
    {
        return $this->localized('title');
    }

    public function getSubtitleAttribute(): ?string
    {
        return $this->localized('subtitle');
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->localized('description');
    }

    public function getNameAttribute(): ?string
    {
        return $this->localized('name');
    }

    public function getLabelAttribute(): ?string
    {
        return $this->localized('label');
    }

    public function getExcerptAttribute(): ?string
    {
        return $this->localized('excerpt');
    }

    public function getBodyAttribute(): ?string
    {
        return $this->localized('body');
    }

    public function getPriceAttribute(): ?string
    {
        return $this->localized('price');
    }

    public function getDurationAttribute(): ?string
    {
        return $this->localized('duration');
    }

    public function getIncludedAttribute(): ?string
    {
        return $this->localized('included');
    }

    public function getExcludedAttribute(): ?string
    {
        return $this->localized('excluded');
    }

    /**
     * "01", "02" numbering motif, derived from the stored order.
     */
    public function getNumberAttribute(): string
    {
        return Str::padLeft((string) $this->order, 2, '0');
    }
}