<?php
//src/ATrophy/Service/CRUD/CRUDNews.php
namespace ATrophy\Service\CRUD;

use ATrophy\Entity\Meat\News;

class CRUDNews
{
    public function combineNews(array $news)
    {
        $news = array_merge([
            'created'       => date('d-m-Y'),
            'imageOriginal' => '',
            'imageThumb'    => '',
            'title'         => '',
            'text'          => '',
            'visible'       => TRUE
        ], $news);

        return $news;
    }

    public function setNews(News $news = NULL, $data)
    {
        $news = ( $news ) ? $news : new News;

        $date = ( strtotime($data['created']) ) ?: time();

        $news->setCreated($date)
            ->setImageOriginal($data['imageOriginal'])
            ->setImageThumb($data['imageThumb'])
            ->setTitle($data['title'])
            ->setText($data['text'])
            ->setVisible($data['visible']);

        return $news;
    }

    public function setNewsImages(News $news, $imageName)
    {
        $news->setImageOriginal($imageName['imageOriginal'])
            ->setImageThumb($imageName['imageThumb']);

        return $news;
    }
}