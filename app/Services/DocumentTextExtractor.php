<?php

namespace App\Services;

use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

class DocumentTextExtractor
{
    /**
     * Extract text from a document.
     *
     * @param string $absolutePath
     * @return string
     */
    public function extract(string $absolutePath): string
    {
        if (! file_exists($absolutePath)) {
            return 'Document file not found.';
        }

        $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));

        return match ($extension) {

            'pdf'  => $this->extractPdf($absolutePath),

            'docx' => $this->extractDocx($absolutePath),

            'doc'  => $this->extractDoc($absolutePath),

            default => 'Preview is not available for this file type.',

        };
    }

    /**
     * Extract text from PDF.
     */
    private function extractPdf(string $path): string
    {
        try {

            $parser = new Parser();

            $pdf = $parser->parseFile($path);

            $text = trim($pdf->getText());

            return $text !== ''
                ? $text
                : 'This PDF contains no selectable text. It may be a scanned document and requires OCR.';

        } catch (\Throwable $e) {

            return 'Unable to read PDF: '.$e->getMessage();

        }
    }

    /**
     * Extract text from DOCX.
     */
    private function extractDocx(string $path): string
    {
        try {

            $phpWord = IOFactory::load($path);

            $text = '';

            foreach ($phpWord->getSections() as $section) {

                foreach ($section->getElements() as $element) {

                    if (method_exists($element, 'getText')) {

                        $text .= $element->getText().PHP_EOL;

                    }

                    if (method_exists($element, 'getElements')) {

                        foreach ($element->getElements() as $child) {

                            if (method_exists($child, 'getText')) {

                                $text .= $child->getText().PHP_EOL;

                            }
                        }
                    }
                }
            }

            return trim($text) !== ''
                ? trim($text)
                : 'No readable text found in this Word document.';

        } catch (\Throwable $e) {

            return 'Unable to read Word document: '.$e->getMessage();

        }
    }

    /**
     * Basic extraction for legacy DOC files.
     *
     * Note:
     * Binary .doc files are difficult to parse accurately.
     * This provides a simple fallback.
     */
    private function extractDoc(string $path): string
    {
        try {

            $content = file_get_contents($path);

            $content = preg_replace("/[^(\x20-\x7F)]*/", "", $content);

            $content = preg_replace('/\s+/', ' ', $content);

            return trim($content) !== ''
                ? trim($content)
                : 'Unable to extract readable text from this .doc file.';

        } catch (\Throwable $e) {

            return 'Unable to read DOC file: '.$e->getMessage();

        }
    }
}