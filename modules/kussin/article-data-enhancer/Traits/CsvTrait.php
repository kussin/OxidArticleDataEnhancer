<?php

namespace Kussin\ArticleDataEnhancer\Traits;

trait CsvTrait
{
    private function _getCsvData($sCsvFile, $iLength = 0, $sSeparator = ';', $sEnclosure = '"', $sEscape = '\\') : array
    {
        $aCsvData = [];

        // CONVERT ENCODING TO UTF-8
        // Detect the encoding of the file
        $sContents = file_get_contents($sCsvFile);
        $sDetectedEncoding = mb_detect_encoding($sContents, "UTF-8, ISO-8859-1, ASCII", true);

        $this->_info('CSV encoding: ' . $sDetectedEncoding);

        // Convert encoding to UTF-8 if necessary
        if ($sDetectedEncoding != "UTF-8") {
            $sContents = mb_convert_encoding($sContents, "UTF-8", $sDetectedEncoding);
            file_put_contents($sCsvFile, $sContents);

            $this->_info('CSV encoding converted to UTF-8.');
        }

        $oFile = fopen($sCsvFile, 'r');

        if ($oFile) {
            // Get the first row and use it as headers (array keys)
            $aHeaders = fgetcsv($oFile, $iLength, $sSeparator, $sEnclosure);

            // Loop through each subsequent row of the file
            while (($aLine = fgetcsv($oFile, $iLength, $sSeparator, $sEnclosure)) !== FALSE) {
                // Initialize an associative array for the current row
                $aAssociativeLine = [];

                // Loop through each column in the row
                foreach ($aHeaders as $iKey => $sKey) {
                    // Assign each value to the corresponding header in the associative array
                    $aAssociativeLine[$sKey] = $aLine[$iKey];
                }

                // Add the associative array for the current row to the main array
                $aCsvData[] = $aAssociativeLine;
            }

            // Close the file
            fclose($oFile);
        }

        return $aCsvData;
    }
}