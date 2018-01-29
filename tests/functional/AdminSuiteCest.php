<?php


class AdminSuiteCest
{
    protected $admin;

    public function _before(FunctionalTester $I)
    {
        $this->admin = \app\models\Usuarios::findByUsername('admin');
        $I->amLoggedInAs($this->admin);
        $I->amOnRoute('site/admin');
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function paginaAdmin(FunctionalTester $I)
    {
        $I->expectTo('Entrar en la zona administrativa');
        $I->see('Zona Administrativa', 'h1');
        $I->see('Usuarios' ,'h2');
        $I->see('Grupos', 'h2');
        $I->see('Mensajes', 'h2');
    }

    public function verDetallesUsuario(FunctionalTester $I){
        $I->amOnRoute('usuarios/view', ['id'=>$this->admin->id_usuario]);
        $I->see('Usuario','h2');
        $I->see('Sus grupos', 'h2');
        $I->see('Sus mensajes', 'h2');
    }

    public function crearGrupo(FunctionalTester $I){
        $I->expectTo('Entrar en la página de crear nuevo grupo');
        $I->click('nuevo grupo');
        $I->see('Crear Grupo', 'h1');
    }
    
    public function crearUsuario(FunctionalTester $I){
        $I->expectTo('Entrar en la página de crear nuevo usuario');
        $I->click('nuevo usuario');
        $I->see('Nuevo usuario', 'h1');
    }

    public function actualizarUsuario(FunctionalTester $I){
        $I->expectTo('Entrar en la página de actualizar el usuario');
        $I->amOnRoute('usuarios/view', ['id'=>$this->admin->id_usuario]);
        $I->see('Actualizar', 'a');
        $I->click('Actualizar');
        $I->see('Actualización de Usuario');
        $I->seeElement('input', ['value'=>'Rubén']);
    }

    public function crearMensaje(FunctionalTester $I){
        $I->expectTo('Entrar en la página de crear un mensaje');
        $I->click('nuevo mensaje');
        $I->see('Nuevo mensaje' ,'h1');
    }

}
