<?php

/**
 * Function for convenient iteration of an array with files
 * @param $filePost
 * @return array
 */
function reArrayFiles(&$filePost): array
{
    $fileAry = [];

    if (!empty($filePost['name'])) {
        $fileCount = count($filePost['name']);
        $fileKeys = array_keys($filePost);

        for ($i = 0; $i < $fileCount; $i++) {
            foreach ($fileKeys as $key) {
                $fileAry[$i][$key] = $filePost[$key][$i];
            }
        }
    }

    return $fileAry;
}

/**
 * File size conversion
 * @param int $fileSize
 * @return string
 */
function convertFileSize(int $fileSize): string
{
    if ($fileSize < (1024 * 10)) {
        return $fileSize . 'b';
    } elseif ($fileSize >= (1024 * 10) && $fileSize < (1024 * 1024)) {
        return round($fileSize / 1024) . 'Kb';
    } else {
        return round($fileSize / (1024 * 1024), 2) . 'Mb';
    }
}
