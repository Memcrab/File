<?php declare (strict_types=1);

namespace Memcrab\File;


use Memcrab\File\FileException;

class Yaml extends File
{
    const PARSE_MULTIPLE_DOCS = [
        'ONE' => 0,
        'ALL' => -1 
    ];

    public function load(string $filePath): File
    {
        $this->parseYamlFile($filePath);
        return $this;
    }

    public function loadMultipleDocs(string $filePath, bool $flattenParcingResult = true, bool $flattenRecursevly = true): File
    {
        $this->parseYamlFile($filePath, true, $flattenParcingResult, $flattenRecursevly);
        return $this;
    }

    private function parseYamlFile(string $filePath, bool $parseMultipleDocs = false, bool $flattenMultipleDocsParsingResult = false, bool $flattenRecursevly = false)
    {
        $this->checkFilePath($filePath);

        $this->content = \yaml_parse_file($filePath, ($parseMultipleDocs === true) ? self::PARSE_MULTIPLE_DOCS['ALL'] : self::PARSE_MULTIPLE_DOCS['ONE']);        

        if ($this->content === false) {
            throw new FileException(_("Can't parse yaml content from file:") . " " . $filePath, 501);
        }
        
        if ($flattenMultipleDocsParsingResult === true && is_array($this->content)) {
            $nonEmptyArrays = array_filter($this->content, function($element) {
                return is_array($element) && !empty($element);
            });

            $this->content = ($flattenRecursevly === true) 
                                ? array_merge_recursive([], ...$nonEmptyArrays)
                                : array_merge([], ...$nonEmptyArrays);
        }
    }
}