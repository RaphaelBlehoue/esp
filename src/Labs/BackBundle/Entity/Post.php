<?php

namespace Labs\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Labs\BackBundle\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Post
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
     *
     * @Vich\UploadableField(mapping="blog_image", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg"},
     *     mimeTypesMessage = "le type de fichier ({{ type }}) est invalide"
     * )
     * @var File $imageFile
     */
    protected $imageFile;

    /**
     * @var string $imageName
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $imageName;

    /**
     * @var
     * @ORM\Column(name="docs_name", type="string", length=225)
     */
    protected $docsName;

    /**
     *
     * @Vich\UploadableField(mapping="blog_doc", fileNameProperty="documentName")
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage="Uplodez un fichier PDF valide"
     * )
     * @var File $documentFile
     */
    protected $documentFile;

    /**
     * @var string $documentName
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $documentName;



    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotNull(message="Veuiilez renseignez le titre")
     * @Assert\NotBlank(message="Ce champs ne peut être vide")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="video_link", type="string", length=255, nullable=true)
     */
    protected $videoLink;


    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", length=255)
     */
    protected $status;


    /**
     * @var text
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;


    /**
     * @var dateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;


    /**
     * @Gedmo\Slug(fields={"title", "id"}, updatable=true, separator="_")
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;


    public function __construct()
    {
        $this->created = new \DateTime('now');
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
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param text $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return text
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Post
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


    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'uploads/posts';
    }

    public function getUploadDocDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'uploads/docs';
    }


    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadRootDocDir()
    {
        // On retourne le chemin relatif du docment pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDocDir();
    }


    /**
     * @return string
     */
    public function getAssertPath()
    {
        return $this->getUploadDir().'/'.$this->imageName;
    }

    /**
     * @return string
     */
    public function getAssertPathDoc()
    {
        return $this->getUploadDocDir().'/'.$this->documentName;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Post
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->created = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Post
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $doc
     *
     * @return Post
     */
    public function setDocumentFile(File $doc = null)
    {
        $this->documentFile = $doc;
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
    public function getDocumentFile()
    {
        return $this->documentFile;
    }


    /**
     * Set documentName
     *
     * @param string $documentName
     *
     * @return Post
     */
    public function setDocumentName($documentName)
    {
        $this->documentName = $documentName;

        return $this;
    }

    /**
     * Get documentName
     *
     * @return string
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }

    /**
     * Set videoLink
     *
     * @param string $videoLink
     *
     * @return Post
     */
    public function setVideoLink($videoLink)
    {
        $this->videoLink = $videoLink;

        return $this;
    }

    /**
     * Get videoLink
     *
     * @return string
     */
    public function getVideoLink()
    {
        return $this->videoLink;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Post
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set docsName
     *
     * @param string $docsName
     *
     * @return Post
     */
    public function setDocsName($docsName)
    {
        $this->docsName = $docsName;

        return $this;
    }

    /**
     * Get docsName
     *
     * @return string
     */
    public function getDocsName()
    {
        return $this->docsName;
    }
}
