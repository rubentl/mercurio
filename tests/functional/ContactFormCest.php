<?php

class ContactFormCest 
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['site/contact']);
    }

    public function openContactPage(\FunctionalTester $I)
    {
        $I->see('Contacto', 'h1');        
    }

    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', []);
        $I->expectTo('Ver errores de validación');
        $I->see('Contacto', 'h1');
        $I->see('Nombre no puede estar vacío');
        $I->see('Correo electrónico no puede estar vacío');
        $I->see('Asunto no puede estar vacío');
        $I->see('Mensaje no puede estar vacío');
        $I->see('El código de verificación es incorrecto');
    }

    public function submitFormWithIncorrectEmail(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->expectTo('ver que el correo está equivocado');
        $I->dontSee('Nombre no puede estar vacío', '.help-inline');
        $I->see('Correo electrónico no es válido');
        $I->dontSee('Asunto no puede estar vacío', '.help-inline');
        $I->dontSee('Mensaje no puede estar vacío', '.help-inline');
        $I->dontSee('El código de verificación es incorrecto', '.help-inline');        
    }

    public function submitFormSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->seeEmailIsSent();
        $I->dontSeeElement('#contact-form');
        $I->see('Gracias por contactar con nosotros. En breve nos pondremos en contacto contigo.');        
    }
}
