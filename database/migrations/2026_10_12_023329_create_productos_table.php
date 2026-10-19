<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //Esto estaba por default, no lo voy a tocar por las dudas.
   public function up(): void { 
        Schema::create('productos', function (Blueprint $table) { 
            $table->id(); 
            $table->string('nombre'); 
            $table->text('descripcion')->nullable(); 
            $table->decimal('precio', 10, 2); 
            $table->integer('stock')->default(0); 
            $table->timestamps();         
        });

        Schema::create('receta', function(Blueprint $table) {
            $table->id('cod_receta');                                           //El tipo de dato id es un integer creciente, se utiliza para registrar ids incrementales de forma automatica, ideal para usarse en claves primarias.
            $table->string('nombre_receta', 80);                                //El tipo de dato string se comporta como un varchar, el numero es para agregarle un limite de caracteres a la cadena. 
            $table->string('descripcion', 500);
            $table->string('instrucciones', 2000);
            $table->smallInteger('cantidad_personas', $unsigned = true);                          //Crea un numero integer de solo 2 bytes, sin signo
            $table->rawColumn('categoria', 'tipo_categoria');                   //Categoria y Regimen_alimenticio son dominios, y la clase blueprint no tiene un metodo para crearlos, por lo que se crean en otro archivo migrate y se les llama utilizando el metodo rawColumn
            $table->rawColumn('regimen_alimenticio', 'regimen_alimenticio'); 
            $table->foreignId('id_usuario')->constrained('users', 'id');        //Se que por defaul con el tipo de dato id, la clave primaria de la tabla usuarios seria users.id, pero como ene sta tabla el nombre del atributo es diferente, se le debe indicar la procedencia completa de la clave foranea.
        
            $table->primary(['cod_receta']);                                    //No se por que, pero smallint lo toma como priamry key, por lo que debo especificar cuales atributos son primary key.
        }); 

        Schema::create('ingrediente', function (Blueprint $table) { 
            $table->id('cod_ingrediente'); 
            $table->string('nombre', 80);      
        }); 

        Schema::create('contiene', function (Blueprint $table) { 
            $table->foreignId('cod_receta')->constrained('receta', 'cod_receta');       //A las claves foraneas se les debe indicar la tabla y el atributo de procedencia.
            $table->foreignId('cod_ingrediente')->constrained('ingrediente', 'cod_ingrediente');   //A las claves foraneas se les debe indicar la tabla y el atributo de procedencia.  
            $table->decimal('cantidad_ingrediente', 5, 2);    //Es igual al tipo de dato Numeric en postgresql, el rango de valores es de -999,99 a 999,99. 
            $table->rawColumn('unidad_medida', 'unidad_medida'); 

            $table->primary(['cod_receta', 'cod_ingrediente']); //Como la clave primaria es compuesta por 2 valores, se debe indicar los valores que la componen.
        });  

        DB::statement('ALTER TABLE "contiene" ADD CONSTRAINT valor_rango CHECK (cantidad_ingrediente >= 0 AND cantidad_ingrediente < 1000)'); //Manda una peticion a la BD para agregar una restriccion a cantidad_ingrediente para que solo sean numeros positivos.

        Schema::create('clasifica', function(Blueprint $table){
            $table->foreignId('id_usuario')->constrained('users', 'id');
            $table->foreignId('cod_receta')->constrained('receta', 'cod_receta');
            $table->id('cod_valor');
            $table->rawColumn('valoracion_receta', 'tipo_valorizacion'); 

            $table->primary(['cod_receta', 'id_usuario', 'cod_valor']); 
        });

        
} 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
        Schema::dropIfExists('receta');
        Schema::dropIfExists('ingrediente');
        Schema::dropIfExists('contiene');
        Schema::dropIfExists('clasifica');
    }
};
