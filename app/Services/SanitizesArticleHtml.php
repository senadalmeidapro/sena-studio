<?php

namespace App\Services;

use DOMDocument;
use DOMElement;

class SanitizesArticleHtml
{
    private const ALLOWED_TAGS = [
        'a', 'b', 'blockquote', 'br', 'code', 'em', 'h2', 'h3', 'i', 'li', 'ol',
        'p', 'pre', 's', 'strong', 'u', 'ul',
    ];

    public function sanitize(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<div>'.mb_encode_numericentity($html, [0x80, 0x10FFFF, 0, ~0], 'UTF-8').'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD,
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $document->documentElement;

        if (! $root) {
            return '';
        }

        $this->sanitizeNode($root);

        return collect($root->childNodes)
            ->map(fn ($node): string => $document->saveHTML($node) ?: '')
            ->implode('');
    }

    private function sanitizeNode(DOMElement $node): void
    {
        for ($child = $node->firstChild; $child; $child = $next) {
            $next = $child->nextSibling;

            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    $this->unwrapOrRemove($child);

                    continue;
                }

                $this->sanitizeAttributes($child, $tag);
                $this->sanitizeNode($child);
            }
        }
    }

    private function sanitizeAttributes(DOMElement $node, string $tag): void
    {
        for ($index = $node->attributes->length - 1; $index >= 0; $index--) {
            $attribute = $node->attributes->item($index);

            if (! $attribute) {
                continue;
            }

            $name = strtolower($attribute->name);

            if ($tag !== 'a' || $name !== 'href') {
                $node->removeAttribute($attribute->name);

                continue;
            }

            $href = trim($attribute->value);
            $scheme = strtolower((string) parse_url($href, PHP_URL_SCHEME));

            if ($href === '' || ($scheme !== '' && ! in_array($scheme, ['http', 'https', 'mailto'], true))) {
                $node->removeAttribute('href');
            }
        }

        if ($tag === 'a' && $node->hasAttribute('href')) {
            $node->setAttribute('rel', 'nofollow noopener noreferrer');
            $node->setAttribute('target', '_blank');
        }
    }

    private function unwrapOrRemove(DOMElement $node): void
    {
        $parent = $node->parentNode;

        if (! $parent) {
            return;
        }

        if (in_array(strtolower($node->tagName), ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input'], true)) {
            $parent->removeChild($node);

            return;
        }

        while ($node->firstChild) {
            $parent->insertBefore($node->firstChild, $node);
        }

        $parent->removeChild($node);
    }
}
