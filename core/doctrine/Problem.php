<?php
use Doctrine\ORM\Mapping as ORM;

/**
 * Problem
 * @ORM\Table(name="problems", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="pluginId", columns={"pluginId"}), @ORM\Index(name="lectureId", columns={"lectureId"})})
 * @ORM\Entity
 */
class Problem
{
    /**
     * @var Lecture
     * @ORM\ManyToOne(targetEntity="Lecture")
     * @ORM\JoinColumn(name="lectureId", referencedColumnName="id")
     */
    private $lecture;
    /**
     * @var Plugin
     * @ORM\ManyToOne(targetEntity="Plugin")
     * @ORM\JoinColumn(name="pluginId", referencedColumnName="id")
     */
    private $plugin;
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
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
     * @ORM\Column(name="pluginId", type="integer", nullable=false)
     */
    private $pluginid;

    /**
     * @var string
     *
     * @ORM\Column(name="config", type="text", nullable=false)
     */
    private $config;

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
     * @return Problems
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
     * @return Problems
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
     * Set pluginid
     *
     * @param integer $pluginid
     * @return Problems
     */
    public function setPluginid($pluginid)
    {
        $this->pluginid = $pluginid;

        return $this;
    }

    /**
     * Get pluginid
     *
     * @return integer 
     */
    public function getPluginid()
    {
        return $this->pluginid;
    }

    /**
     * Set config
     *
     * @param string $config
     * @return Problems
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config
     *
     * @return string 
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set lectureid
     *
     * @param integer $lectureid
     * @return Problems
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
     * Set plugin
     *
     * @param \Plugin $plugin
     * @return Problem
     */
    public function setPlugin(\Plugin $plugin = null)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Get plugin
     *
     * @return \Plugin 
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     * Set lecture
     *
     * @param \Lecture $lecture
     * @return Problem
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
     * @return Problem
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