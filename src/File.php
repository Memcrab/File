<?php declare (strict_types=1);

namespace Memcrab\File;


use Memcrab\File\FileException;

class File
{
    protected $content;

    public function load(string $filePath): File
    {
        $this->checkFilePath($filePath);

        $this->content = file_get_contents($filePath);
        return $this;
    }

    protected function checkFilePath(string $filePath): File
    {
        if (!is_readable($filePath)) {
            throw new FileException(_("Can't find or read file:") . " " . $filePath, 501);
        }
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
}
