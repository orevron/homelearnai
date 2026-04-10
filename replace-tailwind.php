<?php

function replaceClasses($content) {
    // Margins
    $content = preg_replace('/\bml-([0-9a-z\.-]+)/', 'ms-$1', $content);
    $content = preg_replace('/\bmr-([0-9a-z\.-]+)/', 'me-$1', $content);
    $content = preg_replace('/-ml-([0-9a-z\.-]+)/', '-ms-$1', $content);
    $content = preg_replace('/-mr-([0-9a-z\.-]+)/', '-me-$1', $content);
    // Paddings
    $content = preg_replace('/\bpl-([0-9a-z\.-]+)/', 'ps-$1', $content);
    $content = preg_replace('/\bpr-([0-9a-z\.-]+)/', 'pe-$1', $content);
    // Text alignment
    $content = preg_replace('/\btext-left\b/', 'text-start', $content);
    $content = preg_replace('/\btext-right\b/', 'text-end', $content);
    // Borders
    $content = preg_replace('/\bborder-l-([0-9a-z\.-]+)/', 'border-s-$1', $content);
    $content = preg_replace('/\bborder-r-([0-9a-z\.-]+)/', 'border-e-$1', $content);
    $content = preg_replace('/\bborder-l\b/', 'border-s', $content);
    $content = preg_replace('/\bborder-r\b/', 'border-e', $content);
    // BorderRadius
    $content = preg_replace('/\brounded-l-([0-9a-z\.-]+)/', 'rounded-s-$1', $content);
    $content = preg_replace('/\brounded-r-([0-9a-z\.-]+)/', 'rounded-e-$1', $content);
    $content = preg_replace('/\brounded-l\b/', 'rounded-s', $content);
    $content = preg_replace('/\brounded-r\b/', 'rounded-e', $content);
    // Positioning
    $content = preg_replace('/\bleft-([0-9a-z\.-]+)/', 'start-$1', $content);
    $content = preg_replace('/\bright-([0-9a-z\.-]+)/', 'end-$1', $content);
    $content = preg_replace('/-left-([0-9a-z\.-]+)/', '-start-$1', $content);
    $content = preg_replace('/-right-([0-9a-z\.-]+)/', '-end-$1', $content);
    $content = preg_replace('/\bleft-0\b/', 'start-0', $content);
    $content = preg_replace('/\bright-0\b/', 'end-0', $content);

    return $content;
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__),
    RecursiveIteratorIterator::SELF_FIRST
);

$directories = ['resources/views', 'resources/js'];

foreach ($iterator as $file) {
    if (!$file->isFile()) continue;

    $path = $file->getPathname();
    $inDir = false;
    foreach ($directories as $dir) {
        if (strpos($path, realpath(__DIR__ . '/' . $dir)) === 0) {
            $inDir = true;
            break;
        }
    }

    if ($inDir && (str_ends_with($path, '.blade.php') || str_ends_with($path, '.js') || str_ends_with($path, '.vue'))) {
        $content = file_get_contents($path);
        $newContent = replaceClasses($content);
        if ($content !== $newContent) {
            file_put_contents($path, $newContent);
            echo "Updated " . str_replace(__DIR__ . '/', '', $path) . "\n";
        }
    }
}
