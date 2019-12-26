<?php declare(strict_types=1);


namespace App\Presenters\Controls\Form;


interface IContactFormFactory
{

    public function create(): ContactForm;

}