<?php
/* Functions that are used with PHPWord
 */

/**
 * Write documents
 *
 * @param \PhpOffice\PhpWord\PhpWord $phpWord
 * @param string $filename
 * @param array $writers
 *
 * @return string
 */
function phpoffice_write_word($phpWord, $filename, $writers) {
	$result = '';
	$path = phpoffice_filepath();

	// Write documents
	foreach ($writers as $format => $extension) {
		$result .= date('H:i:s') . " Write to {$format} format";
		if (null !== $extension) {
			//$targetFile = $path . "results/{$filename}.{$extension}";
			$targetFile = $path . "{$filename}.{$extension}";
			$phpWord->save($targetFile, $format);
		} else {
			$result .= ' ... NOT DONE!';
		}
		$result .= PHPOFFICE_EOL;
	}

	$result .= phpoffice_getEndingNotes($writers);

	return $result;
}


