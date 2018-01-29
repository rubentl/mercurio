<?php


class UserCest
{
    protected $user;

    public function _before(FunctionalTester $I)
    {
        $this->user = \app\models\Usuarios::findByUsername('pepe');
        $I->amLoggedInAs($this->user);
        $I->amOnRoute('usuarios/escritorio', ['id'=>$this->user->getId()]);
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function paginaEscritorio(FunctionalTester $I)
    {
        $I->expectTo('Entrar en la página que hace de escritorio para el usuario');
        $I->see('Escritorio Mercurio','h1');                
        $I->see($this->user->nombre . ' como ' . $this->user->login,'h3');
        $I->see('Todos','a');
        $I->see('Personas','h3');
        $I->see('Grupos','h3');
        $I->see('Mensajes','h3');
        $I->seeLink('Escritorio');
    }
}
