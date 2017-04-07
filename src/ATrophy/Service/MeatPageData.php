<?php
// ATrophy/Service/MeatPageData.php
namespace ATrophy\Service;

use Doctrine\ORM\EntityManager;

class MeatPageData
{
    const BUNDLE = 'ATrophy\Entity\Meat';

    private $_manager;

    public function __construct(EntityManager $_manager)
    {
        $this->_manager = $_manager;
    }

    public function loadIntroItems()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\IntroItem')
            ->findAll();
    }

    public function loadClients()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Client')
            ->findAll();
    }

    public function loadQuestion($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Question')
            ->find($id);
    }

    public function loadQuestions()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Question')
            ->findRecent();
    }

    public function loadDeliverers()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Deliverer')
            ->findAll();
    }

    public function loadPayments()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Payment')
            ->findAll();
    }

    public function loadNews($page, $results_per_page)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\News')
            ->findLimitedRecent($page, $results_per_page);
    }

    public function loadNewsArticle($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\News')
            ->find($id);
    }

    public function loadPromotion($id)
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Promotion')
            ->find($id);
    }

    public function loadPromotions()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Promotion')
            ->findOrderedPromotions();
    }

    public function getMonthsNames()
    {
        $month_names = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

        array_unshift($month_names, 'dummy');

        unset($month_names[0]);

        return $month_names;
    }

    public function getOrderedRegions()
    {
        return $this->_manager
            ->getRepository(self::BUNDLE . '\Region')
            ->findAllOrdered();
    }
}