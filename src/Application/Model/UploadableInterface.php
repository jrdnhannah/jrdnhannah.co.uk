<?php

namespace Application\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadableInterface
{
    /**
     * @return string
     */
    public function getAbsolutePath();

    /**
     * @return string
     */
    public function getWebPath();

    /**
     * @return void
     */
    public function upload();

    /**
     * @param UploadedFile $file
     * @return $this
     */
    public function setFile(UploadedFile $file);

    /**
     * @return UploadedFile
     */
    public function getFile();
}