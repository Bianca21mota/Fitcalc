
<?php

use PHPUnit\Framework\TestCase;

use Controller\ImcController;

class ImcTest extends TestCase {

    //IRÁ FAZER A REFERENCIA A CLASSE CONTROLLER
    //RESPONSÁVEL POR REALIZAR A COMUNICAÇÃO COM O BD
    // E A LÓGICA DA APLICAÇÃO
    private $imcController;
    protected function setUp(): void {
        $this->imcController = new ImcController();
    }
    

    // Verificar o cálculo do IMC
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_calculate_bmi() {
        $weight = 68;
        $height = 1.68;

        //acessa o atributo privado e o metodo 
        $imcResult = $this->imcController-> calculateImc($weight, $height);

       //Pega um array e verifica se dentro dele contem uma chave especifica
        $this->assertArrayHasKey('imc', $imcResult);
        $this->assertArrayHasKey('BMIrange', $imcResult);

        $this->assertEquals(24.09, $imcResult['imc']);
        $this-> assertEquals('Peso normal', $imcResult['BMIrange']);

    }



    // Verificar a validação/retorno de campos inválidos (menores que 0)
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_calculate_bmi_with_invalid_inputs () {

        $imcResult = $this->imcController->calculateImc(-68, 1.68);
         $this-> assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
         
         
        $imcResult = $this->imcController->calculateImc(68, -1.68);
         $this-> assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);

         
        $imcResult = $this->imcController->calculateImc(-68, -1.68);
         $this-> assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);


    }


    //c. 0 ou nulos
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_calculate_bmi_with_null_or_empty_inputs () {

         $imcResult = $this->imcController->calculateImc(0, null);
         $this-> assertEquals(' Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

          $imcResult = $this->imcController->calculateImc(null, 0);
         $this-> assertEquals(' Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

          $imcResult = $this->imcController->calculateImc(null,null);
         $this-> assertEquals(' Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

    
    } 
    

    //obter o imc e calcular
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_bmi_range(){
    $weight =68;
    $height= 1.68;
     $imcResult=$this -> imcController->calculateImc($weight, $height);
     $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
     $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

      $this-> assertEquals('Peso normal', $imcResult['BMIrange']);
    }

    //Salvar o imc
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_salve_bmi(){}
}

?>