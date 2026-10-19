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
    //Aqui se crean los 4 dominios que requerira la base de datos, al no haber un metodo dentro de larabel, se envia los comandos sql a postgress y se crean los dominios en la base de datos. 
    public function up(): void
    {
        //Si la creacion de tabals falla por x motivo, pero los dominios se crean, deben desmarcar esto, el comando "php artisan migrate:fresh" fallara si los 
        //dominios ya estan creados, de esta forma se borraran los dominios para recrearlos y evitar este fallo. 
        
        DB::statement("DROP DOMAIN IF EXISTS tipo_categoria");
        DB::statement("DROP DOMAIN IF EXISTS regimen_alimenticio");
        DB::statement("DROP DOMAIN IF EXISTS unidad_medida");
        DB::statement("DROP DOMAIN IF EXISTS tipo_valorizacion"); 

        DB::statement("CREATE DOMAIN tipo_categoria AS varchar NOT NULL CHECK(VALUE IN ('postres y dulces', 'platos principales', 
                        'panadería y repostería', 'carnes', 'entradas y aperitivos', 'salsas', 'sopas', 'ensaladas y guarniciones', 'bebidas y cocteles', 
                        'pescados y mariscos', 'pizzas y pastas', 'desayunos', 'plato de fondo'));");
    
        DB::statement("CREATE DOMAIN regimen_alimenticio AS varchar NOT NULL CHECK(VALUE IN ('normal', 'diabetico', 'celiaco', 'vegetariano', 'vegano'));"); 

        DB::statement("CREATE DOMAIN unidad_medida AS varchar NOT NULL CHECK(VALUE IN ('miligramos(mg)', 'gramos(g)', 'kilogramos(kg)', 'cucharada', 'litros(L)', 
                        'mililitros(ml)', 'unidades(u)'));");
        
        DB::statement("CREATE DOMAIN tipo_valorizacion AS varchar NOT NULL CHECK(VALUE IN ('Me gusta mucho', 'Me gusta', 'Indiferente', 
                        'No me gusta', 'No gusta para nada'));");
    }

    /**
     * Reverse the migrations.
     */

    //Metodos para eliminar los dominios en caso de requerirse, obvio no estaran con cascada. 
    public function down(): void
    {
        DB::statement("DROP DOMAIN IF EXISTS tipo_categoria");
        DB::statement("DROP DOMAIN IF EXISTS regimen_alimenticio");
        DB::statement("DROP DOMAIN IF EXISTS unidad_medida");
        DB::statement("DROP DOMAIN IF EXISTS tipo_valorizacion");
    }
};
