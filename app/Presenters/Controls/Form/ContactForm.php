<?php declare(strict_types=1);


namespace App\Presenters\Controls\Form;


use Nette\Application\UI\Control;
use Nette\Forms\Form;
use Nette\Mail\IMailer;
use Nette\Mail\Message;

final class ContactForm extends Control
{

    /** @var IMailer */
    public $mailer;

    /** @var callable[] */
    public $onSuccess;

    public function __construct(IMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function createComponentContactForm ()
    {
        parent::__construct();
        $form = new Form();

        $form->addEmail('email')
            ->setRequired('Please fill your email');
        $form->addText('name')
            ->setRequired('Please fill your name')
            ->addRule(Form::MIN_LENGTH, 'We are sorry, but name shorter than %d characters look suspicious.', 5);
        $form->addTextArea('text')
            ->setRequired('Please fill the message you want to send')
            ->addRule(Form::MIN_LENGTH,'Message has to be at least %d characters long', 30);
        $form->addSubmit('submit');

        $form->onError[] = function (): void {
            $this->flashMessage('Something went wrong while sending your message, please try again', 'danger');
            $this->redirect('this');
        };

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm(Form $form, \stdClass $values): void
    {
        $mail = new Message();
        $mail->setFrom($values->email);
        $mail->addTo('owner@skynette.com');
        $mail->setSubject(sprintf('[Skynette] A new message from %s',$values->name));
        $mail->setHtmlBody(sprintf('Hello boss,<br>a new message from %s (%s) about Skynette.<br><br>Message:<br>%s<br><br>To reply just reply to this email.', $values->name, $values->email, $values->text));

        $this->mailer->send($mail);

        $this->onSuccess();

        $submitted = 1;
        $this->redirect('this', $submitted);
    }

}