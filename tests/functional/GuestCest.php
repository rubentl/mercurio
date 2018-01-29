<?php


class GuestCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function InvitadoTest(FunctionalTester $I)
    {
        $I->expectTo('Entrar en Ayuda y en Contacto como invitado');
        $I->amOnRoute('/');
        $I->see('Mercurio', 'h1');
        $I->click('Ayuda');
        $I->see('Ayuda', 'h1');
        $I->click('Contacto');
        $I->see('Contacto');
        $I->click('Acceso');
        $I->see('Acceso');
        
    }

    public function AccesoInvitado(FunctionalTester $I){
        $I->expectTo('No poder acceder a las páginas Escritorio y Administración.');
        $I->amOnRoute('site/admin');
        $I->dontSee('Zona administración','h1');
        $I->amOnRoute('usuarios/view', ['id'=>2]);
        $I->dontSee('Usuario','h2');
        $I->amOnRoute('usuarios/escritorio', ['id'=>2]);
        $I->dontSee('Escritorio','h1');
        $I->amOnRoute('usuarios/update', ['id'=>2]);
        $I->dontSee('Actualización','h1');
        $I->amOnRoute('usuarios/nuevo');
        $I->dontSee('Nuevo Usuario','h1');
    }
}
