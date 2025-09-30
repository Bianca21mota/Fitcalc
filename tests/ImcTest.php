
<?php

use PHPUnit\Framework\TestCase;
use Model\Imcs;

use Controller\ImcController;

class ImcTest extends TestCase {

    //IRÁ FAZER A REFERENCIA A CLASSE CONTROLLER
    //RESPONSÁVEL POR REALIZAR A COMUNICAÇÃO COM O BD
    // E A LÓGICA DA APLICAÇÃO
    private $imcController;

    // ATRIBUTO DO BD FAKE
    private $mockImcModel;

    protected function setUp(): void {
        //ACESSANDO O  ATRIBUTO (mockImcModel) QUE VAI RECEBER A FUNÇÃO CREATEMOCK
        //Em vez de criar uma conexão com o bd real, ele cria o bd fake
        $this->mockImcModel =$this-> createMock(Imcs::class);

        //PASSO ESSE FAKE PARA O CONTROLLER , ASSIM ME PERMITE UTILIZAR 
        // AS MESMAS FUNCIONALIDADES , SÓ QUE SEM MODIFICAR O BANCO DE DADOS REAL
        $this->imcController = new ImcController($this->mockImcModel);
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

        $imcResult = $this->imcController->calculateImc(0,0);
         $this-> assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
    }


    //c. 0 ou nulos
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_calculate_bmi_with_null_or_empty_inputs () {

         $imcResult = $this->imcController->calculateImc(0, null);
         $this-> assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

          $imcResult = $this->imcController->calculateImc(null, 0);
         $this-> assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

          $imcResult = $this->imcController->calculateImc(null,null);
         $this-> assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

    
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


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_bmi_range_low_weight(){
    $weight =50;
    $height= 1.75;
    $imcResult =$this -> imcController->calculateImc($weight, $height);
     $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
     $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);
     $this-> assertEquals('Baixo peso', $imcResult['BMIrange']);

    }


        #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_bmi_range_overweight(){
    $weight =85;
    $height= 1.70;
    $imcResult =$this -> imcController->calculateImc($weight, $height);
     $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
     $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);
     $this-> assertEquals('Sobrepeso', $imcResult['BMIrange']);

     
    }

  #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_bmi_range_obesity_grade_one(){
    $weight =95;
    $height= 1.70;
    $imcResult =$this -> imcController->calculateImc($weight, $height);
     $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
     $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);
     $this-> assertEquals('Obesidade grau I', $imcResult['BMIrange']);
     
     // IMC = 32.9
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_bmi_range_obesity_grade_two(){
    $weight =110;
    $height= 1.75;
    $imcResult =$this -> imcController->calculateImc($weight, $height);
     $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
     $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);
     $this-> assertEquals('Obesidade grau II', $imcResult['BMIrange']);


      // IMC = 35.9
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_bmi_range_obesity_grade_three(){
    $weight =130;
    $height= 1.70;
    $imcResult =$this -> imcController->calculateImc($weight, $height);
     $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
     $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);
     $this-> assertEquals('Obesidade grau III', $imcResult['BMIrange']);

     

    }



    //Salvar o imc
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_salve_bmi(){
        //
        $imcResult = $this -> imcController->calculateImc(68,1.68); 

         $this->assertStringNotContainsString("Por favor, informe peso e altura para obter o seu IMC.", $imcResult['BMIrange']);

         //quando eu usar pela 1 vez a função de criar, o phpunit deve verificar se os parametros tem os argumentos que eu quero e se a condição é verdadeira.
         // verifica se o que esta sendo acessado no bd corresponde ao esperado
         // espera que o metodo seja executado 1 vez e que os parametros correspondam com que foi passado e com o esperado
         //Por fim, verifica se da pra salvar, e se essa condição é verdadeira
         $this->mockImcModel ->expects($this->once())->method('createImc')->with($this->equalTo(68), $this->equalTo(1.68)) ->willReturn(true);

        $result = $this->imcController->saveIMC(68,1.68, $imcResult['imc']);

         $this->assertTrue($result);

    }

}

?>