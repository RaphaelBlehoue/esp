<?php

namespace Labs\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="Labs\BackBundle\Repository\DocumentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Document
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"application/msword", "application/pdf",}
     * )
     *
     * @Vich\UploadableField(mapping="doc_file", fileNameProperty="docName")
     *
     * @var File $docFile
     */
    protected $docFile;

    /**
     * @var string $docName
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $docName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var date
     *
     * @ORM\Column(name="created", type="date")
     */
    protected $created;

    
    public function __construct()
    {
        $this->date = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Document
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $doc
     *
     * @return Document
     */
    public function setDocFile(File $doc = null)
    {
        $this->docFile = $doc;
        if ($doc) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->created = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return File
     */
    public function getDocFile()
    {
        return $this->docFile;
    }

    /**
     * @param string $docName
     *
     * @return Document
     */
    public function setDocName($docName)
    {
        $this->docName = $docName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocName()
    {
        return $this->docName;
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif au document pour un navigateur
        return 'uploads/docs';
    }


    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif au document pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }


    /**
     * @return string
     */
    public function getAssertPath()
    {
        return $this->getUploadDir().'/'.$this->docName;
    }

    /**
     * @ORM\PostRemove()
     */
    public function deleteDoc()
    {
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
        if (file_exists($this->getAssertPath())) {
            // On supprime le fichier
            unlink($this->getAssertPath());
        }
    }

}
