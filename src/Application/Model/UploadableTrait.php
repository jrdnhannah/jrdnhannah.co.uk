<?php

namespace Application\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

trait UploadableTrait
{
    /**
     * @var UploadedFile
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @return string
     */
    abstract protected function getUploadableProperty();

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web' . $this->getUploadDir();
    }

    /**
     * @return string
     */
    abstract protected function getUploadDir();

    public function getAbsolutePath()
    {
        return null === $this->{$this->getUploadableProperty()} ?
            null : $this->getUploadRootDir() . '/' . $this->{$this->getUploadableProperty()};
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->{$this->getUploadableProperty()} ?
            null : $this->getUploadDir() . '/' . $this->{$this->getUploadableProperty()};
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @throws \RuntimeException
     * @return void
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        $this->{$this->getUploadableProperty()} = $this->getFile()->getClientOriginalName();
        $this->file = null;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        $this->upload();
    }
}