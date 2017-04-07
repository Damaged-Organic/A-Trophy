<?php
// ATrophy/Service/CommonPageData.php
namespace ATrophy\Service;

use Doctrine\ORM\EntityManager;

class CommonPageData
{
    const BUNDLE = 'ATrophy\Entity';

    private $_manager;
    private $_dataTransform;

    private $path = [
        'url'   => NULL,
        'route' => NULL
    ];

    private $pageData = [
        'metadata' => NULL,
        'menu'     => NULL,
        'contacts' => NULL,
        'image'    => NULL
    ];

    public function __construct(EntityManager $_manager, DataTransform $_dataTransform)
    {
        $this->_manager       = $_manager;
        $this->_dataTransform = $_dataTransform;
    }

    //Path (URL and route)

    public function setUrl($url)
    {
        $this->path['url'] = $url;
    }

    public function getUrl()
    {
        return $this->path['url'];
    }

    public function setRoute($route)
    {
        $this->path['route'] = $route;
    }

    public function getRoute()
    {
        return $this->path['route'];
    }

    //Metadata

    public function loadMetadata($route)
    {
        $this->pageData['metadata'] = $this->_manager
            ->getRepository(self::BUNDLE . '\Common\Metadata')
            ->findByRoute($route);
    }

    public function replaceMetadata(array $properties)
    {
        if( !empty($properties['title']) ) {
            $this->pageData['metadata']->setTitle("{$properties['title']} - " . $this->pageData['metadata']->getTitle());
        }

        if( !empty($properties['description']) )
        {
            $description = ( mb_strlen($properties['description'], 'utf-8') >= 500 )
                ? mb_substr($properties['description'], 0, 500, 'utf-8') . "..."
                : $properties['description'];

            $this->pageData['metadata']->setDescription($description);
        }
    }

    public function getMetadata()
    {
        return $this->pageData['metadata'];
    }

    //Menu items

    public function loadDirectories($route)
    {
        $items = $this->_manager
            ->getRepository(self::BUNDLE . '\Common\Directory')
            ->findAll();

        $topCategories = $this->_manager
            ->getRepository(self::BUNDLE . '\Shop\Category')
            ->findbyLevel(0);

        $this->pageData['menu'] = [
            'items'         => $items,
            'topCategories' => $topCategories,
            'current_item'  => $route
        ];
    }

    public function getDirectories()
    {
        return $this->pageData['menu'];
    }

    //Contacts

    public function loadContacts()
    {
        $this->pageData['contacts'] = $this->_manager
            ->getRepository(self::BUNDLE . '\Common\Contact')
            ->findAll();

        $this->pageData['contacts'] = $this->_dataTransform->transform(
            $this->pageData['contacts'],
            function($input_array)
            {
                $output_array = [];

                foreach($input_array as $contact) {
                    $output_array[$contact->getType()][] = $contact;
                }

                return $output_array;
            }
        );
    }

    public function getContacts()
    {
        return $this->pageData['contacts'];
    }

    public function setImage($image)
    {
        $this->pageData['image'] = $image;
    }

    public function getImage()
    {
        return $this->pageData['image'];
    }
	
	public function getNavigationItem($route)
	{
		return $this->_manager
            ->getRepository(self::BUNDLE . '\Common\Directory')
            ->findByRoute($route)
            ->getTitle();
	}
}