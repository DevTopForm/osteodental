<?php
/**
 * Smarty output filter to add loading="lazy" and decoding="async" to all <img> tags
 * Compatible with Smarty 2/3/4/5 via BC layer
 *
 * Usage: legacy: $smarty->load_filter('output', 'lazyimg');
 */
function smarty_outputfilter_lazyimg($source, $template = null)
{
    // Fast check: if there is no <img in output, skip
    if (stripos($source, '<img') === false) {
        return $source;
    }

    $source = preg_replace_callback('/<img\b[^>]*>/i', function ($matches) {
        $tag = $matches[0];

        $hasLoading = stripos($tag, ' loading=') !== false;
        $hasDecoding = stripos($tag, ' decoding=') !== false;

        // Collect attributes to insert
        $toInsert = [];
        if (!$hasLoading) {
            $toInsert[] = 'loading="lazy"';
        }
        if (!$hasDecoding) {
            $toInsert[] = 'decoding="async"';
        }

        if (!empty($toInsert)) {
            // Insert right after <img
            $insert = ' ' . implode(' ', $toInsert);
            $tag = preg_replace('/^<img\b/i', '<img' . $insert, $tag, 1);
        }

        return $tag;
    }, $source);

    return $source;
}
