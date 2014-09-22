<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table(name="groups", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="lectureId", columns={"lectureId"}), @ORM\Index(name="ownerId", columns={"ownerId"})})
 * @ORM\Entity
 */
class Group
{
    /**
     * @var Lecture
     * @ORM\ManyToOne(targetEntity="Lecture")
     * @ORM\JoinColumn(name="lectureId", referencedColumnName="id")
     */
    private $lecture;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="ownerId", type="integer", nullable=false)
     */
    private $ownerid;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="lectureId", type="integer", nullable=false)
     */
    private $lectureid;
    /**
     * @var boolean
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Groups
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set description
     *
     * @param string $description
     * @return Groups
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ownerid
     *
     * @param integer $ownerid
     * @return Groups
     */
    public function setOwnerid($ownerid)
    {
        $this->ownerid = $ownerid;

        return $this;
    }

    /**
     * Get ownerid
     *
     * @return integer 
     */
    public function getOwnerid()
    {
        return $this->ownerid;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Groups
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set lectureid
     *
     * @param integer $lectureid
     * @return Groups
     */
    public function setLectureid($lectureid)
    {
        $this->lectureid = $lectureid;

        return $this;
    }

    /**
     * Get lectureid
     *
     * @return integer 
     */
    public function getLectureid()
    {
        return $this->lectureid;
    }

    /**
     * Set lecture
     *
     * @param \Lecture $lecture
     * @return Group
     */
    public function setLecture(\Lecture $lecture = null)
    {
        $this->lecture = $lecture;

        return $this;
    }

    /**
     * Get lecture
     *
     * @return \Lecture 
     */
    public function getLecture()
    {
        return $this->lecture;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Group
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
