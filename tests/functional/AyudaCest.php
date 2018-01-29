<?php


class AyudaCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/ayuda');
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function ayudaTest(FunctionalTester $I)
    {
        $I->expectTo('Ver la página de AYUDA de mi aplicación');
        $I->see('Ayuda', 'h1');
        $I->see('Sobre Nosotros');
        $I->see('Sobre Mercurio');
        $I->see('Sobre Cómo usar');
    }
}
