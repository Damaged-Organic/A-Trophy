<?php
//src/ATrophy/Service/CRUD/CRUDFaq.php
namespace ATrophy\Service\CRUD;

use ATrophy\Entity\Meat\Question;

class CRUDFaq
{
    public function combineFaq($faq)
    {
        $faq = array_merge([
            'question' => '',
            'answer'   => '',
            'visible'  => TRUE
        ], $faq);

        return $faq;
    }

    public function setFaq(Question $faq = NULL, $data)
    {
        $faq = ( $faq ) ? $faq : new Question;

        $faq->setQuestion($data['question'])
            ->setAnswer($data['answer'])
            ->setVisible($data['visible']);

        return $faq;
    }
}