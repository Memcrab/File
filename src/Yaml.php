<?php declare (strict_types=1);

namespace Memcrab\File;


use Memcrab\File\FileException;

class Yaml extends File
{
    public function load(string $filePath): File
    {
        $this->parseYamlFile($filePath);
        return $this;
    }

    private function parseYamlFile(string $filePath)
    {
        $this->checkFilePath($filePath);

        $this->content = \yaml_parse_file($filePath);
        if ($this->content === false) {
            throw new FileException(_("Can't parse yaml content from file:") . " " . $filePath, 501);
        }
    }
}