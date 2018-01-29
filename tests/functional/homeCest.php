<?php


class homeCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function openHome(FunctionalTester $I)
    {
        $I->expectTo('Ver la página de inicio de mi aplicación');
        $I->see('Mercurio', 'h1');
    }
}
