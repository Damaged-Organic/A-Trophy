<?php
// ATrophy/Entity/Shop/Category.php
namespace ATrophy\Entity\Shop;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="ATrophy\Entity\Repository\Shop\CategoryRepository")
 * @ORM\Table(name="shop_categories")
 *
 * @Gedmo\TranslationEntity(class="ATrophy\Entity\Translation\Shop\CategoryTranslation")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    protected $id;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $level;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $parameter;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * //@Gedmo\Translatable
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    protected $productCategory;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="subcategory")
     */
    protected $productSubcategory;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * Set translatable locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productCategory = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productSubcategory = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set level
     *
     * @param integer $level
     * @return Category
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set parameter
     *
     * @param string $parameter
     * @return Category
     */
    public function setParameter($parameter)
    {
        $this->parameter = $parameter;

        return $this;
    }

    /**
     * Get parameter
     *
     * @return string
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Category
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
     * Add productCategory
     *
     * @param \ATrophy\Entity\Shop\Product $productCategory
     * @return Category
     */
    public function addProductCategory(\ATrophy\Entity\Shop\Product $productCategory)
    {
        $this->productCategory[] = $productCategory;

        return $this;
    }

    /**
     * Remove productCategory
     *
     * @param \ATrophy\Entity\Shop\Product $productCategory
     */
    public function removeProductCategory(\ATrophy\Entity\Shop\Product $productCategory)
    {
        $this->productCategory->removeElement($productCategory);
    }

    /**
     * Get productCategory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductCategory()
    {
        return $this->productCategory;
    }

    /**
     * Add productSubcategory
     *
     * @param \ATrophy\Entity\Shop\Product $productSubcategory
     * @return Category
     */
    public function addProductSubcategory(\ATrophy\Entity\Shop\Product $productSubcategory)
    {
        $this->productSubcategory[] = $productSubcategory;

        return $this;
    }

    /**
     * Remove productSubcategory
     *
     * @param \ATrophy\Entity\Shop\Product $productSubcategory
     */
    public function removeProductSubcategory(\ATrophy\Entity\Shop\Product $productSubcategory)
    {
        $this->productSubcategory->removeElement($productSubcategory);
    }

    /**
     * Get productSubcategory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductSubcategory()
    {
        return $this->productSubcategory;
    }
}
