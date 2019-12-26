<?php declare(strict_types=1);


namespace App\Presenters;


use App\Presenters\Controls\Form\ContactForm;
use App\Presenters\Controls\Form\IContactFormFactory;
use Nette\Forms\Form;
use Nette\Application\UI\Presenter;

final class ContactPresenter extends Presenter
{

    /** @var IContactFormFactory */
    public $contactFormFactory;

    public function __construct(IContactFormFactory $contactFormFactory)
    {
        parent::__construct();
        $this->contactFormFactory = $contactFormFactory;
    }

    public function createComponentContactForm(): ContactForm
    {
        return $this->contactFormFactory->create();
    }

    public function actionEn(): void
    {
        $this->contactFormSubmitted();
    }

    public function actionCz(): void
    {
        $this->contactFormSubmitted();
    }

    private function contactFormSubmitted(): void
    {
        $submitted = (int) $this->getRequest()->getParameter('submitted');

        if ($submitted == 1)
        {
            $this->template->submitted = true;
            return;
        }

        $this->template->submitted = false;
    }

}