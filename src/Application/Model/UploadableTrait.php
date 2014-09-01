<?php

namespace Application\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

trait UploadableTrait
{
    /**
     * Property which contains the uploaded file
     *
     * @var UploadedFile
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Property in which uploaded files name sits
     *
     * @return string
     */
    abstract protected function getUploadableProperty();

    /**
     * Upload directory
     *
     * @return string
     */
    abstract protected function getUploadDir();

    /**
     * Full upload directory
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web' . $this->getUploadDir();
    }

    /**
     * @return null|string
     */
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

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     * @return void
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        $this->upload();
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

    /**
     * @ORM\PreRemove
     */
    public function delete()
    {
        unlink($this->getAbsolutePath());
    }

}